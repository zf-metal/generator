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
            'ZfMetal\Generator' => array(
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
                                'type' => Segment::class,
                                'options' => array(
                                    'route' => '/entity/:moduleId',
                                    'defaults' => array(
                                        'controller' => Controller\EntityController::class,
                                        'action' => 'module',
                                    ),
                                ),
                            ),
                            'Entity_Property' => array(
                                'type' => Segment::class,
                                'options' => array(
                                    'route' => '/entity/property/:entityId',
                                    'defaults' => array(
                                        'controller' => Controller\PropertyController::class,
                                        'action' => 'entity',
                                    ),
                                ),
                            ),
                            'Entity_Generator' => array(
                                'type' => Segment::class,
                                'options' => array(
                                    'route' => '/entity/generator/:entityId',
                                    'defaults' => array(
                                        'controller' => Controller\GeneratorController::class,
                                        'action' => 'entity',
                                    ),
                                ),
                            ),
                            'Route' => array(
                                'type' => Segment::class,
                                'options' => array(
                                    'route' => '/route/:moduleId',
                                    'defaults' => array(
                                        'controller' => Controller\RouteController::class,
                                        'action' => 'main',
                                    ),
                                ),
                            ),
                            'Route_Childs' => array(
                                'type' => Segment::class,
                                'options' => array(
                                    'route' => '/route/childs/:routeId',
                                    'defaults' => array(
                                        'controller' => Controller\RouteController::class,
                                        'action' => 'childs',
                                    ),
                                ),
                            ),
                             'Route_Grid' => array(
                                'type' => Segment::class,
                                'options' => array(
                                    'route' => '/route/grid/:moduleId',
                                    'defaults' => array(
                                        'controller' => Controller\RouteController::class,
                                        'action' => 'grid',
                                    ),
                                ),
                            ),
                            'Controller' => array(
                                'type' => Segment::class,
                                'options' => array(
                                    'route' => '/controller/:moduleId',
                                    'defaults' => array(
                                        'controller' => Controller\ControllerController::class,
                                        'action' => 'main',
                                    ),
                                ),
                            ),
                            'Controller_Action' => array(
                                'type' => Segment::class,
                                'options' => array(
                                    'route' => '/controller/action/:controllerId',
                                    'defaults' => array(
                                        'controller' => Controller\ActionController::class,
                                        'action' => 'controller',
                                    ),
                                ),
                            ),
                            'Controller_Commons' => array(
                                'type' => Segment::class,
                                'options' => array(
                                    'route' => '/controller/commons/:controllerId',
                                    'defaults' => array(
                                        'controller' => Controller\ControllerCommonsController::class,
                                        'action' => 'controller',
                                    ),
                                ),
                            ),
                            'Controller_Generator' => array(
                                'type' => Segment::class,
                                'options' => array(
                                    'route' => '/controller/generator/:controllerId',
                                    'defaults' => array(
                                        'controller' => Controller\GeneratorController::class,
                                        'action' => 'controller',
                                    ),
                                ),
                            ),
                        ]
                    ),
                ],
            ),
        ),
    ),
];
