<?php

namespace ZfMetal\Generator\Factory\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ViewHelperControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = NULL) {


        /* @var $grid \CdiDataGrid\Grid */
        $grid = $container->build("zf-metal-datagrid-doctrine", ["customKey" => "ZfMetal\Generator\Entity\ViewHelper"]);
        $grid->setTemplate("ajax");
        $grid->setId("Grid_ViewHelper");
        $em = $container->get('doctrine.entitymanager.orm_zf_metal_generator');
        return new \ZfMetal\Generator\Controller\ViewHelperController($em, $grid);
    }

}
