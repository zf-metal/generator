<?php

namespace ZfMetal\Generator;

/**
* @author Cristian Incarnato <cristian.cdi@gmail.com>
*/

$setting = array_merge(
        include 'controller.config.php', 
        include 'doctrine.config.php', 
        include 'navigation.config.php', 
        include 'options.config.php', 
        include 'rbac.config.php', 
        include 'route.config.php', 
        include 'view.config.php',
        include 'services.config.php',
        include 'plugins.config.php',
        include 'datagrid.config.php'
);

return $setting;
