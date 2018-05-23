<?php

namespace ZfMetal\Generator;

/**
 * Description of AnnotationGenerator
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class FormField
{


    static function getOptions($property)
    {
        return [
            "label" => self::LABEL($property),
            "description" => $property->getDescription(),
            "addon" => $property->getAddon()
        ];
    }


    /**
     * Return Annotation for Exclude Property
     *
     * @return Array
     */
    static function CUSTOM($property)
    {
        return [
            "name" => $property->getName(),
            "type" => $property->getElementType(),
            "options" => self::getOptions($property)
        ];
    }



    /**
     * Return Annotation for Hidden Property
     *
     * @return Array
     */
    static function HIDDEN($property)
    {

        return [
            "name" => $property->getName(),
            "type" => new \Zend\Code\Generator\ValueGenerator("\Zend\Form\Element\Hidden::class",\Zend\Code\Generator\ValueGenerator::TYPE_CONSTANT),
            "attributes" => ["type" => "hidden"]
        ];
    }

    /**
     * Return Annotation for TEXT Input
     *
     * @param \ZfMetal\Generator\Entity\Property $property
     * @return Array
     */
    static function TEXT($property)
    {

        return [
            "name" => $property->getName(),
            "type" => new \Zend\Code\Generator\ValueGenerator("\Zend\Form\Element\Text::class",\Zend\Code\Generator\ValueGenerator::TYPE_CONSTANT),
            "options" => self::getOptions($property),
            "attributes" => ["type" => "text"]
        ];

    }

    /**
     * Return Annotation for DATE Input
     *
     * @param \ZfMetal\Generator\Entity\Property $property
     * @return Array
     */
    static function DATE($property)
    {
        return [
            "name" => $property->getName(),
            "type" => new \Zend\Code\Generator\ValueGenerator("\Zend\Form\Element\Date::class",\Zend\Code\Generator\ValueGenerator::TYPE_CONSTANT),
            "options" => self::getOptions($property),
            "attributes" => ["type" => "date"]
        ];
    }

    /**
     * Return Annotation for DATETIME Input
     *
     * @param \ZfMetal\Generator\Entity\Property $property
     * @return Array
     */
    static function DATETIME($property)
    {
        return [
            "name" => $property->getName(),
            "type" => new \Zend\Code\Generator\ValueGenerator("\Zend\Form\Element\DateTime::class",\Zend\Code\Generator\ValueGenerator::TYPE_CONSTANT),
            "options" => self::getOptions($property),
            "attributes" => ["type" => "datetime"]
        ];
    }

    /**
     * Return Annotation for TIME Input
     *
     * @param \ZfMetal\Generator\Entity\Property $property
     * @return Array
     */
    static function TIME($property)
    {
        return [
            "name" => $property->getName(),
            "type" => new \Zend\Code\Generator\ValueGenerator("\Zend\Form\Element\Time::class",\Zend\Code\Generator\ValueGenerator::TYPE_CONSTANT),
            "options" => self::getOptions($property),
            "attributes" => ["type" => "time"]
        ];
    }

    /**
     * Return Annotation for FILE Input
     *
     * @param \ZfMetal\Generator\Entity\Property $property
     * @return Array
     */
    static function FILE($property)
    {

        return [
            "name" => $property->getName(),
            "type" => new \Zend\Code\Generator\ValueGenerator("\Zend\Form\Element\File::class",\Zend\Code\Generator\ValueGenerator::TYPE_CONSTANT),
            "options" => self::getOptions($property),
            "attributes" => ["type" => "file"],
        ];

    }

    /**
     * Return Annotation for CHECKBOX Input
     *
     * @param \ZfMetal\Generator\Entity\Property $property
     * @return Array
     */
    static function CHECKBOX($property)
    {

        return [
            "name" => $property->getName(),
            "type" => new \Zend\Code\Generator\ValueGenerator("\Zend\Form\Element\Checkbox::class",\Zend\Code\Generator\ValueGenerator::TYPE_CONSTANT),
            "options" => self::getOptions($property),
            "attributes" => ["type" => "checkbox"],
        ];
    }

    /**
     * Return Annotation for OBJECTSELECT Input
     *
     * @param \ZfMetal\Generator\Entity\Property $property
     * @return Array
     */
    static function OBJECTSELECT($property)
    {

        return [
            "name" => $property->getName(),
            "type" => new \Zend\Code\Generator\ValueGenerator("\DoctrineModule\Form\Element\ObjectSelect::class",\Zend\Code\Generator\ValueGenerator::TYPE_CONSTANT),
            "options" => [
                "label" => self::LABEL($property),
                "description" => $property->getDescription(),
                "addon" => $property->getAddon(),
                "empty_option"=> "",
                "target_class" => new \Zend\Code\Generator\ValueGenerator($property->getRelatedEntity()->getFullName()."::class", \Zend\Code\Generator\ValueGenerator::TYPE_CONSTANT),
            ],
        ];

    }

    /**
     * Return Annotation for OBJECTSELECT Input
     *
     * @param \ZfMetal\Generator\Entity\Property $property
     * @return Array
     */
    static function OBJECTMULTICHECKBOX($property)
    {

        return [
            "name" => $property->getName(),
            "type" =>  new \Zend\Code\Generator\ValueGenerator("\DoctrineModule\Form\Element\ObjectMultiCheckbox::class",\Zend\Code\Generator\ValueGenerator::TYPE_CONSTANT),
            "options" => [
                "label" => self::LABEL($property),
                "description" => $property->getDescription(),
                "addon" => $property->getAddon(),
                "target_class" => new \Zend\Code\Generator\ValueGenerator($property->getRelatedEntity()->getFullName()."::class", \Zend\Code\Generator\ValueGenerator::TYPE_CONSTANT),
            ],
        ];

    }

    /**
     * Return Annotation for TEXTAREA Input
     *
     * @param \ZfMetal\Generator\Entity\Property $property
     * @return Array
     */
    static function TEXTAREA($property)
    {

        return [
            "name" => $property->getName(),
            "type" =>  new \Zend\Code\Generator\ValueGenerator("\Zend\Form\Element\Textarea::class",\Zend\Code\Generator\ValueGenerator::TYPE_CONSTANT),
            "options" => self::getOptions($property),
            "attributes" => ["type" => "textarea"],
        ];

    }

    /**
     * Return Label of Property. If Label is no set, name is returned.
     *
     * @param \ZfMetal\Generator\Entity\Property $property
     */
    static function LABEL($property)
    {
        if ($property->getLabel()) {
            return $property->getLabel();
        }
        return $property->getName();
    }

}
