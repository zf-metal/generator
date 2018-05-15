<?php

namespace ZfMetal\Generator\Generator\Config;

use ZfMetal\Generator\Generator\AbstractConfigGenerator;

/**
 * Description of ConfigGenerator
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class RouteConfigGenerator extends AbstractConfigGenerator
{

    //CONSTS
    const RELATIVE_PATH = "/config/";

    protected $actualRouteConfig = array();
    protected $generatorRouteConfig = array();
    protected $routeConfig = array();
    protected $routeCollection;
    protected $module;

    public function getRelativePath()
    {
        return $this->getModule()->getName() . "/" . $this::RELATIVE_PATH;
    }

    public function getBaseFileName()
    {
        return "route.config.php";
    }

    function getFileName()
    {
        return $this->getAbsolutePath() . $this->getBaseFileName();
    }

    function __construct(\ZfMetal\Generator\Entity\Module $module, $routeCollection)
    {
        $this->module = $module;
        $this->routeCollection = $routeCollection;
    }

    public function getModule()
    {
        return $this->module;
    }

    public function prepare()
    {
        $this->populateActualConfig();
        $this->populateGeneratorConfig();
        $this->mergeConfig();
        $this->pushFileContent();
    }

    protected function mergeConfig()
    {
        //$this->routeConfig = array_merge_recursive($this->actualRouteConfig,$this->generatorRouteConfig);
        $this->routeConfig = \Zend\Stdlib\ArrayUtils::merge($this->actualRouteConfig, $this->generatorRouteConfig, true);

        return $this->routeConfig;
    }

    protected function populateActualConfig()
    {
        if (file_exists($this->getFileName())) {
            $config = include $this->getFileName();
            if (is_array($config)) {
                $this->actualRouteConfig = $config;
            }
        }
        return $this->actualRouteConfig;
    }

    protected function populateGeneratorConfig()
    {
        $this->generatorRouteConfig['router']['routes'] = array();
        foreach ($this->getRouteCollection() as $route) {
            $this->generatorRouteConfig['router']['routes'][$route->getName()] = array();
            $this->generatorRouteConfig['router']['routes'][$route->getName()] = $this->addRoute($route);
        }
    }

    protected function addRoute(\ZfMetal\Generator\Entity\Route $route)
    {


        $a = [
            'mayTerminate' => $route->getMayTerminate(),
            'options' => [
                'route' => $route->getRoute(),

            ],
        ];

        if($route->getType() == "Literal" || $route->getType() == "Segment"){
            $a['type'] = $route->getType();
        }else{
            $a['verb'] = $route->getType();
        }


        if ($route->getController() && $route->getAction()) {
            $controller = new \Zend\Code\Generator\ValueGenerator($route->getController()->getClass() . "::CLASS", \Zend\Code\Generator\ValueGenerator::TYPE_CONSTANT);

            $a['options'] = ['defaults' => [
                'controller' => $controller,
                'action' => $route->getAction()->getName()
            ]
            ];
        }

        if ($route->hasChilds()) {

            foreach ($route->getChilds() as $child) {
                $a['child_routes'][$child->getName()] = array();
                $a['child_routes'][$child->getName()] = $this->addRoute($child);
            }
        }

        return $a;
    }

    public function pushFileContent()
    {
        $this->getFg()->setFilename($this->getBaseFileName());
        $this->getFg()->setBody($this->getBody());
    }

    protected function getBody()
    {
        $vg = new \ZfMetal\Generator\Generator\ValueGenerator($this->getRouteConfig(), \Zend\Code\Generator\ValueGenerator::TYPE_ARRAY_SHORT);
        $body = "return ";
        $body .= $vg->generate();
        $body .= ";";
        return $body;
    }

    function getRouteConfig()
    {
        return $this->routeConfig;
    }

    function getRouteCollection()
    {
        return $this->routeCollection;
    }

}
