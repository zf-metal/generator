<?php

namespace ZfMetal\Generator\Generator;

/**
 * ControllerGenerator
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class OptionViewHelperFactoryGenerator extends ViewHelperFactoryGenerator {

    protected function getInvokeBody() {
        $body = '$servicio = $container->get(\'' . $this->getModule()->getName() . '.options\');' . PHP_EOL;
        $body .= 'return new \\' . $this->getModule()->getName() . '\Helper\View\Options($servicio);' . PHP_EOL;

        return $body;
    }

}
