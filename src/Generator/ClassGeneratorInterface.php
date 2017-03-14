<?php

namespace ZfMetal\Generator\Generator;

/**
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
interface ClassGeneratorInterface {

    /**
     * Class Prefix
     */
    const CLASS_PREFIX = "";

    /**
     * Class Subffix
     */
    const CLASS_SUBFFIX = "";

    /**
     * Namespace Prefix
     */
    const NAMESPACE_PREFIX = "";

    /**
     * Namespace Subffix
     */
    const NAMESPACE_SUBFFIX = "";

    /**
     * PATH Subffix
     */
    const PATH_SUBFFIX = "";

    /**
     * USES
     * 
     * Remember: [ ["class" => "THE_CLASS", "alias" => "THE_ALIAS"] ]
     * 
     * @type array
     */
    const USES = [];

    /**
     * getTags
     * 
     * Remember, return: [ ["class" => "THE_CLASS", "alias" => "THE_ALIAS"] ]
     * 
     * @return array
     */
    public function getTags();

    public function getClassName();

    public function getNamespaceName();

    public function getExtendsName();

    public function getAuthor();

    public function getLicense();

    public function getLink();

    public function getShortDescription();

    public function getLongDescription();

    public function getPath();

    public function generate();
}
