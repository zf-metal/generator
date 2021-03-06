<?php

namespace ZfMetal\Generator\Generator\Commons;

/**
 * ControllerGenerator
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class EmGenerator {

    static function applyEmFactory(\ZfMetal\Generator\Generator\ControllerFactoryGenerator $cgf) {
        $cgf->addDependency("em", "\Doctrine\ORM\EntityManager");
        $body = $cgf->getInvoke()->getBody();
        $body .= '/* @var $em \Doctrine\ORM\EntityManager */' . PHP_EOL;
        $body .= '$em = $container->get("doctrine.entitymanager.orm_default");' . PHP_EOL;
        $cgf->getInvoke()->setBody($body);
    }

    static function applyEm(\ZfMetal\Generator\Generator\ControllerGenerator $controllerGenerator) {
        self::genEmProperty($controllerGenerator);
        self::genEntityConst($controllerGenerator);
        self::genGetEntityRepository($controllerGenerator);
        self::genConstruct($controllerGenerator);
    }

    static protected function genEntityConst($controllerGenerator) {
        if (!$controllerGenerator->getCg()->hasConstant("ENTITY")) {
            $entityClass = $controllerGenerator->getController()->getEntity()->getFullName();

            $entityName = new \Zend\Code\Generator\PropertyValueGenerator($entityClass."::class",\Zend\Code\Generator\ValueGenerator::TYPE_CONSTANT);
            $p = new \Zend\Code\Generator\PropertyGenerator("ENTITY", $entityName, \Zend\Code\Generator\PropertyGenerator::FLAG_CONSTANT);
            // $p->setDefaultValue($entityName);
            $controllerGenerator->getCg()->addPropertyFromGenerator($p);
        }
    }

    static protected function genGetEntityRepository($controllerGenerator) {

        if (!$controllerGenerator->getCg()->hasMethod("getEntityRepository")) {
            $m = new \Zend\Code\Generator\MethodGenerator("getEntityRepository");

            $body = 'return $this->getEm()->getRepository(self::ENTITY);';

            $m->setBody($body);
            $controllerGenerator->getCg()->addMethodFromGenerator($m);
        }

        //Repo with Entity Name
        $entityName = $controllerGenerator->getController()->getEntity()->getName();
        $repoName = "get".$entityName."Repository";

        if (!$controllerGenerator->getCg()->hasMethod($repoName)) {
            $m = new \Zend\Code\Generator\MethodGenerator($repoName);

            $body = 'return $this->getEm()->getRepository(self::ENTITY);';

            $m->setBody($body);
            $controllerGenerator->getCg()->addMethodFromGenerator($m);
        }

    }

    static protected function genEmProperty($controllerGenerator) {
        if (!$controllerGenerator->getCg()->hasProperty("em")) {
            $controllerGenerator->getCg()->addPropertyFromGenerator(self::getEmProperty());
        }

        if (!$controllerGenerator->getCg()->hasMethod("getEm")) {
            $controllerGenerator->getCg()->addMethodFromGenerator(self::getEmGetter());
        }

        if (!$controllerGenerator->getCg()->hasMethod("setEm")) {
            $controllerGenerator->getCg()->addMethodFromGenerator(self::getEmSetter());
        }
    }

    static protected function genConstruct($controllerGenerator) {
        $cm = $controllerGenerator->getConstruct();


        //BODY
        $body = $cm->getBody();

        //CHECK IF EM EXIST
        if (!preg_match("/em/", $body)) {
            $body .= ' $this->em = $em;' . PHP_EOL;
            $cm->setBody($body);
        }


        //PARAMETERS
        $em = new \Zend\Code\Generator\ParameterGenerator("em", "\Doctrine\ORM\EntityManager");
        $cm->setParameter($em);
    }

    static protected function getEmProperty() {
        $p = new \Zend\Code\Generator\PropertyGenerator();
        $p->setName("em");
        $d = new \Zend\Code\Generator\DocBlockGenerator();
        $a = [["name" => 'var \Doctrine\ORM\EntityManager']];
        $d->setTags($a);
        $p->setDocBlock($d);
        return $p;
    }

    static protected function getEmGetter() {
        return \ZfMetal\Generator\Generator\Util::genGetter("em");
    }

    static protected function getEmSetter() {
        return \ZfMetal\Generator\Generator\Util::genSetter("em", "\Doctrine\ORM\EntityManager");
    }

}
