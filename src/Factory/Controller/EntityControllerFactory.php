<?php

namespace ZfMetal\Generator\Factory\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class EntityControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = NULL) {


        /* @var $grid \CdiDataGrid\Grid */
        $grid = $container->build("CdiDatagridDoctrine", ["customOptionsKey" => "ZfMetal\Generator_Entity"]);
        $grid->setTemplate("ajax");
        $grid->setId("CdiGrid_Entity");
        $em = $container->get('doctrine.entitymanager.orm_zf_metal_generator');
        return new \ZfMetal\Generator\Controller\EntityController($em, $grid);
    }

}
