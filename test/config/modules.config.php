<?php

/**
 * List of enabled modules for this application.
 *
 * This should be an array of module namespaces used in the application.
 */
return [
    'Zend\Router',
    'Zend\Validator',
    'Zend\I18n',
    "DoctrineModule",
    'DoctrineORMModule',
    'SwissEngine\Tools\Doctrine\Extension',
    'ZfMetal\Commons',
    'ZfMetal\Datagrid',
    'ZfMetal\Generator'
];
