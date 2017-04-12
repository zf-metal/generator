<?php

return [
    //Entity
    "ZfMetal_Generator_Entity_Route" => [
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
];

