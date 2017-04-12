<?php

namespace ZfMetal\Generator;

/**
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
return [
    'zfc_rbac' => [
        'guards' => [
            'ZfcRbac\Guard\RouteGuard' => [
                'ZfMetal\Generator_*' => ['guest'],
            ],
        ]
    ]
];
