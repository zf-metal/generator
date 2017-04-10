<?php

namespace ZfMetal\Generator\Generator;

/**
 * Description of ModuleGenerator
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class ModuleGenerator {
   
    /**
     * Description
     * 
     * @var \ZfMetal\Generator\Entity\Module
     */
    private $module;
    
    function __construct(\ZfMetal\Generator\Entity\Module $module) {
        $this->module = $module;
    }

    
    function getModule() {
        return $this->module;
    }

    function setModule(\ZfMetal\Generator\Entity\Module $module) {
        $this->module = $module;
    }




}
