<?php

namespace ZfMetal\Generator\Generator;

/**
 * Description of Util
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class Util {

    static function genGetter($name) {
        $m = new \Zend\Code\Generator\MethodGenerator();
        $m->setName("get" . ucfirst($name));
        $m->setBody('return $this->' . $name . ";");
        return $m;
    }

    static function genSetter($name,$type) {
         $parameter = new \Zend\Code\Generator\ParameterGenerator($name, $type);
        $m = new \Zend\Code\Generator\MethodGenerator ( );
        $m->setName("set" . ucfirst($name));
        $m->setBody('$this->' . $name . " = $" . $name . ";");
        $m->setParameter($parameter);
        return $m;
    }

}
