<?php

namespace ZfMetal\Generator;

/**
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
return [
    'view_manager' => array(
        'template_map' => [
            'generator/layout' => __DIR__ . '/../view/zf-metal/generator/layout/layout.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
    'view_helpers' => array(
        'invokables' => array(
        )
    ),
];
