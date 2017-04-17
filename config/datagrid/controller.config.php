<?php

return [
    //Entity
    "ZfMetal_Generator_Entity_Controller" => [
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

