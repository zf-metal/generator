<?php

$setting = array_merge(
        include 'datagrid/datagrid.config.php',
        include 'datagrid/module.config.php', 
        include 'datagrid/entity.config.php', 
        include 'datagrid/property.config.php',
        include 'datagrid/route.config.php',
        include 'datagrid/controller.config.php',
        include 'datagrid/action.config.php',
         include 'datagrid/controller_commons.config.php'
);

return $setting;
