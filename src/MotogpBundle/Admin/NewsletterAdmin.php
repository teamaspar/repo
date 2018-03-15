<?php

namespace MotogpBundle\Admin;

use MotogpBundle\Entity\Customer;
use MotogpBundle\Entity\CustomerType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class NewsletterAdmin extends AbstractAdmin
{


    private $container;

    public function setContainer($container) {
        $this->container = $container;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('name')
            ->add('post')
            ->add('customerTypes')
            ->add('lastSendAt')
            ->add('_action', null, array(
                'actions' => array(
                    'edit' => array(),
                    'delete' => array(),
                ),
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {

        if (!count($this->getSubject()->getCustomerTypes())) {
            $em = $this->modelManager->getEntityManager(CustomerType::class);
            $ct = $em->getRepository(CustomerType::class)->findOneBySlug('public');

            $this->getSubject()->addCustomerType($ct);

        }


        $formMapper
            ->add('name', null, ['required' => true])
            ->add('nameEN', null, ['required' => true])
            ->add('post', null, ['required' => true])
            ->add('customerTypes', null, ['required' => true])
            ->add('actions', ChoiceType::class, array(
                'mapped' => false,
                'label' => 'Acción',
                'choices'  => array(
                    'Solo actualizar' => 'update',
                    'Actualizar y enviar' => 'update_and_send',
                ),
            ))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
        ;
    }


    public function saveHook($object) {

        $action = $this->getForm()->get('actions')->getData();

        if ($action == 'update_and_send') {
            
            $recipients = [];

            foreach ($object->getCustomerTypes() as $type) {
                $slug = $type->getSlug();
                $em = $this->modelManager->getEntityManager(CustomerType::class);
                $ct = $em->getRepository(Customer::class)->findByType($slug);
                foreach ($ct as $c) {
                    $recipients[$c->getEmail()] = $c->getName();
                }
            }
            

            $mail = $this->getConfigurationPool()->getContainer()->getParameter('general_mailing');
            $from = $this->getConfigurationPool()->getContainer()->getParameter('mailer_user');
            $templating = $this->container->get('templating');

            $data = [
                'name' => $object->getName(),
                'title' => $object->getPost()->getName(),
                'featuredMedia' => $object->getPost()->getFeaturedMedia(),
                'body' => $object->getPost()->getDescription(),
                'post' => $object->getPost()
            ];


            $html = $templating->render('MotogpBundle:Default:Newsletters/newsletters-email.html.twig', $data,'text/html');

            echo $html;
            die();

            $message = \Swift_Message::newInstance()
                ->setSubject('ANGEL NIETO TEAM - '.$object->getName())
                ->setFrom($from)
                ->setTo($recipients)
                ->setReplyTo($from)
                ->setContentType("text/html")
                ->setBody($html);


            $mailLogger = new \Swift_Plugins_Loggers_ArrayLogger();

            $this->container->get('mailer')->registerPlugin(new \Swift_Plugins_LoggerPlugin($mailLogger));

            $result = $this->container->get('mailer')->send($message);
            $spool = $this->container->get('mailer')->getTransport()->getSpool();
            $transport = $this->container->get('swiftmailer.transport.real');

            $spool->flushQueue($transport);
            

            $object->setLastSendAt(new \DateTime());
        }

    }

    public function preUpdate($object) {

        $this->saveHook($object);
    }

    public function prePersist($object) {
        $this->saveHook($object);
    }

}
