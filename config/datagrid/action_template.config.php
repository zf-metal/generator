<?php

return [
    'zf-metal-datagrid.custom' => [
        "ZfMetal\Generator\Entity\ActionTemplate" => [
            "sourceConfig" => [
                "type" => "doctrine",
                "doctrineOptions" => [
                    "entityName" => "\ZfMetal\Generator\Entity\ActionTemplate",
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
                "actionContent" => [
                    "hidden" => true
                ],
                "viewContent" => [
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

