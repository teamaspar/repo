<?php

namespace MotogpBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Sonata\AdminBundle\Route\RouteCollection;

class GeneralConfigurationAdminController extends CRUDController
{

    public function listAction()
    {
        return $this->redirectToRoute('admin_motogp_generalconfiguration_edit', ['id' => 1]);
    }

    protected function configure()
    {
        parent::configure(); // TODO: Change the autogenerated stub
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('delete');
    }
}