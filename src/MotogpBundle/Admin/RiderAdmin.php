<?php

namespace MotogpBundle\Admin;

use MotogpBundle\Admin\Media\FeaturedMediaAdminTrait;
use MotogpBundle\Admin\Media\HasMediasAdminTrait;
use MotogpBundle\Admin\Media\HomeImageAdminTrait;
use MotogpBundle\Admin\Media\LogoAdminTrait;
use MotogpBundle\Admin\Media\PreviewImageAdminTrait;
use MotogpBundle\Admin\Media\QuotationImageAdminTrait;
use MotogpBundle\Admin\Media\TeamStaffImageAdminTrait;
use MotogpBundle\Entity\RiderTeam;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Sonata\AdminBundle\Route\RouteCollection;
use Cocur\Slugify\Slugify;

class RiderAdmin extends AbstractAdmin
{
    
    use HasMediasAdminTrait,
        FeaturedMediaAdminTrait,
        LogoAdminTrait,
        HomeImageAdminTrait,
        PreviewImageAdminTrait,
        QuotationImageAdminTrait,
        TeamStaffImageAdminTrait
    ;

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('modality')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            //->add('id')
            ->add('name')
            ->add('surname')
            ->add('modality')
            ->add('moto')
            ->add('order', null, array('editable' => true))
            ->add('modalityClassification', null, ['editable' => true])
            ->add('showInHome', null, array('editable' => true, 'label' => 'Mostrar en inicio'))
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

        
        $formMapper
            ->tab('Informaci??n')
            ->with(null)
            ->add('name', 'text', ['attr' => ['container_classes' => 'col-md-5'],])
            ->add('surname', 'text',['attr' => ['container_classes' => 'col-md-5'],])
            ->add('number', 'number',['attr' => ['container_classes' => 'col-md-2'],])
            ->add('birthDate', 'sonata_type_date_picker', [
                'label' => 'Fecha de nacimiento',
                'format'=>'dd/MM/yyyy',
                'attr' => ['container_classes' => 'col-md-4'],
            ])
            ->add('birthPlace', null, ['label' => 'Lugar de nacimiento',
                'attr' => ['container_classes' => 'col-md-4'],
            ])
            ->add('country', CountryType::class, ['label' => 'Pa??s',
                'attr' => ['container_classes' => 'col-md-4'],
            ])
            ->add('modality', null, ['label' => 'Modalidad', 'required' => true, 'attr' => ['container_classes' => 'col-md-4']])
            ->add('modalityClassification', null, ['required' => false, 'attr' => ['container_classes' => 'col-md-4']])
            ->add('moto', null, ['required' => true, 'attr' => ['container_classes' => 'col-md-4']])

            ->add('_order', null, ['attr' => ['container_classes' => 'col-md-3']])
            ->add('showInHome', 'checkbox', [
                'label' => 'Mostrar en inicio',
                'required' => false,
                'attr' => ['container_classes' => 'col-md-6'
                ]])
            ->add('riderTeam', null,
                [
                    'class' => RiderTeam::class,
                    'query_builder' => function ($qb) {
                        $b = $qb->createQueryBuilder('s')->where('s.main = :m')
                            ->setParameter('m', '1')

                        ;

                       return $b;
                    },
                    'required' => true,
                    'attr' => ['container_classes' => 'hidden']
                ], ['admin_code' => 'motogp.admin.rider_team']
            )
            
