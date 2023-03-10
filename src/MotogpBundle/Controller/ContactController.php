<?php

namespace MotogpBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use MotogpBundle\Entity\Gallery;
use MotogpBundle\Entity\Post;
use MotogpBundle\Entity\Modality;
use MotogpBundle\Entity\Rider;
use MotogpBundle\Entity\Score;
use MotogpBundle\Entity\Video;
use MotogpBundle\Entity\Sponsor;
use MotogpBundle\Entity\Circuit;
use MotogpBundle\Entity\RiderTeam;
use MotogpBundle\Entity\Team;
use MotogpBundle\Entity\TeamCategory;
use MotogpBundle\Entity\Contact;


class ContactController extends Controller
{


    /**
     *
     */
    public function contactFormAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $modalitySlug = $request->get('modality');

        $modality = $em->getRepository(Modality::class)->findOneBySlug($modalitySlug);

        $gallery  = $em->getRepository(Gallery::class)->findOneBySlug('contacto_'.str_replace('-', '_',  $modalitySlug));

        $homeRiders = $em->getRepository(Rider::class)->getHomeRidersInModality($modality);

        $ct = new Contact();

        $form = $this->createForm('MotogpBundle\Form\ContactType', $ct);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $data = array(
                'name' => $ct->getName(),
                'surname' => $ct->getSurname(),
                'phone' => $ct->getPhone(),
                'address' => $ct->getAddress(),
                'postcode' => $ct->getPostcode(),
                'subject' => $ct->getSubject(),
                'comments' => $ct->getComments(),
                'email' => $ct->getEmail(),
            );


            $mail = $this->getParameter('contact_mailing');
            $from = $this->getParameter('mailer_contact_user');


            $message = \Swift_Message::newInstance()
                ->setSubject('Formulario de contacto')
                ->setFrom($from)
                ->setTo($mail)
                ->setReplyTo($data['email'])
                ->setContentType("text/html")
                ->setBody($this->renderView('MotogpBundle:Default:Contact/contact-email.html.twig',$data,'text/html'));


            $mailLogger = new \Swift_Plugins_Loggers_ArrayLogger();
            $this->get('swiftmailer.mailer.mailer_contact')->registerPlugin(new \Swift_Plugins_LoggerPlugin($mailLogger));

            $result = $this->get('swiftmailer.mailer.mailer_contact')->send($message);
            $spool = $this->get('swiftmailer.mailer.mailer_contact')->getTransport()->getSpool();
            
            $transport = $this->get('swiftmailer.mailer.mailer_contact.transport.real');

            $spool->flushQueue($transport);


            return $this->redirectToRoute('public_contact_success', ['modality' => $modalitySlug]);
        }


        return $this->render('MotogpBundle:Default/Contact:contact-form.html.twig', array(

            'form' => $form->createView(),
            'riders' => $homeRiders,
            'gallery' => $gallery,
            'modality' => $modality,
            'team' => $this->getMainTeam()
        ));
    }


    private function getMainTeam($modality = null) {

        $em = $this->getDoctrine()->getManager();
        $team  = $em->getRepository(RiderTeam::class)->findMain();

        return $team;
    }



    public function contactFormSuccessAction(Request $request) {

        $modalitySlug = $request->get('modality');

        $em = $this->getDoctrine()->getManager();

        $modality = $em->getRepository(Modality::class)->findOneBySlug($modalitySlug);

        $gallery  = $em->getRepository(Gallery::class)->findOneBySlug('contacto_'.str_replace('-', '_',  $modalitySlug));

        $homeRiders = $em->getRepository(Rider::class)->findHomeRiders();


        return $this->render('MotogpBundle:Default/Contact:contact-success.html.twig', array(
            'riders' => $homeRiders,
            'gallery' => $gallery,
            'modality' => $modality,
            'team' => $this->getMainTeam()
        ));
    }


    /**
     *
     */
    public function registerFormAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $modalitySlug = $request->get('modality');

        $modality = $em->getRepository(Modality::class)->findOneBySlug($modalitySlug);

        $gallery  = $em->getRepository(Gallery::class)->findOneBySlug('register_'.str_replace('-', '_',  $modalitySlug));

        $homeRiders = $em->getRepository(Rider::class)->getHomeRidersInModality($modality);

        $ct = new Contact();

        $form = $this->createForm('MotogpBundle\Form\RegisterType', $ct);
        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {

//            $data = array(
//                'name' => $ct->getName(),
//                'surname' => $ct->getSurname(),
//                'phone' => $ct->getPhone(),
//                'address' => $ct->getAddress(),
//                'postcode' => $ct->getPostcode(),
//                'subject' => $ct->getSubject(),
//                'comments' => $ct->getComments(),
//                'email' => $ct->getEmail(),
//            );


//            $mail = $this->getParameter('general_mailing');
//            $from = $this->getParameter('mailer_user');
//
//            $message = \Swift_Message::newInstance()
//                ->setSubject('Formulario de contacto')
//                ->setFrom($from)
//                ->setTo($mail)
//                ->setReplyTo($data['email'])
//                ->setContentType("text/html")
//                ->setBody($this->renderView('MotogpBundle:Default:Contact/contact-email.html.twig',$data,'text/html'));
//
//
//            $mailLogger = new \Swift_Plugins_Loggers_ArrayLogger();
//            $this->get('mailer')->registerPlugin(new \Swift_Plugins_LoggerPlugin($mailLogger));
//
//            $result = $this->get('mailer')->send($message);
//            $spool = $this->get('mailer')->getTransport()->getSpool();
//            $transport = $this->get('swiftmailer.transport.real');
//
//            $spool->flushQueue($transport);
//
//
//            return $this->redirectToRoute('public_contact_success', ['modality' => $modalitySlug]);
        }


        return $this->render('MotogpBundle:Default/Register:register-form.html.twig', array(

            'form' => $form->createView(),
            'riders' => $homeRiders,
            'gallery' => $gallery,
            'modality' => $modality,
            'team' => $this->getMainTeam()
        ));
    }

}
