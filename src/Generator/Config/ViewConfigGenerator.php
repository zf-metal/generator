<?php

namespace ZfMetal\Generator\Generator\Config;

use ZfMetal\Generator\Generator\AbstractConfigGenerator;

/**
 * Description of ConfigGenerator
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class ViewConfigGenerator extends AbstractConfigGenerator {

    //CONSTS
    const RELATIVE_PATH = "/config/";

    protected $viewHelperConfig = array();
    protected $viewHelper;
    protected $toClass = true;

    public function getRelativePath() {
        return $this->getModule()->getName() . "/" . $this::RELATIVE_PATH;
    }

    public function getBaseFileName() {
        return "view-helper.config.php";
    }

    function getFileName() {
        return $this->getAbsolutePath() . $this->getBaseFileName();
    }

    function __construct(\ZfMetal\Generator\Entity\ViewHelper $viewHelper) {
        $this->viewHelper = $viewHelper;
    }

    public function getModule() {
        return $this->getViewHelper()->getModule();
    }

    function getViewHelper() {
        return $this->viewHelper;
    }

    public function prepare() {
        $this->getActualContent();
        $this->mergeContent();
        $this->pushFileContent();
    }

    public function getActualContent() {
        if (file_exists($this->getFileName())) {
            $config = include $this->getFileName();
            if (is_array($config)) {
                $this->viewHelperConfig = $config;
            }
        }
        return $this->viewHelperConfig;
    }

    public function pushFileContent() {
        $this->getFg()->setFilename($this->getBaseFileName());
        $this->getFg()->setBody($this->getBody());
    }

    protected function getBody() {
        $vg = new \ZfMetal\Generator\Generator\ValueGenerator($this->getVieHelperConfig(), \Zend\Code\Generator\ValueGenerator::TYPE_ARRAY);
        $body = "return ";
        $body .= $vg->generate();
        $body .= ";";
        return $body;
    }

    protected function getKeyOption() {
        return lcfirst($this->getModule()->getName()) . ucfirst($this->getViewHelper()->getName());
    }

    protected function getOptionFactory() {
        if (!$this->getViewHelper()->getInvokable()) {
            $str = $this->getModule()->getName() . '\Factory\Helper\View\\' . $this->getViewHelper()->getName() . 'Factory';
        } else {
            $str = $this->getModule()->getName() . '\Helper\View\\' . $this->getViewHelper()->getName();
        }
        $vg = $str;
        return $vg;
    }

    function getVieHelperConfig() {

        return $this->viewHelperConfig;
    }

    protected function mergeContent() {
        $this->viewHelperConfig = \Zend\Stdlib\ArrayUtils::merge($this->getVieHelperConfig(), $this->generatePluginsConfig(), TRUE);
        $this->applyClassConstant();
    }

    protected function generatePluginsConfig() {
        if ($this->getViewHelper()->getInvokable()) {
            $viewConfig = [
                'invokables' => [$this->getKeyOption() => $this->getOptionFactory()]
            ];
        } else {
            $viewConfig = [
                'factories' => [$this->getKeyOption() => $this->getOptionFactory()]
            ];
        }

        return [
            'view_helpers' =>  $viewConfig,
        ];
    }

    public function applyClassConstant() {
        if ($this->toClass) {
            if (key_exists('view_helpers', $this->viewHelperConfig)) {
                foreach ($this->viewHelperConfig["view_helpers"] as $key => $conf) {

                    foreach ($conf as $k => $v) {
                        if (class_exists($v) || $v == $this->getOptionFactory()) {
                            $v = new \Zend\Code\Generator\ValueGenerator("\\" . $v . "::class", \Zend\Code\Generator\ValueGenerator::TYPE_CONSTANT);
                        }

                        if (class_exists($k)) {
                            unset($this->viewHelperConfig["view_helpers"][$key][$k]);
                            $this->viewHelperConfig["view_helpers"][$key]["\\" . $k . "::class"] = $v;
                        } else {
                            $this->viewHelperConfig["view_helpers"][$key][$k] = $v;
                        }
                    }
                }
            }
        }
    }

}
