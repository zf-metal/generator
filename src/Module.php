<?php

namespace ZfMetal\Generator;

class Module {

    public function init() {
        
    }

    public function getConfig() {
        return include __DIR__ . '/../config/module.config.php';
    }

}
