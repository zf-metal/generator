<?php

namespace ZfMetal\Generator\Factory\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ControllerControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = NULL) {


        /* @var $grid \CdiDataGrid\Grid */
        $grid = $container->build("zf-metal-datagrid-doctrine", ["customOptionsKey" => "ZfMetal_Generator_Entity_Controller"]);
        $grid->setTemplate("ajax");
        $grid->setId("Grid_Controller");
        $em = $container->get('doctrine.entitymanager.orm_zf_metal_generator');
        return new \ZfMetal\Generator\Controller\ControllerController($em, $grid);
    }

}
