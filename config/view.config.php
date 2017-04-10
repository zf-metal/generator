<?php

namespace ZfMetal\Generator;

/**
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
return [
    'view_helpers' => array(
        'invokables' => array(
//            'CustomEntityLink' => 'ZfMetal\Generator\View\Helper\CustomEntityLink',
//            'EntityToArray' => 'ZfMetal\Generator\View\Helper\EntityToArray',
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'ZfMetal\Generator' => __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
];
