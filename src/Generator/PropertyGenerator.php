<?php

namespace ZfMetal\Generator\Generator;

/**
 * Description of PropertyGenerator
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class PropertyGenerator {

    /**
     * Description
     * 
     * @var \ZfMetal\Generator\Entity\Property
     */
    protected $property;

    /**
     * Description
     * 
     * @var \ZfMetal\Generator\Entity\Property
     */
    protected $propertyGenerator;

    /**
     * Description
     * 
     * @var \Zend\Code\Generator\ClassGenerator
     */
    protected $classGenerator;

    function getPropertyGenerator() {
        return $this->propertyGenerator;
    }

    function setPropertyGenerator(\ZfMetal\Generator\Entity\Property $propertyGenerator) {
        $this->propertyGenerator = $propertyGenerator;
    }

    function getClassGenerator() {
        return $this->classGenerator;
    }

    function setClassGenerator(\Zend\Code\Generator\ClassGenerator $classGenerator) {
        $this->classGenerator = $classGenerator;
    }

    function getProperty() {
        return $this->property;
    }

    function setProperty(\ZfMetal\Generator\Entity\Property $property) {
        $this->property = $property;
    }

    function __construct(\ZfMetal\Generator\Entity\Property $property, \Zend\Code\Generator\ClassGenerator $classGenerator) {
        //INIT
        $this->property = $property;
        $this->propertyGenerator = new \Zend\Code\Generator\PropertyGenerator();
        $this->classGenerator = $classGenerator;
    }

    /**
     * Description
     * 
     * @param \ZfMetal\Generator\Entity\Property $property
     * @param \Zend\Code\Generator\ClassGenerator $classGenerator
     */
    public function generate() {

        //Check Related Entity on Type = oneToOne, manyToOne, oneToMany, manyToMany
        $this->checkRelatedEntity();

        //Set Property name
        $this->getPropertyGenerator()->setName($this->getProperty()->getName());

        //Annotations of Property
        $this->generateAnnotation();

        //Add PropertyGenerator to Entity Class Generator
        //CHECK IF EXIST (Reflection). Remove if Exist. ZfMetal\Generator Priority.
        if ($this->getClassGenerator()->hasProperty($this->getProperty()->getName())) {
            $this->getClassGenerator()->removeProperty($this->getProperty()->getName());
        }

        $this->getClassGenerator()->addPropertyFromGenerator($this->getPropertyGenerator());

        //Generate Getter Method of property and ADD to Entity Class
        $this->generateGetter();

        //Generate Setter Method of property and ADD to Entity Class
        $this->generateSetter();


        //Metodos auxiliares para File
        if ($this->getProperty()->getType() == "file") {
            $this->generateFileMethods();
        }
    }

    protected function generateAnnotation() {
        /* @var $annotations \Zend\Code\Generator\DocBlockGenerator */
        $annotations = new \Zend\Code\Generator\DocBlockGenerator();


        $tagForm = null;

        //CHECK IF PROPERTY NEED EXLUDE
        if ($this->getProperty()->getExclude()) {
            $tagForm = \ZfMetal\Generator\FormAnnotation::EXCLUDE();
            //CHECK IF PROPERTY NEED HIDDEN    
        } else if ($this->getProperty()->getHidden()) {
            $tagForm = \ZfMetal\Generator\FormAnnotation::HIDDEN();
        } else if ($this->getProperty()->getElementType()) {
            $tagForm = \ZfMetal\Generator\FormAnnotation::CUSTOM($this->getProperty());
        }



        switch ($this->getProperty()->getType()) {
            case "string":
                $tagForm = ($tagForm) ? $tagForm : \ZfMetal\Generator\FormAnnotation::TEXT($this->getProperty());
                $tagDoctrine = \ZfMetal\Generator\DoctrineAnnotation::STRING($this->getProperty());
                break;

            case "stringarea":
                $tagForm = ($tagForm) ? $tagForm : \ZfMetal\Generator\FormAnnotation::TEXTAREA($this->getProperty());
                $tagDoctrine = \ZfMetal\Generator\DoctrineAnnotation::STRING($this->getProperty());
                break;

            case "text":
                $tagForm = ($tagForm) ? $tagForm : \ZfMetal\Generator\FormAnnotation::TEXTAREA($this->getProperty());
                $tagDoctrine = \ZfMetal\Generator\DoctrineAnnotation::TEXT($this->getProperty());
                break;
            case "integer":
                $tagForm = ($tagForm) ? $tagForm : \ZfMetal\Generator\FormAnnotation::TEXT($this->getProperty());
                $tagDoctrine = \ZfMetal\Generator\DoctrineAnnotation::INTEGER($this->getProperty());
                break;

            case "decimal":
                $tagForm = ($tagForm) ? $tagForm : \ZfMetal\Generator\FormAnnotation::TEXT($this->getProperty());
                $tagDoctrine = \ZfMetal\Generator\DoctrineAnnotation::DECIMAL($this->getProperty());
                break;

            case "date":
                $tagForm = ($tagForm) ? $tagForm : \ZfMetal\Generator\FormAnnotation::DATE($this->getProperty());
                $tagDoctrine = \ZfMetal\Generator\DoctrineAnnotation::DATE($this->getProperty());
                break;

            case "datetime":
                $tagForm = ($tagForm) ? $tagForm : \ZfMetal\Generator\FormAnnotation::DATETIME($this->getProperty());
                $tagDoctrine = \ZfMetal\Generator\DoctrineAnnotation::DATETIME($this->getProperty());
                break;

            case "time":
                $tagForm = ($tagForm) ? $tagForm : \ZfMetal\Generator\FormAnnotation::TIME($this->getProperty());
                $tagDoctrine = \ZfMetal\Generator\DoctrineAnnotation::TIME($this->getProperty());
                break;

            case "boolean":
                $tagForm = ($tagForm) ? $tagForm : \ZfMetal\Generator\FormAnnotation::CHECKBOX($this->getProperty());
                $tagDoctrine = \ZfMetal\Generator\DoctrineAnnotation::BOOLEAN($this->getProperty());
                break;

            case "file":
                $tagForm = ($tagForm) ? $tagForm : \ZfMetal\Generator\FormAnnotation::FILE($this->getProperty());
                $tagDoctrine = \ZfMetal\Generator\DoctrineAnnotation::STRING($this->getProperty());
                break;

            case "oneToOne":
                $tagForm = ($tagForm) ? $tagForm : \ZfMetal\Generator\FormAnnotation::OBJECTSELECT($this->getProperty());
                $tagDoctrine = \ZfMetal\Generator\DoctrineAnnotation::ONETOONE($this->getProperty());
                break;

            case "manyToOne":
                $tagForm = ($tagForm) ? $tagForm : \ZfMetal\Generator\FormAnnotation::OBJECTSELECT($this->getProperty());
                $tagDoctrine = \ZfMetal\Generator\DoctrineAnnotation::MANYTOONE($this->getProperty());
                var_dump($tagDoctrine);
                break;

            case "oneToMany":
                $tagForm = ($tagForm) ? $tagForm : \ZfMetal\Generator\FormAnnotation::OBJECTMULTICHECKBOX($this->getProperty());
                $tagDoctrine = \ZfMetal\Generator\DoctrineAnnotation::ONETOMANY($this->getProperty());
                break;
            case "manyToMany":
                $tagForm = ($tagForm) ? $tagForm : \ZfMetal\Generator\FormAnnotation::OBJECTMULTICHECKBOX($this->getProperty());
                $tagDoctrine = \ZfMetal\Generator\DoctrineAnnotation::MANYTOMANY($this->getProperty());
                break;

            default:
        }

        //CHECK ID
        if ($this->getProperty()->getPrimarykey()) {
            $tagForm = array_merge($tagForm, \ZfMetal\Generator\DoctrineAnnotation::ID());
        }

        //CHECK GeneratedValue = AUTO
        if ($this->getProperty()->getAutoGeneratedValue()) {
            $tagForm = array_merge($tagForm, \ZfMetal\Generator\DoctrineAnnotation::AUTOGENERATEDVALUE());
        }

        $tags = array_merge_recursive($tagForm, $tagDoctrine);

        $annotations->setTags($tags);

//        if ($this->getProperty()->getType() == "manyToOne") {
//          var_dump($tags);
//        }

        $this->getPropertyGenerator()->setDocBlock($annotations);
    }

    /**
     * Generate Getter Method of property and ADD to Entity Class
     */
    protected function generateGetter() {
        $name = "get" . ucfirst($this->getProperty()->getName());
        if (!$this->getClassGenerator()->hasMethod($name)) {
            $m = new \Zend\Code\Generator\MethodGenerator();
            $m->setName($name);
            $m->setBody('return $this->' . $this->getProperty()->getName() . ";");
            $this->getClassGenerator()->addMethodFromGenerator($m);
        }
    }

    /**
     * Generate Setter Method of property and ADD to Entity Class
     */
    protected function generateSetter() {
        $name = "set" . ucfirst($this->getProperty()->getName());
        if (!$this->getClassGenerator()->hasMethod($name)) {
            $parameter = new \Zend\Code\Generator\ParameterGenerator($this->getProperty()->getName(), null);
            $m = new \Zend\Code\Generator\MethodGenerator ( );
            $m->setName($name);
            $m->setBody('$this->' . $this->getProperty()->getName() . " = $" . $this->getProperty()->getName() . ";");
            $m->setParameter($parameter);
            $this->getClassGenerator()->addMethodFromGenerator($m);
        }
    }

    /**
     * Check Related Entity on Type = oneToOne, manyToOne, oneToMany, manyToMany
     */
    protected function checkRelatedEntity() {
        if (($this->getProperty()->getType() == "oneToOne" ||
                $this->getProperty()->getType() == "manyToOne" ||
                $this->getProperty()->getType() == "oneToMany" ||
                $this->getProperty()->getType() == "manyToMany") &&
                $this->getProperty()->getRelatedEntity() == null) {
            throw new Exception("Falta definir RelatedEntity");
        }
    }

    protected function generateFileMethods() {
        $ma = new \Zend\Code\Generator\MethodGenerator ( );
        $method = "get" . ucfirst($this->getProperty()->getName()) . "_ap";
        $ma->setName($method);
        $ma->setBody('return "' . $this->getProperty()->getAbsolutepath() . '";');
        $a[] = $ma;


        $ms = new \Zend\Code\Generator\MethodGenerator ( );
        $method = "get" . ucfirst($this->getProperty()->getName()) . "_wp";
        $ms->setName($method);
        $ms->setBody('return "' . $this->getProperty()->getWebpath() . '";');
        $a[] = $ms;

        $mf = new \Zend\Code\Generator\MethodGenerator ( );
        $method = "get" . ucfirst($this->getProperty()->getName()) . "_fp";
        $mf->setName($method);
        $mf->setBody('return "' . $this->getProperty()->getWebpath() . '".$this->' . $this->getProperty()->getName() . ';');
        $a[] = $mf;

        $this->getClassGenerator()->addMethods($a);
    }

}
