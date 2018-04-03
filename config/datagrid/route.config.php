<?php

return [
    'zf-metal-datagrid.custom' => [
        "ZfMetal\Generator\Entity\Route" => [
            "sourceConfig" => [
                "type" => "doctrine",
                "doctrineOptions" => [
                    "entityName" => "\ZfMetal\Generator\Entity\Route",
                    "entityManager" => "doctrine.entitymanager.orm_zf_metal_generator"
                ]
            ],
            "columnsConfig" => [
                "childs" => [
                    "hidden" => true
                ],
                "parent" => [
                    "type" => "relational"
                ],
                "module" => [
                    "type" => "relational",
                    "hidden" => true
                ],
                "controller" => [
                    "type" => "relational"
                ],
                "action" => [
                    "type" => "relational"
                ],
                "type" => [
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

