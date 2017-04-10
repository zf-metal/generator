<?php

namespace ZfMetal\Generator;

/**
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
return array(
    'controllers' => [
        'factories' => [
            \ZfMetal\Generator\Controller\MainController::class => \ZfMetal\Generator\Factory\Controller\MainControllerFactory::class,
            \ZfMetal\Generator\Controller\ModuleController::class => \ZfMetal\Generator\Factory\Controller\ModuleControllerFactory::class,
            \ZfMetal\Generator\Controller\EntityController::class => \ZfMetal\Generator\Factory\Controller\EntityControllerFactory::class,
            \ZfMetal\Generator\Controller\PropertyController::class => \ZfMetal\Generator\Factory\Controller\PropertyControllerFactory::class,
            \ZfMetal\Generator\Controller\AbmController::class => \ZfMetal\Generator\Factory\Controller\AbmControllerFactory::class,
            \ZfMetal\Generator\Controller\GeneratorController::class => \ZfMetal\Generator\Factory\Controller\GeneratorControllerFactory::class,
            \ZfMetal\Generator\Controller\RouteController::class => \ZfMetal\Generator\Factory\Controller\RouteControllerFactory::class,
            \ZfMetal\Generator\Controller\ControllerController::class => \ZfMetal\Generator\Factory\Controller\ControllerControllerFactory::class,
            \ZfMetal\Generator\Controller\ActionController::class => \ZfMetal\Generator\Factory\Controller\ActionControllerFactory::class,
            \ZfMetal\Generator\Controller\ControllerCommonsController::class => \ZfMetal\Generator\Factory\Controller\ControllerCommonsControllerFactory::class,
            \ZfMetal\Generator\Controller\NavigationController::class => \ZfMetal\Generator\Factory\Controller\NavigationControllerFactory::class,
            \ZfMetal\Generator\Controller\OptionController::class => \ZfMetal\Generator\Factory\Controller\OptionControllerFactory::class,
        ],
    ]
);
