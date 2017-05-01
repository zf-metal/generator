<?php

return [
    //Entity
    'zf-metal-datagrid.custom' => [
        "ZfMetal\Generator\Entity\Action" => [
            "sourceConfig" => [
                "type" => "doctrine",
                "doctrineOptions" => [
                    "entityName" => "\ZfMetal\Generator\Entity\Action",
                    "entityManager" => "doctrine.entitymanager.orm_zf_metal_generator"
                ]
            ],
            "columnsConfig" => [
                "createdAt" => [
                    "type" => "date",
                    "displayName" => "Creado",
                    "format" => "Y-m-d H:i:s"
                ],
                "updatedAt" => [
                    "type" => "date",
                    "displayName" => "Actualizado",
                    "format" => "Y-m-d H:i:s"
                ],
                "description" => [
                    "hidden" => true
                ],
                "controller" => [
                    "hidden" => true,
                    "type" => "relational"
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

