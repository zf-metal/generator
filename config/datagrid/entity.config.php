<?php

return [
    //Entity
    "ZfMetal_Generator_Entity_Entity" => [
        "sourceConfig" => [
            "type" => "doctrine",
            "doctrineOptions" => [
                "entityName" => "\ZfMetal\Generator\Entity\Entity",
                "entityManager" => "doctrine.entitymanager.orm_zf_metal_generator"
            ]
        ],
        "formConfig" => [
            'columns' => \ZfMetal\Commons\Consts::COLUMNS_TWO,
            'style' => \ZfMetal\Commons\Consts::STYLE_MENU_VERTICAL,
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
            "quick" => [
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

