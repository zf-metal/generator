<?php

return [
    'zf-metal-datagrid.custom' => [
        "ZfMetal\Generator\Entity\Option" => [
            "sourceConfig" => [
                "type" => "doctrine",
                "doctrineOptions" => [
                    "entityName" => "\ZfMetal\Generator\Entity\Option",
                    "entityManager" => "doctrine.entitymanager.orm_zf_metal_generator"
                ]
            ],
            "columnsConfig" => [
                "module" => [
                    "type" => "relational",
                    "hidden" => true
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

