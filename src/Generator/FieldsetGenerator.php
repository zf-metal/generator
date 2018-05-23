<?php

namespace ZfMetal\Generator\Generator;

/**
 * EntityGenerator
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class FieldsetGenerator extends AbstractClassGenerator
{

    /**
     * Description
     *
     * @var \ZfMetal\Generator\Entity\Entity
     */
    private $entity;


    /**
     * @var \Zend\Code\Generator\MethodGenerator
     */
    private $initMethod;

    //CONSTS
    const CLASS_PREFIX = "";
    const CLASS_SUBFFIX = "";
    const NAMESPACE_PREFIX = "";
    const NAMESPACE_SUBFFIX = "\Form";
    const RELATIVE_PATH = "/src/Form/";

    //BASE NAMES
    public function getBaseName()
    {
        return $this->getEntity()->getName();
    }

    public function getBaseNamespace()
    {
        return $this->getEntity()->getModule()->getName();
    }

    //CLASS METHODS

    public function getClassExtends()
    {
        return "\Zend\Form\Fieldset";
    }

    public function getClassInterfaces()
    {
        return ["\DoctrineModule\Persistence\ObjectManagerAwareInterface",
            "\Zend\InputFilter\InputFilterProviderInterface"];
    }


    public function getClassUses()
    {
        return [
            ["class" => "DoctrineModule\Persistence\ObjectManagerAwareInterface", "alias" => "ObjectManagerAwareInterface"],
            ["class" => "Zend\InputFilter\InputFilterProviderInterface", "alias" => "InputFilterProviderInterface"],
        ];
    }

    //MODULE
    public function getModule()
    {
        return $this->getEntity()->getModule(); // return \ZfMetal\Generator\Entity\Module
    }


    function __construct(\ZfMetal\Generator\Entity\Entity $entity)
    {
        $this->entity = $entity;
    }

    public function prepare()
    {
        parent::prepare();
        $this->genInit();
    }

    public function genInit()
    {
        if (!$this->getCg()->hasMethod("init")) {
            $this->initMethod = new \Zend\Code\Generator\MethodGenerator();

            $body = "";

            foreach ($this->getEntity()->getProperties() as $property) {

                if (!$property->getExclude()) {
                    $body .= "$this->add(";
                    switch ($this->getProperty()->getType()) {
                        case "string":
                            $vf = new \ZfMetal\Generator\Generator\ValueGenerator(\ZfMetal\Generator\FormField::TEXT($this->getProperty()), \Zend\Code\Generator\ValueGenerator::TYPE_ARRAY_SHORT);
                            $body .= $vf->generate();
                            break;
                        case "stringarea":
                            $vf = new \ZfMetal\Generator\Generator\ValueGenerator(\ZfMetal\Generator\FormField::TEXTAREA($this->getProperty()), \Zend\Code\Generator\ValueGenerator::TYPE_ARRAY_SHORT);
                            $body .= $vf->generate();
                            break;
                        case "text":
                            $vf = new \ZfMetal\Generator\Generator\ValueGenerator(\ZfMetal\Generator\FormField::TEXTAREA($this->getProperty()), \Zend\Code\Generator\ValueGenerator::TYPE_ARRAY_SHORT);
                            $body .= $vf->generate();
                            break;
                        case "integer":
                            $vf = new \ZfMetal\Generator\Generator\ValueGenerator(\ZfMetal\Generator\FormField::TEXT($this->getProperty()), \Zend\Code\Generator\ValueGenerator::TYPE_ARRAY_SHORT);
                            $body .= $vf->generate();
                            break;
                        case "float":
                            $vf = new \ZfMetal\Generator\Generator\ValueGenerator(\ZfMetal\Generator\FormField::TEXT($this->getProperty()), \Zend\Code\Generator\ValueGenerator::TYPE_ARRAY_SHORT);
                            $body .= $vf->generate();
                            break;
                        case "decimal":
                            $vf = new \ZfMetal\Generator\Generator\ValueGenerator(\ZfMetal\Generator\FormField::TEXT($this->getProperty()), \Zend\Code\Generator\ValueGenerator::TYPE_ARRAY_SHORT);
                            $body .= $vf->generate();
                            break;
                        case "date":
                            $vf = new \ZfMetal\Generator\Generator\ValueGenerator(\ZfMetal\Generator\FormField::DATE($this->getProperty()), \Zend\Code\Generator\ValueGenerator::TYPE_ARRAY_SHORT);
                            $body .= $vf->generate();
                            break;
                        case "datetime":
                            $vf = new \ZfMetal\Generator\Generator\ValueGenerator(\ZfMetal\Generator\FormField::DATETIME($this->getProperty()), \Zend\Code\Generator\ValueGenerator::TYPE_ARRAY_SHORT);
                            $body .= $vf->generate();
                            break;
                        case "time":
                            $vf = new \ZfMetal\Generator\Generator\ValueGenerator(\ZfMetal\Generator\FormField::TIME($this->getProperty()), \Zend\Code\Generator\ValueGenerator::TYPE_ARRAY_SHORT);
                            $body .= $vf->generate();
                            break;
                        case "boolean":
                            $vf = new \ZfMetal\Generator\Generator\ValueGenerator(\ZfMetal\Generator\FormField::CHECKBOX($this->getProperty()), \Zend\Code\Generator\ValueGenerator::TYPE_ARRAY_SHORT);
                            $body .= $vf->generate();
                            break;
                        case "file":
                            $vf = new \ZfMetal\Generator\Generator\ValueGenerator(\ZfMetal\Generator\FormField::FILE($this->getProperty()), \Zend\Code\Generator\ValueGenerator::TYPE_ARRAY_SHORT);
                            $body .= $vf->generate();
                            break;
                        case "oneToOne":
                            $vf = new \ZfMetal\Generator\Generator\ValueGenerator(\ZfMetal\Generator\FormField::OBJECTSELECT($this->getProperty()), \Zend\Code\Generator\ValueGenerator::TYPE_ARRAY_SHORT);
                            $body .= $vf->generate();
                            break;
                        case "manyToOne":
                            $vf = new \ZfMetal\Generator\Generator\ValueGenerator(\ZfMetal\Generator\FormField::OBJECTSELECT($this->getProperty()), \Zend\Code\Generator\ValueGenerator::TYPE_ARRAY_SHORT);
                            $body .= $vf->generate();
                            break;
                        case "oneToMany":
                            $vf = new \ZfMetal\Generator\Generator\ValueGenerator(\ZfMetal\Generator\FormField::OBJECTMULTICHECKBOX($this->getProperty()), \Zend\Code\Generator\ValueGenerator::TYPE_ARRAY_SHORT);
                            $body .= $vf->generate();
                            break;
                        case "manyToMany":
                            $vf = new \ZfMetal\Generator\Generator\ValueGenerator(\ZfMetal\Generator\FormField::OBJECTMULTICHECKBOX($this->getProperty()), \Zend\Code\Generator\ValueGenerator::TYPE_ARRAY_SHORT);
                            $body .= $vf->generate();
                            break;
                        default:
                    }
                    $body .= ");" . PHP_EOL;
                }

            }

            $this->initMethod->setBody($body);
            $this->cg->addMethod($this->initMethod);
        }

    }

    function getEntity()
    {
        if (!$this->entity) {
            throw new Exception("Entity no set");
        }
        return $this->entity;
    }

    function setEntity(\ZfMetal\Generator\Entity\Entity $entity)
    {
        $this->entity = $entity;
    }

}
