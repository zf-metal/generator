<?php

namespace ZfMetal\Generator;

/**
 * Description of AnnotationGenerator
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class FormAnnotation {

    /**
     * Return Annotation for Exclude Property
     * 
     * @return Array
     */
    static function EXCLUDE() {
        return [
            ["name" => 'Annotation\Exclude()']
        ];
    }

    /**
     * Return Annotation for Hidden Property
     * 
     * @return Array
     */
    static function HIDDEN() {
        return [
            ["name" => 'Annotation\Attributes({"type":"hidden"})'],
            ["name" => 'Annotation\Type("Zend\Form\Element\Hidden")']
        ];
    }

    /**
     * Return Annotation for TEXT Input
     * 
     * @param \ZfMetal\Generator\Entity\Property $property
     * @return Array
     */
    static function TEXT($property) {
        return [
            ["name" => 'Annotation\Attributes({"type":"text"})'],
            ["name" => 'Annotation\Options({"label":"' . self::LABEL($property) . '", "description":"' . $property->getDescription() . '"})']
        ];
    }

    /**
     * Return Annotation for DATE Input
     * 
     * @param \ZfMetal\Generator\Entity\Property $property
     * @return Array
     */
    static function DATE($property) {
        return [
            ["name" => 'Annotation\Type("Zend\Form\Element\Date")'],
            ["name" => 'Annotation\Attributes({"type":"date"})'],
            ["name" => 'Annotation\Options({"label":"' . self::LABEL($property) . '", "description":"' . $property->getDescription() . '"})']
        ];
    }

    /**
     * Return Annotation for DATETIME Input
     * 
     * @param \ZfMetal\Generator\Entity\Property $property
     * @return Array
     */
    static function DATETIME($property) {
        return [
            ["name" => 'Annotation\Type("Zend\Form\Element\DateTime")'],
            ["name" => 'Annotation\Attributes({"type":"datetime"})'],
            ["name" => 'Annotation\Options({"label":"' . self::LABEL($property) . '", "description":"' . $property->getDescription() . '"})']
        ];
    }

    /**
     * Return Annotation for TIME Input
     * 
     * @param \ZfMetal\Generator\Entity\Property $property
     * @return Array
     */
    static function TIME($property) {
        return [
            ["name" => 'Annotation\Type("Zend\Form\Element\Time")'],
            ["name" => 'Annotation\Attributes({"type":"time"})'],
            ["name" => 'Annotation\Options({"label":"' . self::LABEL($property) . '", "description":"' . $property->getDescription() . '"})']
        ];
    }

    /**
     * Return Annotation for FILE Input
     * 
     * @param \ZfMetal\Generator\Entity\Property $property
     * @return Array
     */
    static function FILE($property) {
        return [
            ["name" => 'Annotation\Type("Zend\Form\Element\File")'],
            ["name" => 'Annotation\Attributes({"type":"file"})'],
            ["name" => 'Annotation\Options({"label":"' . self::LABEL($property) . '","absolutepath":"' . $property->getAbsolutepath() . '","webpath":"' . $property->getWebpath() . '", "description":"' . $property->getDescription() . '"})'],
            ["name" => 'Annotation\Filter({"name":"filerenameupload", "options":{"target":"' . $property->getAbsolutepath() . '","use_upload_name":1,"overwrite":1}})'],
        ];
    }

    /**
     * Return Annotation for CHECKBOX Input
     * 
     * @param \ZfMetal\Generator\Entity\Property $property
     * @return Array
     */
    static function CHECKBOX($property) {
        return [
            ["name" => 'Annotation\Type("Zend\Form\Element\Checkbox")'],
            ["name" => 'Annotation\Attributes({"type":"checkbox"})'],
            ["name" => 'Annotation\Options({"label":"' . self::LABEL($property) . '", "description":"' . $property->getDescription() . '"})']
        ];
    }

    /**
     * Return Annotation for OBJECTSELECT Input
     * 
     * @param \ZfMetal\Generator\Entity\Property $property
     * @return Array
     */
    static function OBJECTSELECT($property) {
        return [
            ["name" => 'Annotation\Type("DoctrineModule\Form\Element\ObjectSelect")'],
            ["name" => 'Annotation\Options({"label":"' . self::LABEL($property) . '","empty_option": "", "target_class":"' . $property->getRelatedEntity()->getFullName() . '", "description":"' . $property->getDescription() . '"})'],
        ];
    }

    /**
     * Return Annotation for OBJECTSELECT Input
     * 
     * @param \ZfMetal\Generator\Entity\Property $property
     * @return Array
     */
    static function OBJECTMULTICHECKBOX($property) {
        return [
            ["name" => 'Annotation\Type("DoctrineModule\Form\Element\ObjectMultiCheckbox")'],
            ["name" => 'Annotation\Options({"label":"' . self::LABEL($property) . '","target_class":"' . $property->getRelatedEntity()->getFullName() . '", "description":"' . $property->getDescription() . '"})'],
        ];
    }

    /**
     * Return Annotation for TEXTAREA Input
     * 
     * @param \ZfMetal\Generator\Entity\Property $property
     * @return Array
     */
    static function TEXTAREA($property) {
        return [
            ["name" => 'Annotation\Attributes({"type":"textarea"})'],
            ["name" => 'Annotation\Options({"label":"' . self::LABEL($property) . '", "description":"' . $property->getDescription() . '"})']
        ];
    }

    /**
     * Return Label of Property. If Label is no set, name is returned.
     * 
     * @param \ZfMetal\Generator\Entity\Property $property
     */
    static function LABEL($property) {
        if ($property->getLabel()) {
            return $property->getLabel();
        }
        return $property->getName();
    }

}
