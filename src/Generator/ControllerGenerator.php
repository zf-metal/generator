<?php

namespace ZfMetal\Generator\Generator;

/**
 * ControllerGenerator
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class ControllerGenerator extends AbstractClassGenerator {

    //CONSTS
    const CLASS_PREFIX = "";
    const CLASS_SUBFFIX = "Controller";
    const NAMESPACE_PREFIX = "";
    const NAMESPACE_SUBFFIX = "\Controller";
    const RELATIVE_PATH = "/src/Controller/";

    //BASE NAMES
    public function getBaseName() {
        return $this->getController()->getName();
    }

    public function getBaseNamespace() {
        return $this->getController()->getModule()->getName();
    }

    //CLASS METHODS

    public function getClassExtends() {
        return "Zend\Mvc\Controller\AbstractActionController";
    }

    public function getClassInterfaces() {
        return [];
    }

    public function getClassTags() {
        return [];
    }

    public function getClassUses() {
        return [
            ["class" => "Zend\Mvc\Controller\AbstractActionController", "alias" => null],
        ];
    }

    //MODULE
    public function getModule() {
        return $this->getController()->getModule();
    }

    //NORMAL CLASS TAGS
    public function getLongDescription() {
        return $this->getController()->getDescription();
    }

    /**
     * Description
     * 
     * @var \ZfMetal\Generator\Entity\Controller
     */
    private $controller;

    function __construct($controller) {
        $this->controller = $controller;
    }

    function getController() {
        return $this->controller;
    }

    function setController(\ZfMetal\Generator\Entity\Controller $controller) {

        $this->controller = $controller;
    }

    public function getConstruct() {
        if (!$this->getCg()->getMethod("__construct")) {
            $this->genConstruct();
        }
        return $this->getCg()->getMethod("__construct");
    }

    protected function genConstruct() {
        $method = new \Zend\Code\Generator\MethodGenerator();
        $method->setName("__construct");
        $this->getCg()->addMethodFromGenerator($method);
    }

    public function prepare() {
        //PARENT
        parent::prepare();
        //CUSTOMS
        $this->genCommons();
        //ACTIONS
        $this->genActions();
    }

    protected function genCommons() {
        if ($this->getController()->getEntity()) {
            \ZfMetal\Generator\Generator\Commons\EmGenerator::applyEm($this);

            if ($this->getController()->getGridAction()) {
                \ZfMetal\Generator\Generator\Commons\GridActionGenerator::applyGridAction($this);

                //Generate Grid View //Need Improve...
                $this->genGridView();
                $this->genGridConfig();
            }
        }
    }

    protected function genGridView() {
        $action = new \ZfMetal\Generator\Entity\Action();
        $action->setName("grid");
        $action->setController($this->getController());
        $gv = new \ZfMetal\Generator\Generator\ViewActionGenerator($action);
        $gv->setBody('<?php echo $this->Grid($this->grid); ?>');
        $gv->pushFile();
    }
    
      protected function genGridConfig() {
          $gdc = new \ZfMetal\Generator\Generator\Config\DatagridConfigGenerator($this->getController()->getEntity());
          $gdc->prepare();
          $gdc->pushFile();
      }

    protected function genActions() {
        foreach ($this->getController()->getActions() as $action) {
            $actionGenerator = new \ZfMetal\Generator\Generator\ActionGenerator($this->getCg(), $action);
            $actionGenerator->generate();

            $this->genActionView($action);
        }
    }

    protected function genActionView($action) {
        $gv = new \ZfMetal\Generator\Generator\ViewActionGenerator($action);
        $gv->prepare();
        $gv->pushFile();
    }

}
