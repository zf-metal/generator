<?php

namespace ZfMetal\Generator;

class Module {

    public function init() {
        
    }

    public function getConfig() {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getModuleDependencies()
    {
        return array( 'Zend\Router',  'Zend\Validator',  'Zend\I18n','DoctrineORMModule','SwissEngine\Tools\Doctrine\Extension','ZfMetal\Commons', 'ZfMetal\Datagrid');
    }

}
