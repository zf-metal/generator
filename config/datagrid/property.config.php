<?php

return [
    'zf-metal-datagrid.custom' => [
        "ZfMetal\Generator\Entity\Property" => [
            "sourceConfig" => [
                "type" => "doctrine",
                "doctrineOptions" => [
                    "entityName" => "\ZfMetal\Generator\Entity\Property",
                    "entityManager" => "doctrine.entitymanager.orm_zf_metal_generator"
                ]
            ],
            "formConfig" => [
                'columns' => \ZfMetal\Commons\Consts::COLUMNS_TWO,
                'style' => \ZfMetal\Commons\Consts::STYLE_VERTICAL,
                'vertical_groups' => [
                    'DB' => [
                        'name', 'type', 'length', 'beUnique', 'beNullable', 'primarykey', 'autoGeneratedValue', 'relatedEntity', 'createdAt', 'updatedAt'
                    ],
                    'File' => [
                        'webpath', 'absolutepath'
                    ],
                    'Form' => [
                        'label', 'addon', 'description','elementType', 'exclude', 'hidden', 'mandatory', 'tostring'
                    ],
                    'Datagrid' => [
                        'hiddenDatagrid'
                    ],
                ]
            ],
            "columnsConfig" => [
                "createdAt" => [
                    "hidden" => true,
                ],
                "updatedAt" => [
                    "hidden" => true,
                ],
                "elementType" => [
                    "hidden" => true
                ],
                "addon" => [
                    "hidden" => true
                ],
                "absolutepath" => [
                    "hidden" => true
                ],
                "webpath" => [
                    "hidden" => true
                ],
                "description" => [
                    "hidden" => true
                ],
                "label" => [
                    "hidden" => true
                ],
                "exclude" => [
                    "hidden" => true
                ],
                "entity" => [
                    "hidden" => true
                ],
                "beNullable" => [
                    "displayName" => "Null",
                ],
                "beUnique" => [
                    "displayName" => "Unique",
                ],
                "hidden" => [
                    "hidden" => true
                ],
                "hiddenDatagrid" => [
                    "hidden" => true
                ],
                "mandatory" => [
                    "hidden" => true
                ],
                "tostring" => [
                    "hidden" => true
                ],
                "primarykey" => [
                    "hidden" => true
                ], "autoincrement" => [
                    "hidden" => true
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
    ]
];

