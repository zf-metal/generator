<?php

/**
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
return [
    'service_manager' => [
        'factories' => [
            'doctrine.entitymanager.orm_zf_metal_generator' => new \DoctrineORMModule\Service\EntityManagerFactory('orm_zf_metal_generator'),
        ],
    ]
];


