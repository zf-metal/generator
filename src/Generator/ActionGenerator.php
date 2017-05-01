<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ZfMetal\Generator\Generator;

/**
 * Description of ActionGenerator
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class ActionGenerator {

    /**
     * construct Method
     * 
     * @var \Zend\Code\Generator\ClassGenerator
     */
    protected $cg;

    /**
     * action
     * 
     * @var \ZfMetal\Generator\Entity\Action
     */
    private $action;

    function getCg() {
        return $this->cg;
    }

    function getAction() {
        return $this->action;
    }

    function setCg(\Zend\Code\Generator\ClassGenerator $cg) {
        $this->cg = $cg;
        return $this;
    }

    function setAction(\ZfMetal\Generator\Entity\Action $action) {
        $this->action = $action;
        return $this;
    }

    function __construct(\Zend\Code\Generator\ClassGenerator $cg, \ZfMetal\Generator\Entity\Action $action) {
        $this->cg = $cg;
        $this->action = $action;
    }

    public function generate() {
        if (!$this->getCg()->hasMethod($this->getActionName())) {
            $this->getCg()->addMethodFromGenerator($this->genActionMethod());
        }
    }

    protected function getActionName() {
        return lcfirst($this->getAction()->getName()) . "Action";
    }

    protected function genActionMethod() {
        $actioNMethod = new \Zend\Code\Generator\MethodGenerator();
        $actioNMethod->setName($this->getActionName());

        if ($this->getAction()->getTemplate()) {
            $actioNMethod->setBody($this->getAction()->getTemplate()->getActionContent());
        } else {
            $actioNMethod->setBody('return [];');
        }

        return $actioNMethod;
    }

}
