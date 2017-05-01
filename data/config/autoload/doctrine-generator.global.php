<?php

return [
    'doctrine' => array(
        'connection' => array(
            'orm_zf_metal_generator' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOSqlite\Driver',
                'params' => array(
                    'path' => __DIR__ . '/../../data/zf-metal-generator/generator.db',
                )
            )
        ),
        'entitymanager' => array(
            'orm_zf_metal_generator' => array(
                'connection' => 'orm_zf_metal_generator',
                'configuration' => 'conf_zf_metal_generator'
            ),
        ),
        'eventmanager' => array(
            'orm_zf_metal_generator' => array(
                'subscribers' => array(
                    'Gedmo\Timestampable\TimestampableListener',
                ),
            ),
        ),
        'configuration' => array(
            'conf_zf_metal_generator' => array(
                'metadata_cache' => 'array',
                'query_cache' => 'array',
                'result_cache' => 'array',
                'driver' => 'drv_zfmetal_generator', // This driver will be defined later
                'generate_proxies' => true,
                'proxy_dir' => 'data/DoctrineORMModule/Proxy',
                'proxy_namespace' => 'DoctrineORMModule\Proxy',
                'filters' => array()
            )
        ),
        'driver' => array(
            'zfmetal_generator_entity' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'paths' => array(__DIR__ . '/../src/Entity')
            ),
            'drv_zfmetal_generator' => array(
                'class' => "Doctrine\ORM\Mapping\Driver\DriverChain",
                'drivers' => array(
                    'ZfMetal\Generator\Entity' => 'zfmetal_generator_entity',
                ),
            ),
        ),
    ),
];
