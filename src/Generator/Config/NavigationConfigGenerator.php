<?php

namespace ZfMetal\Generator\Generator\Config;

use ZfMetal\Generator\Generator\AbstractConfigGenerator;

/**
 * Description of ConfigGenerator
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class NavigationConfigGenerator extends AbstractConfigGenerator {

    //CONSTS
    const RELATIVE_PATH = "/config/";

    protected $actualNavigationConfig = array();
    protected $generatorNavigationConfig = array();
    protected $navigationConfig = array();
    protected $navigationCollection;
    protected $module;

    public function getRelativePath() {
        return $this->getModule()->getName() . "/" . $this::RELATIVE_PATH;
    }

    public function getBaseFileName() {
        return "navigation.config.php";
    }

    function getFileName() {
        return $this->getAbsolutePath() . $this->getBaseFileName();
    }

    function __construct(\ZfMetal\Generator\Entity\Module $module, $navigationCollection) {
        $this->module = $module;
        $this->navigationCollection = $navigationCollection;
    }

    public function getModule() {
        return $this->module;
    }

    public function prepare() {
        $this->populateActualConfig();
        $this->populateGeneratorConfig();
        $this->mergeConfig();
        $this->pushFileContent();
    }

    protected function mergeConfig() {
        //$this->navigationConfig = array_merge_recursive($this->actualNavigationConfig,$this->generatorNavigationConfig);
        $this->navigationConfig = \Zend\Stdlib\ArrayUtils::merge($this->actualNavigationConfig, $this->generatorNavigationConfig, true);

        return $this->navigationConfig;
    }

    protected function populateActualConfig() {
        if (file_exists($this->getFileName())) {
            $config = include $this->getFileName();
            if (is_array($config)) {
                $this->actualNavigationConfig = $config;
            }
        }
        return $this->actualNavigationConfig;
    }

    protected function populateGeneratorConfig() {
        foreach ($this->getNavigationCollection() as $navigation) {
            array_push($this->generatorNavigationConfig['navigation']['default'], $this->addNavigation($navigation));
        }
    }

    protected function addNavigation(\ZfMetal\Generator\Entity\Navigation $navigation) {
        $a["label"] = $navigation->getLabel();
        $a["detail"] = $navigation->getDetail();
        $a["icon"] = $navigation->getIcon();
        $a["permission"] = $navigation->getPermission();
        if ($navigation->getRoute()) {
            $a["route"] = $navigation->getRoute()->finalRouteName();
        } else {
            $a["uri"] = $navigation->getUri();
        }


        if ($navigation->hasChilds()) {
            foreach ($navigation->getChilds() as $child) {
                array_push($a['pages'], $this->addNavigation($child));
            }
        }

        return $a;
    }

    public function pushFileContent() {
        $this->getFg()->setFilename($this->getBaseFileName());
        $this->getFg()->setBody($this->getBody());
    }

    protected function getBody() {
        $vg = new \ZfMetal\Generator\Generator\ValueGenerator($this->getNavigationConfig(), \Zend\Code\Generator\ValueGenerator::TYPE_ARRAY_SHORT);
        $body = "return ";
        $body .= $vg->generate();
        $body .= ";";
        return $body;
    }

    function getNavigationConfig() {
        return $this->navigationConfig;
    }

    function getNavigationCollection() {
        return $this->navigationCollection;
    }

}
