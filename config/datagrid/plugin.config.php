<?php

return [
    'zf-metal-datagrid.custom' => [
        "ZfMetal\Generator\Entity\Plugin" => [
            "sourceConfig" => [
                "type" => "doctrine",
                "doctrineOptions" => [
                    "entityName" => "\ZfMetal\Generator\Entity\Plugin",
                    "entityManager" => "doctrine.entitymanager.orm_zf_metal_generator"
                ]
            ],
            "columnsConfig" => [
                "module" => [
                    "type" => "relational",
                    "hidden" => true
                ],
                "generator" => [
                    "tdClass" => "text-center"
                ],
            ],
            "crudConfig" => [
                "enable" => true,
                "add" => [
                    "enable" => true,
                ],
                "edit" => [
                    "enable" => true,
                ],
                "del" => [
                    "enable" => true,
                ],
                "view" => [
                    "enable" => true,
                ],
            ],
        ],
    ]
];