            ->end()
            ->end()
            ->tab('Biograf??a')
            ->with(null)
            ->add('description', 'ckeditor', ['label' => 'Biograf??a'])
            ->add('descriptionEN', 'ckeditor', ['label' => 'Biograf??a (Ingl??s)'])
            ->add('firstRace', null, [
                'attr' => ['container_classes' => 'col-md-6'],
                'label' => 'Primera carrera'])
            ->add('firstGrandPrix', null, [
                'attr' => ['container_classes' => 'col-md-6'],
                'label' => 'Primer gran premio'])
            ->add('firstVictory', null, [
                'attr' => ['container_classes' => 'col-md-6'],
                'label' => 'Primera victoria'])
            ->add('lastVictory', null, [
                'attr' => ['container_classes' => 'col-md-6'],
                'label' => '??ltima victoria'])
            ->add('firstPole', null, [
                'attr' => ['container_classes' => 'col-md-6'],
                'label' => 'Primera Pole'])
            ->add('firstFastLap', null, [
                'attr' => ['container_classes' => 'col-md-6'],
                'label' => 'Primera vuelta r??pida'])
            ->add('firstPodium', null, [
                'attr' => ['container_classes' => 'col-md-6'],
                'label' => 'Primer Podio'])
            ->add('podiums', null, [
                'attr' => ['container_classes' => 'col-md-6'],
                'label' => 'Podios'])
            ->add('victorys', null, [
                'attr' => ['container_classes' => 'col-md-6'],
                'label' => 'Victorias'])
            ->add('poles', null, [
                'attr' => ['container_classes' => 'col-md-6'],
                'label' => 'Poles'])
            ->add('fastLaps', null, [
                'attr' => ['container_classes' => 'col-md-6'],
                'label' => 'Vueltas r??pidas'])
            ->add('bestGeneralResult', null, [
                'attr' => ['container_classes' => 'col-md-6'],
                'label' => 'Mejor resultado general'])
            ->add('gpss', null, [
                'attr' => ['container_classes' => 'col-md-6'],
                'label' => 'N?? total de GPS disputados'])
            ->add('firstRaceEN', null, [
                'attr' => ['container_classes' => 'col-md-6'],
                'label' => 'Primera carrera (EN)'])
            ->add('firstGrandPrixEN', null, [
                'attr' => ['container_classes' => 'col-md-6'],
                'label' => 'Primer gran premio (EN)'])
            ->add('firstVictoryEN', null, [
                'attr' => ['container_classes' => 'col-md-6'],
                'label' => 'Primera victoria (EN)'])
            ->add('lastVictoryEN', null, [
                'attr' => ['container_classes' => 'col-md-6'],
                'label' => '??ltima victoria (EN)'])
            ->add('firstPoleEN', null, [
                'attr' => ['container_classes' => 'col-md-6'],
                'label' => 'Primera pole (EN)'])
            ->add('firstFastLapEN', null, [
                'attr' => ['container_classes' => 'col-md-6'],
                'label' => 'Primera vuelta r??pida(EN)'])
            ->add('firstPodiumEN', null, [
                'attr' => ['container_classes' => 'col-md-6'],
                'label' => 'Primer podio(EN)'])
            ->add('podiumsEN', null, [
                'attr' => ['container_classes' => 'col-md-6'],
                'label' => 'Podios (EN)'])
            ->add('victorysEN', null, [
                'attr' => ['container_classes' => 'col-md-6'],
                'label' => 'Victorias (EN)'])
            ->add('polesEN', null, [
                'attr' => ['container_classes' => 'col-md-6'],
                'label' => 'Poles (EN)'])
            ->add('fastLapsEN', null, [
                'attr' => ['container_classes' => 'col-md-6'],
                'label' => 'Vueltas r??pidas(EN)'])
            ->add('bestGeneralResultEN', null, [
                'attr' => ['container_classes' => 'col-md-6'],
                'label' => 'Mejor resultado general(EN)'])
            ->add('gpssEN', null, [
                'attr' => ['container_classes' => 'col-md-6'],
                'label' => 'N?? total de GPS disputados (EN) '])
            ->end()
            ->end()
            ->tab('Palmar??s')
            ->with(null)
            ->add('records','sonata_type_collection',
                [
                    'label' => 'Palmar??s',
                ],
                [
                    'edit' => 'inline',
                    'inline' => 'table'
                ]
            )
            ->end()
            ->end()
            ->tab('Campeonatos')
            ->with(null)
            ->add('championships','sonata_type_collection',
                [
                    'label' => 'Campeonatos',
                ],
                [
                    'edit' => 'inline',
                    'inline' => 'table'
                ]
            )
            ->end()
            ->end()
            ->tab('Im??genes')
            ->with(null)
                ->add('featuredMedia', 'sonata_type_admin', array(
                    'label' => 'Im??gen de portada',
                    'required' => false,
                    'attr' => ['container_classes' => 'clearfix col-md-4']
                ))
                ->add('homeImage', 'sonata_type_admin', array(
                    'label' => 'Im??gen home',
                    'required' => false,
                    'attr' => ['container_classes' => 'clearfix col-md-4']
                ))
                ->add('logo', 'sonata_type_admin', array(
                    'label' => 'Logotipo',
                    'required' => false,
                    'attr' => ['container_classes' => 'clearfix col-md-4']
                ))
                ->add('previewImage', 'sonata_type_admin', array(
                    'label' => 'Im??gen home (galer??as)',
                    'required' => false,
                    'attr' => ['container_classes' => 'clearfix col-md-4']
                ))
                ->add('quotationImage', 'sonata_type_admin', array(
                    'label' => 'Im??gen Newsletters',
                    'required' => false,
                    'attr' => ['container_classes' => 'clearfix col-md-4']
                ))
                ->add('teamStaffImage', 'sonata_type_admin', array(
                    'label' => 'Im??gen Team-Staff',
                    'required' => false,
                    'attr' => ['container_classes' => 'clearfix col-md-4']
                ))
                ->add('medias', 'sonata_type_collection',['label' => 'Im??genes (slider)',],
                    [
                        'edit' => 'inline',
                        'inline' => 'table',
                    ]
                )
            ->end()
            ->end()
            ->tab('SEO')
            ->with(null)
            ->add('seoTitle')
            ->add('seoTitleEN')
            ->add('seoKeywords')
            ->add('seoKeywordsEN')
            ->add('facebook')
            ->add('twitter')
            ->add('instagram')
            ->end()
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('name')
            ->add('nameEN')
            ->add('description')
            ->add('descriptionEN')
            ->add('seoTitle')
            ->add('seoTitleEN')
            ->add('seoKeywords')
            ->add('seoKeywordsEN')
            ->add('_order')
            ->add('createdAt')
            ->add('updatedAt')
        ;
    }


    public function saveHook($object) {

        $slugify = new Slugify();

        $name = $object->getName().' '.$object->getSurname().$object->getNumber();

        $object->setSlug($slugify->slugify($name, '-'));

        $this->saveMedias($object, 'motogp.admin.rider_media');
        $this->saveLogo($object);
        $this->saveFeaturedMedia($object);
        $this->saveHomeImage($object);
        $this->savePreviewImage($object);
        $this->saveQuotationImage($object);
        $this->saveTeamStaffImage($object);

        $object->setExternal(false);


        foreach ($object->getRecords() as $r) {
            $r->setRider($object);
        }

        foreach ($object->getChampionships() as $r) {
            $r->setRider($object);
        }

    }

    public function preUpdate($object) {
        $this->saveHook($object);
    }

    public function prePersist($object) {
        $this->saveHook($object);
    }

    public function getFormTheme()
    {
        return array_merge(
            parent::getFormTheme(),
            array('MotogpBundle:Admin:admin.theme.html.twig')
        );
    }

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $query->innerJoin($query->getRootAliases()[0] . '.riderTeam', 'r')
            ->andWhere('r.main = :m')
            ->setParameter('m', '1');
        return $query;
    }

}
