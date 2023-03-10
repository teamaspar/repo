<?php

namespace Application\Sonata\MediaBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class FeaturedMediaAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('description')
            ->add('enabled')
            ->add('providerName')
            ->add('providerStatus')
            ->add('providerReference')
            ->add('providerMetadata')
            ->add('width')
            ->add('height')
            ->add('length')
            ->add('contentType')
            ->add('size')
            ->add('copyright')
            ->add('authorName')
            ->add('context')
            ->add('cdnIsFlushable')
            ->add('cdnFlushIdentifier')
            ->add('cdnFlushAt')
            ->add('cdnStatus')
            ->add('updatedAt')
            ->add('createdAt')
            ->add('id')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper

            ->add('name')
            //->add('description')
            ->add('enabled')
            //->add('providerName')
            //->add('providerStatus')
            ->add('providerReference')
            //->add('providerMetadata')
            ->add('width')
            ->add('height')
            //->add('length')
            //->add('contentType')
            //->add('size')
            //->add('copyright')
            //->add('authorName')
            //->add('context')


//            ->add('cdnIsFlushable')
//            ->add('cdnFlushIdentifier')
//            ->add('cdnFlushAt')
//            ->add('cdnStatus')
//            ->add('updatedAt')
//            ->add('createdAt')
//            ->add('id')
            ->add('_action', null, array(
                'actions' => array(
                    'show' => array(),
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

        $required = ($this->getSubject() === null || $this->getSubject()->getId() === null);

        $formMapper
            ->add('description')
            ->add('descriptionEN')
            ->add('url')
            ->add('enabled')
            ->add('uploadFile', 'text', ['required' => $required])

        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name')
            ->add('description')
            ->add('enabled')
            ->add('providerName')
            ->add('providerStatus')
            ->add('providerReference')
            ->add('providerMetadata')
            ->add('width')
            ->add('height')
            ->add('length')
            ->add('contentType')
            ->add('size')
            ->add('copyright')
            ->add('authorName')
            ->add('context')
            ->add('cdnIsFlushable')
            ->add('cdnFlushIdentifier')
            ->add('cdnFlushAt')
            ->add('cdnStatus')
            ->add('updatedAt')
            ->add('createdAt')
            ->add('id')
        ;
    }


    public function deleteHook($object) {
        $object = null;
    }

    public function saveHook($object) {
        if ($object->getUploadFile()  && ($path = $object->getUploadFile())) {
            $media_sizes = getimagesize($path);
            $object->setWidth($media_sizes[0]);
            $object->setHeight($media_sizes[1]);
            $object->setBinaryContent($path);
        }
        return $object;
    }



    public function preUpdate($object) {
        //dump('preUpdate');
        $this->saveHook($object);
    }

    public function prePersist($object) {
        //dump('postPersist');
        $this->saveHook($object);
    }

}
