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
            "type" => $property->getElementType(),
            "options" => selft::getOptions($property)
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
                "type" => "Zend\Form\Element\Hidden",
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
            "type" => "Zend\Form\Element\Text",
            "options" => selft::getOptions($property),
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
            "type" => "Zend\Form\Element\Date",
            "options" => selft::getOptions($property),
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
            "type" => "Zend\Form\Element\DateTime",
            "options" => selft::getOptions($property),
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
            "type" => "Zend\Form\Element\Time",
            "options" => selft::getOptions($property),
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
            "type" => "Zend\Form\Element\File",
            "options" => selft::getOptions($property),
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
            "type" => "Zend\Form\Element\Checkbox",
            "options" => selft::getOptions($property),
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
            "type" => "DoctrineModule\Form\Element\ObjectSelect",
            "options" => [
                "label" => self::LABEL($property),
                "description" => $property->getDescription(),
                "addon" => $property->getAddon(),
                "empty_option"=> "",
                "target_class" => $property->getRelatedEntity()->getFullName(),
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
            "type" => "DoctrineModule\Form\Element\ObjectMultiCheckbox",
            "options" => [
                "label" => self::LABEL($property),
                "description" => $property->getDescription(),
                "addon" => $property->getAddon(),
                "target_class" => $property->getRelatedEntity()->getFullName(),
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
            "type" => "Zend\Form\Element\Textarea",
            "options" => selft::getOptions($property),
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
