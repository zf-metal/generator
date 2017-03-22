<?php

namespace ZfMetal\Generator\Generator;

/**
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
interface FileGeneratorInterface {

    const RELATIVE_PATH = "";

    public function getRelativePath();

    public function getAbsolutePath();

    public function getBaseFileName();

    public function getFileName();

    public function getModule();
    
    public function getFg();
}
