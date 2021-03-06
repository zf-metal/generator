<?php

return [
    'zf-metal-datagrid.custom' => [
        "ZfMetal\Generator\Entity\Entity" => [
            "sourceConfig" => [
                "type" => "doctrine",
                "doctrineOptions" => [
                    "entityName" => "\ZfMetal\Generator\Entity\Entity",
                    "entityManager" => "doctrine.entitymanager.orm_zf_metal_generator"
                ]
            ],
            "formConfig" => [
                'columns' => \ZfMetal\Commons\Consts::COLUMNS_TWO,
                'style' => \ZfMetal\Commons\Consts::STYLE_VERTICAL,
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
                "customOnTable" => [
                    "hidden" => true
                ],
                "extends" => [
                    "hidden" => true
                ],
                "module" => [
                    "hidden" => true
                ],
                "properties" => [
                    "hidden" => true
                ],
                "path" => [
                    "hidden" => true
                ],
                "property-list" => [
                    "tdClass" => "text-center"
                ],
                "generator" => [
                    "tdClass" => "text-center"
                ],
                "generateId" => [
                    "hidden" => true
                ]
            ],
            "crudConfig" => [
                "enable" => true,
                "add" => [
                    "enable" => true,
                    "class" => " glyphicon glyphicon-plus cursor-pointer",
                    "value" => " Agregar"
                ],
                "edit" => [
                    "enable" => true,
                    "class" => " glyphicon glyphicon-edit fa-xs cursor-pointer",
                    "value" => ""
                ],
                "del" => [
                    "enable" => true,
                    "class" => " glyphicon glyphicon-trash cursor-pointer",
                    "value" => ""
                ],
                "view" => [
                    "enable" => true,
                    "class" => " glyphicon glyphicon-list-alt cursor-pointer",
                    "value" => ""
                ],
            ],
        ],
    ]
];

