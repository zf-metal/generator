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
    const CLASS_SUBFFIX = "Fieldset";
    const NAMESPACE_PREFIX = "";
    const NAMESPACE_SUBFFIX = "\Fieldset";
    const RELATIVE_PATH = "/src/Fieldset/";

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

    public function getClassTags()
    {
        return [];
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
        $this->genGetInputFilterSpecification();
        $this->genObjectManager();
    }

    public function genInit()
    {
        if (!$this->getCg()->hasMethod("init")) {
            $this->initMethod = new \Zend\Code\Generator\MethodGenerator("init");

            $body = "";

            foreach ($this->getEntity()->getProperties() as $property) {


                if (!$property->getExclude()) {
                    $body .= '$this->add(';

                    if ($property->getName() == "id") {
                        $vf = new \ZfMetal\Generator\Generator\ValueGenerator(\ZfMetal\Generator\FormField::HIDDEN($property), \Zend\Code\Generator\ValueGenerator::TYPE_ARRAY_SHORT);
                        $body .= $vf->generate();
                    } else {


                        switch ($property->getType()) {
                            case "string":
                                $vf = new \ZfMetal\Generator\Generator\ValueGenerator(\ZfMetal\Generator\FormField::TEXT($property), \Zend\Code\Generator\ValueGenerator::TYPE_ARRAY_SHORT);
                                $body .= $vf->generate();
                                break;
                            case "stringarea":
                                $vf = new \ZfMetal\Generator\Generator\ValueGenerator(\ZfMetal\Generator\FormField::TEXTAREA($property), \Zend\Code\Generator\ValueGenerator::TYPE_ARRAY_SHORT);
                                $body .= $vf->generate();
                                break;
                            case "text":
                                $vf = new \ZfMetal\Generator\Generator\ValueGenerator(\ZfMetal\Generator\FormField::TEXTAREA($property), \Zend\Code\Generator\ValueGenerator::TYPE_ARRAY_SHORT);
                                $body .= $vf->generate();
                                break;
                            case "integer":
                                $vf = new \ZfMetal\Generator\Generator\ValueGenerator(\ZfMetal\Generator\FormField::TEXT($property), \Zend\Code\Generator\ValueGenerator::TYPE_ARRAY_SHORT);
                                $body .= $vf->generate();
                                break;
                            case "float":
                                $vf = new \ZfMetal\Generator\Generator\ValueGenerator(\ZfMetal\Generator\FormField::TEXT($property), \Zend\Code\Generator\ValueGenerator::TYPE_ARRAY_SHORT);
                                $body .= $vf->generate();
                                break;
                            case "decimal":
                                $vf = new \ZfMetal\Generator\Generator\ValueGenerator(\ZfMetal\Generator\FormField::TEXT($property), \Zend\Code\Generator\ValueGenerator::TYPE_ARRAY_SHORT);
                                $body .= $vf->generate();
                                break;
                            case "date":
                                $vf = new \ZfMetal\Generator\Generator\ValueGenerator(\ZfMetal\Generator\FormField::DATE($property), \Zend\Code\Generator\ValueGenerator::TYPE_ARRAY_SHORT);
                                $body .= $vf->generate();
                                break;
                            case "datetime":
                                $vf = new \ZfMetal\Generator\Generator\ValueGenerator(\ZfMetal\Generator\FormField::DATETIME($property), \Zend\Code\Generator\ValueGenerator::TYPE_ARRAY_SHORT);
                                $body .= $vf->generate();
                                break;
                            case "time":
                                $vf = new \ZfMetal\Generator\Generator\ValueGenerator(\ZfMetal\Generator\FormField::TIME($property), \Zend\Code\Generator\ValueGenerator::TYPE_ARRAY_SHORT);
                                $body .= $vf->generate();
                                break;
                            case "boolean":
                                $vf = new \ZfMetal\Generator\Generator\ValueGenerator(\ZfMetal\Generator\FormField::CHECKBOX($property), \Zend\Code\Generator\ValueGenerator::TYPE_ARRAY_SHORT);
                                $body .= $vf->generate();
                                break;
                            case "file":
                                $vf = new \ZfMetal\Generator\Generator\ValueGenerator(\ZfMetal\Generator\FormField::FILE($property), \Zend\Code\Generator\ValueGenerator::TYPE_ARRAY_SHORT);
                                $body .= $vf->generate();
                                break;
                            case "oneToOne":
                                $vf = new \ZfMetal\Generator\Generator\ValueGenerator(\ZfMetal\Generator\FormField::OBJECTSELECT($property), \Zend\Code\Generator\ValueGenerator::TYPE_ARRAY_SHORT);
                                $body .= $vf->generate();
                                break;
                            case "manyToOne":
                                $vf = new \ZfMetal\Generator\Generator\ValueGenerator(\ZfMetal\Generator\FormField::OBJECTSELECT($property), \Zend\Code\Generator\ValueGenerator::TYPE_ARRAY_SHORT);
                                $body .= $vf->generate();
                                break;
                            case "oneToMany":
                                $vf = new \ZfMetal\Generator\Generator\ValueGenerator(\ZfMetal\Generator\FormField::OBJECTMULTICHECKBOX($property), \Zend\Code\Generator\ValueGenerator::TYPE_ARRAY_SHORT);
                                $body .= $vf->generate();
                                break;
                            case "manyToMany":
                                $vf = new \ZfMetal\Generator\Generator\ValueGenerator(\ZfMetal\Generator\FormField::OBJECTMULTICHECKBOX($property), \Zend\Code\Generator\ValueGenerator::TYPE_ARRAY_SHORT);
                                $body .= $vf->generate();
                                break;
                            default:
                        }
                    }
                    $body .= ");" . PHP_EOL;
                }

            }

            $this->initMethod->setBody($body);
            $this->cg->addMethodFromGenerator($this->initMethod);
        }

    }

    function genGetInputFilterSpecification()
    {
        if (!$this->getCg()->hasMethod("getInputFilterSpecification")) {
            $m = new \Zend\Code\Generator\MethodGenerator("getInputFilterSpecification");
            $body = "return [];";
            $m->setBody($body);
            $this->cg->addMethodFromGenerator($m);
        }
    }

    function genObjectManager()
    {

        if (!$this->getCg()->hasProperty("objectManager")) {
            $this->cg->addProperty("objectManager");
        }


        if (!$this->getCg()->hasMethod("getObjectManager")) {
            $this->cg->addMethodFromGenerator(Util::genGetter("objectManager"));
        }

        if (!$this->getCg()->hasMethod("setObjectManager")) {
            $this->cg->addMethodFromGenerator(Util::genSetter("objectManager", \Doctrine\Common\Persistence\ObjectManager::class));
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
