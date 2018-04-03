<?php

return [
    'zf-metal-datagrid.custom' => [
        "ZfMetal\Generator\Entity\Controller" => [
            "sourceConfig" => [
                "type" => "doctrine",
                "doctrineOptions" => [
                    "entityName" => "\ZfMetal\Generator\Entity\Controller",
                    "entityManager" => "doctrine.entitymanager.orm_zf_metal_generator"
                ]
            ],
            "columnsConfig" => [
                "actions" => [
                    "hidden" => true
                ],
                "module" => [
                    "type" => "relational",
                    "hidden" => true
                ],
                "entity" => [
                    "type" => "relational"
                ],
                "commons" => [
                    "type" => "relational",
                    "hidden" => true
                ],
                "action-list" => [
                    "tdClass" => "text-center"
                ],
                "quick" => [
                    "tdClass" => "text-center"
                ],
                "generator" => [
                    "tdClass" => "text-center"
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

