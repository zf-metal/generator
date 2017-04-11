<?php

namespace ZfMetal\Generator\Generator\Config;

use ZfMetal\Generator\Generator\AbstractConfigGenerator;

/**
 * Description of ConfigGenerator
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class PluginsConfigGenerator extends AbstractConfigGenerator {

    //CONSTS
    const RELATIVE_PATH = "/config/";

    protected $pluginsConfig = array();
    protected $plugin;
    protected $toClass = true;

    public function getRelativePath() {
        return $this->getModule()->getName() . "/" . $this::RELATIVE_PATH;
    }

    public function getBaseFileName() {
        return "plugins.config.php";
    }

    function getFileName() {
        return $this->getAbsolutePath() . $this->getBaseFileName();
    }

    function __construct(\ZfMetal\Generator\Entity\Plugin $plugin) {
        $this->plugin = $plugin;
    }

    public function getModule() {
        return $this->getPlugin()->getModule();
    }

    function getPlugin() {
        return $this->plugin;
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
                $this->pluginsConfig = $config;
            }
        }
        return $this->pluginsConfig;
    }

    public function pushFileContent() {
        $this->getFg()->setFilename($this->getBaseFileName());
        $this->getFg()->setBody($this->getBody());
    }

    protected function getBody() {
        $vg = new \ZfMetal\Generator\Generator\ValueGenerator($this->getPluginsConfig(), \Zend\Code\Generator\ValueGenerator::TYPE_ARRAY);
        $body = "return ";
        $body .= $vg->generate();
        $body .= ";";
        return $body;
    }

    protected function getKeyOption() {
        return $this->getModule()->getName() . '\Controller\Plugin\\' . $this->getPlugin()->getName();
    }

    protected function getOptionFactory() {
        if (!$this->getPlugin()->getInvokable()) {
            $str = $this->getModule()->getName() . '\Factory\Controller\Plugin\\' . $this->getPlugin()->getName() . 'Factory';
        } else {
            $str = 'Zend\ServiceManager\Factory\InvokableFactory';
        }
        $vg = $str;
        return $vg;
    }

    function getPluginsConfig() {

        return $this->pluginsConfig;
    }

    protected function mergeContent() {
        $this->pluginsConfig = \Zend\Stdlib\ArrayUtils::merge($this->getPluginsConfig(), $this->generatePluginsConfig(), TRUE);
        $this->applyClassConstant();
    }

    protected function generatePluginsConfig() {
        return [
            'controller_plugins' => [
                'factories' => [
                    $this->getKeyOption() => $this->getOptionFactory(),
                ],
                'aliases' => [
                    lcfirst($this->getPlugin()->getName()) => new \Zend\Code\Generator\ValueGenerator("\\" . $this->getKeyOption() . "::class", \Zend\Code\Generator\ValueGenerator::TYPE_CONSTANT)
                ]
            ]
        ];
    }

    public function applyClassConstant() {
        if ($this->toClass) {
            if (key_exists('controller_plugins', $this->pluginsConfig)) {
                foreach ($this->pluginsConfig["controller_plugins"] as $key => $conf) {

                    foreach ($conf as $k => $v) {
                        if (class_exists($v) || $v == $this->getOptionFactory()) {
                            $v = new \Zend\Code\Generator\ValueGenerator("\\" . $v . "::class", \Zend\Code\Generator\ValueGenerator::TYPE_CONSTANT);
                        }

                        if (class_exists($k) || $k == $this->getKeyOption()) {
                            unset($this->pluginsConfig["controller_plugins"][$key][$k]);
                            $this->pluginsConfig["controller_plugins"][$key]["\\" . $k . "::class"] = $v;
                        } else {
                            $this->pluginsConfig["controller_plugins"][$key][$k] = $v;
                        }
                    }
                }
            }
        }
    }

}
