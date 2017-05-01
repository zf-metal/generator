<?php

namespace ZfMetal\Generator\Factory\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ActionControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = NULL) {


        /* @var $grid \CdiDataGrid\Grid */
        $grid = $container->build("zf-metal-datagrid-doctrine", ["customKey" => "ZfMetal\Generator\Entity\Action"]);
        $grid->setTemplate("ajax");
        $grid->setId("Grid_Action");
        $em = $container->get('doctrine.entitymanager.orm_zf_metal_generator');
        return new \ZfMetal\Generator\Controller\ActionController($em, $grid);
    }

}
