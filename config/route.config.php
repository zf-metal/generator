<?php

namespace ZfMetal\Generator;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

/**
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
return [
    'router' => array(
        'routes' => array(
            'ZfMetal_Generator' => array(
                'type' => Literal::class,
                'may_terminate' => false,
                'options' => array(
                    'route' => '/generator',
                ),
                'child_routes' => [
                    'Main' => array(
                        'type' => Segment::class,
                        'may_terminate' => true,
                        'options' => array(
                            'route' => '/main[/:moduleId]',
                            'defaults' => array(
                                'controller' => Controller\MainController::class,
                                'action' => 'index',
                            ),
                        ),
                    ),
                    'Module' => array(
                        'type' => Literal::class,
                        'may_terminate' => true,
                        'options' => array(
                            'route' => '/module',
                            'defaults' => array(
                                'controller' => Controller\ModuleController::class,
                                'action' => 'index',
                            ),
                        ),
                        'child_routes' => [
                            'ABM' => array(
                                'type' => Segment::class,
                                'options' => array(
                                    'route' => '/abm/:id',
                                    'defaults' => array(
                                        'controller' => Controller\AbmController::class,
                                        'action' => 'index',
                                    ),
                                ),
                            ),
                            'Manage' => array(
                                'type' => Segment::class,
                                'options' => array(
                                    'route' => '/manage/:moduleId',
                                    'defaults' => array(
                                        'controller' => Controller\ModuleController::class,
                                        'action' => 'manage',
                                    ),
                                ),
                            ),
                            'Entity' => array(
                                'type' => Literal::class,
                                'may_terminate' => false,
                                'options' => array(
                                    'route' => '/entity',
                                ),
                                'child_routes' => [
                                    'Main' => array(
                                        'type' => Segment::class,
                                        'options' => array(
                                            'route' => '/main/:moduleId',
                                            'defaults' => array(
                                                'controller' => Controller\EntityController::class,
                                                'action' => 'main',
                                            ),
                                        ),
                                    ),
                                    'Property' => array(
                                        'type' => Segment::class,
                                        'options' => array(
                                            'route' => '/property/:entityId',
                                            'defaults' => array(
                                                'controller' => Controller\PropertyController::class,
                                                'action' => 'entity',
                                            ),
                                        ),
                                    ),
                                    'Generator' => array(
                                        'type' => Segment::class,
                                        'options' => array(
                                            'route' => '/generator/:entityId',
                                            'defaults' => array(
                                                'controller' => Controller\GeneratorController::class,
                                                'action' => 'entity',
                                            ),
                                        ),
                                    ),
                                ]
                            ),
                            'Route' => array(
                                'type' => Literal::class,
                                'options' => array(
                                    'route' => '/route',
                                    'defaults' => array(
                                        'controller' => Controller\RouteController::class,
                                        'action' => 'main',
                                    ),
                                ),
                                'child_routes' => [
                                    'Main' => array(
                                        'type' => Segment::class,
                                        'options' => array(
                                            'route' => '/main/:moduleId',
                                            'defaults' => array(
                                                'controller' => Controller\RouteController::class,
                                                'action' => 'main',
                                            ),
                                        ),
                                    ),
                                    'Json' => array(
                                        'type' => Segment::class,
                                        'options' => array(
                                            'route' => '/json/:moduleId',
                                            'defaults' => array(
                                                'controller' => Controller\RouteController::class,
                                                'action' => 'json',
                                            ),
                                        ),
                                    ),
                                    'Childs' => array(
                                        'type' => Segment::class,
                                        'options' => array(
                                            'route' => '/childs/:routeId',
                                            'defaults' => array(
                                                'controller' => Controller\RouteController::class,
                                                'action' => 'childs',
                                            ),
                                        ),
                                    ),
                                    'Grid' => array(
                                        'type' => Segment::class,
                                        'options' => array(
                                            'route' => '/grid/:moduleId',
                                            'defaults' => array(
                                                'controller' => Controller\RouteController::class,
                                                'action' => 'grid',
                                            ),
                                        ),
                                    ),
                                    'CreateForm' => array(
                                        'type' => Segment::class,
                                        'options' => array(
                                            'route' => '/create-form/:moduleId[/:routeParentId]',
                                            'defaults' => array(
                                                'controller' => Controller\RouteController::class,
                                                'action' => 'create-form',
                                            ),
                                        ),
                                    ),
                                    'Create' => array(
                                        'type' => Segment::class,
                                        'options' => array(
                                            'route' => '/create',
                                            'defaults' => array(
                                                'controller' => Controller\RouteController::class,
                                                'action' => 'create',
                                            ),
                                        ),
                                    ),
                                    'EditForm' => array(
                                        'type' => Segment::class,
                                        'options' => array(
                                            'route' => '/edit-form/:routeId',
                                            'defaults' => array(
                                                'controller' => Controller\RouteController::class,
                                                'action' => 'edit-form',
                                            ),
                                        ),
                                    ),
                                    'Edit' => array(
                                        'type' => Segment::class,
                                        'options' => array(
                                            'route' => '/edit/:routeId',
                                            'defaults' => array(
                                                'controller' => Controller\RouteController::class,
                                                'action' => 'edit',
                                            ),
                                        ),
                                    ),
                                    'Delete' => array(
                                        'type' => Segment::class,
                                        'options' => array(
                                            'route' => '/delete/:routeId',
                                            'defaults' => array(
                                                'controller' => Controller\RouteController::class,
                                                'action' => 'delete',
                                            ),
                                        ),
                                    ),
                                    'Generator' => array(
                                        'type' => Segment::class,
                                        'options' => array(
                                            'route' => '/generate/:moduleId',
                                            'defaults' => array(
                                                'controller' => Controller\GeneratorController::class,
                                                'action' => 'route',
                                            ),
                                        ),
                                    ),
                                ]
                            ),
                            'Navigation' => array(
                                'type' => Literal::class,
                                'options' => array(
                                    'route' => '/nav',
                                    'defaults' => array(
                                        'controller' => Controller\NavigationController::class,
                                        'action' => 'main',
                                    ),
                                ),
                                'child_routes' => [
                                    'Main' => array(
                                        'type' => Segment::class,
                                        'options' => array(
                                            'route' => '/main/:moduleId',
                                            'defaults' => array(
                                                'controller' => Controller\NavigationController::class,
                                                'action' => 'main',
                                            ),
                                        ),
                                    ),
                                    'Json' => array(
                                        'type' => Segment::class,
                                        'options' => array(
                                            'route' => '/json/:moduleId',
                                            'defaults' => array(
                                                'controller' => Controller\NavigationController::class,
                                                'action' => 'json',
                                            ),
                                        ),
                                    ),
                                    'Childs' => array(
                                        'type' => Segment::class,
                                        'options' => array(
                                            'route' => '/childs/:navId',
                                            'defaults' => array(
                                                'controller' => Controller\NavigationController::class,
                                                'action' => 'childs',
                                            ),
                                        ),
                                    ),
                                    'Grid' => array(
                                        'type' => Segment::class,
                                        'options' => array(
                                            'route' => '/grid/:moduleId',
                                            'defaults' => array(
                                                'controller' => Controller\NavigationController::class,
                                                'action' => 'grid',
                                            ),
                                        ),
                                    ),
                                    'CreateForm' => array(
                                        'type' => Segment::class,
                                        'options' => array(
                                            'route' => '/create-form/:moduleId[/:navParentId]',
                                            'defaults' => array(
                                                'controller' => Controller\NavigationController::class,
                                                'action' => 'create-form',
                                            ),
                                        ),
                                    ),
                                    'Create' => array(
                                        'type' => Segment::class,
                                        'options' => array(
                                            'route' => '/create',
                                            'defaults' => array(
                                                'controller' => Controller\NavigationController::class,
                                                'action' => 'create',
                                            ),
                                        ),
                                    ),
                                    'EditForm' => array(
                                        'type' => Segment::class,
                                        'options' => array(
                                            'route' => '/edit-form/:navId',
                                            'defaults' => array(
                                                'controller' => Controller\NavigationController::class,
                                                'action' => 'edit-form',
                                            ),
                                        ),
                                    ),
                                    'Edit' => array(
                                        'type' => Segment::class,
                                        'options' => array(
                                            'route' => '/edit/:navId',
                                            'defaults' => array(
                                                'controller' => Controller\NavigationController::class,
                                                'action' => 'edit',
                                            ),
                                        ),
                                    ),
                                    'Delete' => array(
                                        'type' => Segment::class,
                                        'options' => array(
                                            'route' => '/delete/:navId',
                                            'defaults' => array(
                                                'controller' => Controller\NavigationController::class,
                                                'action' => 'delete',
                                            ),
                                        ),
                                    ),
                                    'Generator' => array(
                                        'type' => Segment::class,
                                        'options' => array(
                                            'route' => '/generate/:moduleId',
                                            'defaults' => array(
                                                'controller' => Controller\GeneratorController::class,
                                                'action' => 'navigation',
                                            ),
                                        ),
                                    ),
                                ]
                            ),
                            'Controller' => array(
                                'type' => Segment::class,
                                'options' => array(
                                    'route' => '/controller',
                                    'defaults' => array(
                                        'controller' => Controller\ControllerController::class,
                                        'action' => 'main',
                                    ),
                                ),
                                'child_routes' => [
                                    'Main' => array(
                                        'type' => Segment::class,
                                        'options' => array(
                                            'route' => '/main/:moduleId',
                                            'defaults' => array(
                                                'controller' => Controller\ControllerController::class,
                                                'action' => 'main',
                                            ),
                                        ),
                                    ),
                                    'Action' => array(
                                        'type' => Segment::class,
                                        'options' => array(
                                            'route' => '/action/:controllerId',
                                            'defaults' => array(
                                                'controller' => Controller\ActionController::class,
                                                'action' => 'controller',
                                            ),
                                        ),
                                    ),
                                    'Commons' => array(
                                        'type' => Segment::class,
                                        'options' => array(
                                            'route' => '/commons/:controllerId',
                                            'defaults' => array(
                                                'controller' => Controller\ControllerCommonsController::class,
                                                'action' => 'controller',
                                            ),
                                        ),
                                    ),
                                    'Generator' => array(
                                        'type' => Segment::class,
                                        'options' => array(
                                            'route' => '/generator/:controllerId',
                                            'defaults' => array(
                                                'controller' => Controller\GeneratorController::class,
                                                'action' => 'controller',
                                            ),
                                        ),
                                    ),
                                ]
                            ),
                            'Options' => array(
                                'type' => Segment::class,
                                'options' => array(
                                    'route' => '/option',
                                    'defaults' => array(
                                        'controller' => Controller\OptionController::class,
                                        'action' => 'main',
                                    ),
                                ),
                                'child_routes' => [
                                    'Main' => array(
                                        'type' => Segment::class,
                                        'options' => array(
                                            'route' => '/main/:moduleId',
                                            'defaults' => array(
                                                'controller' => Controller\OptionController::class,
                                                'action' => 'main',
                                            ),
                                        ),
                                    ),
                                    'Generator' => array(
                                        'type' => Segment::class,
                                        'options' => array(
                                            'route' => '/generator/:moduleId',
                                            'defaults' => array(
                                                'controller' => Controller\GeneratorController::class,
                                                'action' => 'option',
                                            ),
                                        ),
                                    ),
                                ]
                            ),
                            'Plugin' => array(
                                'type' => Segment::class,
                                'options' => array(
                                    'route' => '/plugin',
                                    'defaults' => array(
                                        'controller' => Controller\PluginController::class,
                                        'action' => 'main',
                                    ),
                                ),
                                'child_routes' => [
                                    'Main' => array(
                                        'type' => Segment::class,
                                        'options' => array(
                                            'route' => '/main/:moduleId',
                                            'defaults' => array(
                                                'controller' => Controller\PluginController::class,
                                                'action' => 'main',
                                            ),
                                        ),
                                    ),
                                    'Generator' => array(
                                        'type' => Segment::class,
                                        'options' => array(
                                            'route' => '/generator/:pluginId',
                                            'defaults' => array(
                                                'controller' => Controller\GeneratorController::class,
                                                'action' => 'plugin',
                                            ),
                                        ),
                                    ),
                                ]
                            ),
                        ]
                    ),
                ],
            ),
        ),
    ),
];
