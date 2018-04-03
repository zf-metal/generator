<?php

return [
    'zf-metal-datagrid.custom' => [
        "ZfMetal\Generator\Entity\Module" => [
            "sourceConfig" => [
                "type" => "doctrine",
                "doctrineOptions" => [
                    "entityName" => "\ZfMetal\Generator\Entity\Module",
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
                "entities" => [
                    "hidden" => true
                ],
                "controllers" => [
                    "hidden" => true
                ],
                "path" => [
                    "hidden" => true
                ],
                "author" => [
                    "hidden" => true
                ],
                "license" => [
                    "hidden" => true
                ],
                "link" => [
                    "hidden" => true
                ],
                "admin" => [
                    "tdClass" => "text-center"
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

