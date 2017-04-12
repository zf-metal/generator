<?php

return [
    //MODULE
    "ZfMetal_Generator_Entity_Module" => [
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

