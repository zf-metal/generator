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

