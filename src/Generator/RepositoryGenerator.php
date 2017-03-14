<?php

namespace ZfMetal\Generator\Generator;

/**
 * Description of ModuleGenerator
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class RepositoryGenerator extends AbstractClassGenerator {
    //INIT ClassGeneratorInterface

    /**
     * Prefix
     */
    const CLASS_PREFIX = "";

    /**
     * Subffix
     */
    const CLASS_SUBFFIX = "Repository";

    /**
     * Namespace Prefix
     */
    const NAMESPACE_PREFIX = "";

    /**
     * Namespace Subffix
     */
    const NAMESPACE_SUBFFIX = "\Repository";

    /**
     * PATH Subffix
     */
    const PATH_SUBFFIX = "/src/Repository/";

    /**
     * USES
     * 
     * Remember: [ ["class" => "THE_CLASS", "alias" => "THE_ALIAS"] ]
     * 
     * @type array
     */
    const USES = [
        ["class" => "Doctrine\ORM\EntityRepository", "alias" => null],
    ];

    /**
     * getTags
     * 
     * Remember, return: [ ["class" => "THE_CLASS", "alias" => "THE_ALIAS"] ]
     * 
     * @return array
     */
    public function getTags() {
        $a = [];
        return $a;
    }

    public function getClassName() {
        return $this->getEntity()->getName();
    }

    public function getNamespaceName() {
        return $this->getEntity()->getModule()->getName();
    }

    public function getExtendsName() {
        return "\Doctrine\ORM\EntityRepository";
    }

    public function getPath() {
        return $this->getEntity()->getModule()->getPath();
    }

    public function getAuthor() {
        return $this->getEntity()->getModule()->getAuthor();
    }

    public function getLicense() {
        return $this->getEntity()->getModule()->getLicense();
    }

    public function getLink() {
        return $this->getEntity()->getModule()->getLink();
    }

    public function getShortDescription() {
        return $this->getEntity()->getName();
    }

    public function getLongDescription() {
        return "";
    }

    //END ClassGeneratorInterface

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

    public function generate() {
        parent::generate();
        $this->genSaveAndRemove();
        $this->insertFile();
    }

    /**
     * [6] Se genera save and delete
     */
    protected function genSaveAndRemove() {

        //PARAM (BOTH)
        $param = new \Zend\Code\Generator\ParameterGenerator("entity", $this->getEntity()->getFullName());

        //SAVE METHOD
        $save = new \Zend\Code\Generator\MethodGenerator ( );
        $save->setName("save");
        $save->setBody(
                ' $this->getEntityManager()->persist($entity);'
                . ' $this->getEntityManager()->flush();');
        $save->setParameter($param);
        $this->getClassGenerator()->addMethodFromGenerator($save);


        //REMOVE Method
        $remove = new \Zend\Code\Generator\MethodGenerator ( );
        $remove->setName("remove");
        $remove->setBody(
                ' $this->getEntityManager()->remove($entity);'
                . ' $this->getEntityManager()->flush();');
        $remove->setParameter($param);
        $this->getClassGenerator()->addMethodFromGenerator($remove);
    }

}
