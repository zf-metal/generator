<?php

namespace ZfMetal\Generator;


/**
 * Module
 *
 * @package   Cdi
 * @copyright Cristian Incarnato (c) - http://www.cincarnato.com
 */
class Module {

    public function init() {
        
    }

    public function getConfig() {
        return include __DIR__ . '/../config/module.config.php';
    }

}
