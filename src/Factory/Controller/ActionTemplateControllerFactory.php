<?php

namespace ZfMetal\Generator\Factory\Controller;

/**
 * ActionTemplateControllerFactory
 *
 *
 *
 * @author Cristian Incarnato
 * @license MIT
 * @link
 */
class ActionTemplateControllerFactory implements \Zend\ServiceManager\Factory\FactoryInterface
{

    public function __invoke(\Interop\Container\ContainerInterface $container, $requestedName, array $options = null)
    {
        /* @var $em \Doctrine\ORM\EntityManager */
        $em = $container->get("doctrine.entitymanager.orm_default");
        /* @var $grid \ZfMetal\Datagrid\Grid */
        $grid = $container->build("zf-metal-datagrid", ["customOptionsKey" => "ZfMetal_Generator_Entity_Action_Template"]);
        return new \ZfMetal\Generator\Controller\ActionTemplateController($em,$grid);
    }


}

