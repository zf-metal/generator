<?php

namespace ZfMetal\Generator\Generator;

/**
 * Description of ModuleGenerator
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class RepositoryGenerator extends AbstractClassGenerator {

    //CONST
    const CLASS_PREFIX = "";
    const CLASS_SUBFFIX = "Repository";
    const NAMESPACE_PREFIX = "";
    const NAMESPACE_SUBFFIX = "\Repository";
    const RELATIVE_PATH = "/src/Repository/";

    //BASE NAMES
    public function getBaseName() {
        return $this->getEntity()->getName();
    }

    public function getBaseNamespace() {
        return $this->getEntity()->getModule()->getName();
    }

    //CLASS METHODS

    public function getClassExtends() {
        return "\Doctrine\ORM\EntityRepository";
    }

    public function getClassInterfaces() {
        return []; //OPTIONAL 
    }

    public function getClassTags() {
        return []; //OPTIONAL 
    }

    public function getClassUses() {
        return [
            ["class" => "Doctrine\ORM\EntityRepository", "alias" => null],
        ];
    }

    //MODULE
    public function getModule() {
        return $this->getEntity()->getModule(); // return \ZfMetal\Generator\Entity\Module
    }

    /**
     * Description
     * 
     * @var \ZfMetal\Generator\Entity\Entity
     */
    private $entity;

    function __construct(\ZfMetal\Generator\Entity\Entity $entity) {
        $this->entity = $entity;
    }

    function getEntity() {
        return $this->entity;
    }

    function setEntity(\ZfMetal\Generator\Entity\Entity $entity) {
        $this->entity = $entity;
    }

    public function prepare() {
        parent::prepare();
        $this->genSaveAndRemove();
    }

    protected function genSaveAndRemove() {

        //PARAM (BOTH)
        $param = new \Zend\Code\Generator\ParameterGenerator("entity", $this->getEntity()->getFullName());

        //SAVE METHOD
        if (!$this->getCg()->hasMethod("save")) {
            $save = new \Zend\Code\Generator\MethodGenerator ( );
            $save->setName("save");
            $save->setBody(
                    ' $this->getEntityManager()->persist($entity);'
                    . ' $this->getEntityManager()->flush();');
            $save->setParameter($param);
            $this->getCg()->addMethodFromGenerator($save);
        }



        //REMOVE Method
        if (!$this->getCg()->hasMethod("remove")) {
            $remove = new \Zend\Code\Generator\MethodGenerator ( );
            $remove->setName("remove");
            $remove->setBody(
                    ' $this->getEntityManager()->remove($entity);'
                    . ' $this->getEntityManager()->flush();');
            $remove->setParameter($param);
            $this->getCg()->addMethodFromGenerator($remove);
        }
    }

}
