<?php

namespace ZfMetal\Generator\Generator;

/**
 * ControllerGenerator
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class OptionPluginFactoryGenerator extends PluginFactoryGenerator {

    public function prepare() {
        parent::prepare();
        $this->genInvoke();
    }

    protected function getInvokeBody() {
        $body = '$servicio = $container->get(\'' . $this->getModule()->getName() . '.options\');' . PHP_EOL;
        $body .= 'return new \\' . $this->getModule()->getName() . '\Controller\Plugin\Options($servicio);' . PHP_EOL;

        return $body;
    }

}
