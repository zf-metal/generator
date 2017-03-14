<?php

return [
    //Entity
    "ZfMetal\Generator_Entity" => [
        "sourceConfig" => [
            "type" => "doctrine",
            "doctrineOptions" => [
                "entityName" => "\ZfMetal\Generator\Entity\Entity",
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
            "properties" => [
                "hidden" => true
            ],
            "path" => [
                "hidden" => true
            ],
            "PROPERTIES" => [
                "tdClass" => "text-center"
            ],
             "GENERATOR" => [
                "tdClass" => "text-center"
            ]
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

