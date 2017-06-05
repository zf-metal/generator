<?php

namespace ZfMetal\Generator\Generator\Config;

use ZfMetal\Generator\Generator\AbstractConfigGenerator;

/**
 * Description of ConfigGenerator
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class DatagridConfigGenerator extends AbstractConfigGenerator {

    //CONSTS
    const RELATIVE_PATH = "/config/";

    protected $actualDatagridConfig = array();
    protected $generatorDatagridConfig = array();
    protected $datagridConfig = array();
    protected $entity;

    public function getRelativePath() {
        return $this->getModule()->getName() . "/" . $this::RELATIVE_PATH;
    }

    public function getBaseFileName() {
        return "zfm-datagrid." . \ZfMetal\Generator\Generator\Util::camelToDash($this->getEntity()->getName()) . ".config.php";
    }

    function getFileName() {
        return $this->getAbsolutePath() . $this->getBaseFileName();
    }

    function getEntity() {
        return $this->entity;
    }

    function __construct(\ZfMetal\Generator\Entity\Entity $entity) {
        $this->entity = $entity;
    }

    public function getModule() {
        return $this->getEntity()->getModule();
    }

    public function prepare() {
        $this->populateActualConfig();
        $this->populateGeneratorConfig();
        $this->mergeConfig();
        $this->pushFileContent();
    }

    protected function mergeConfig() {
        $this->datagridConfig = \Zend\Stdlib\ArrayUtils::merge($this->actualDatagridConfig, $this->generatorDatagridConfig, true);

        return $this->datagridConfig;
    }

    protected function populateActualConfig() {
        if (file_exists($this->getFileName())) {
            $config = include $this->getFileName();
            if (is_array($config)) {
                $this->actualDatagridConfig = $config;
            }
        }
        return $this->actualDatagridConfig;
    }

    protected function populateGeneratorConfig() {
        $this->generatorDatagridConfig['zf-metal-datagrid.custom'] = array();
        $key = trim(str_replace("\\", "-", strtolower($this->getEntity()->getFullName())), "-");
        $this->generatorDatagridConfig['zf-metal-datagrid.custom'][$key]["gridId"] = $this->genGridId();
        $this->generatorDatagridConfig['zf-metal-datagrid.custom'][$key]["sourceConfig"] = $this->genSourceConfig();
        $this->generatorDatagridConfig['zf-metal-datagrid.custom'][$key]["formConfig"] = $this->genFormConfig();
        $this->generatorDatagridConfig['zf-metal-datagrid.custom'][$key]["columnsConfig"] = $this->genColumnsConfig();
        $this->generatorDatagridConfig['zf-metal-datagrid.custom'][$key]["crudConfig"] = $this->genCrudConfig();
    }

    protected function genGridId() {
        return "zfmdg_" . $this->getEntity()->getName();
    }

    protected function genSourceConfig() {
        return [
            "type" => "doctrine",
            "doctrineOptions" => [
                "entityName" => new \Zend\Code\Generator\ValueGenerator($this->getEntity()->getFullName() . '::class', \Zend\Code\Generator\ValueGenerator::TYPE_CONSTANT),
                "entityManager" => "doctrine.entitymanager.orm_default"
            ]
        ];
    }

    protected function genFormConfig() {
        return [
            'columns' => new \Zend\Code\Generator\ValueGenerator('\ZfMetal\Commons\Consts::COLUMNS_ONE', \Zend\Code\Generator\ValueGenerator::TYPE_CONSTANT),
            'style' => new \Zend\Code\Generator\ValueGenerator('\ZfMetal\Commons\Consts::STYLE_VERTICAL', \Zend\Code\Generator\ValueGenerator::TYPE_CONSTANT),
            'groups' => [
            ],
        ];
    }

    protected function genColumnsConfig() {
        $a = array();
        /* @var $property \ZfMetal\Generator\Entity\Property */
        foreach ($this->getEntity()->getProperties() as $property) {

            if ($property->getLabel()) {
                $a[$property->getName()]["displayName"] = $property->getLabel();
            }

            if ($property->getHiddenDatagrid()) {
                $a[$property->getName()]["hidden"] = true;
            } else {
                switch ($property->getType()) {
                    case "oneToMany":
                    case "manyToMany":
                        $a[$property->getName()]["hidden"] = true;
                        break;
                    case "oneToOne":
                    case "manyToOne":
                        $a[$property->getName()]["type"] = "relational";
                        break;
                    case "date":
                        $a[$property->getName()]["type"] = "date";
                        $a[$property->getName()]["format"] = "Y-m-d";
                        break;
                    case "datetime":
                        $a[$property->getName()]["type"] = "date";
                        $a[$property->getName()]["format"] = "Y-m-d H:i:s";
                        break;
                    default:
                        break;
                }
            }
        }
        return $a;
    }

    protected function genCrudConfig() {
        return [
            "enable" => true,
            "add" => [
                "enable" => true,
                'class' => " glyphicon glyphicon-plus cursor-pointer",
                "value" => ""
            ],
            "edit" => [
                "enable" => true,
                'class' => " glyphicon glyphicon-edit cursor-pointer",
                "value" => ""
            ],
            "del" => [
                "enable" => true,
                'class' => " glyphicon glyphicon-trash cursor-pointer",
                "value" => ""
            ],
            "view" => [
                "enable" => true,
                'class' => " glyphicon glyphicon-list-alt cursor-pointer",
                "value" => ""
            ],
        ];
    }

    public function pushFileContent() {
        $this->getFg()->setFilename($this->getBaseFileName());
        $this->getFg()->setBody($this->getBody());
    }

    protected function getBody() {
        $vg = new \ZfMetal\Generator\Generator\ValueGenerator($this->getDatagridConfig(), \Zend\Code\Generator\ValueGenerator::TYPE_ARRAY_SHORT);
        $body = "return ";
        $body .= $vg->generate();
        $body .= ";";
        return $body;
    }

    function getDatagridConfig() {
        return $this->datagridConfig;
    }

}
