<?php

$setting = array_merge(
        include 'cdi-datagrid-custom/cdidatagrid.config.php',
        include 'cdi-datagrid-custom/module.cdigrid.config.php', 
        include 'cdi-datagrid-custom/entity.cdigrid.config.php', 
        include 'cdi-datagrid-custom/property.cdigrid.config.php',
        include 'cdi-datagrid-custom/route.cdigrid.config.php',
        include 'cdi-datagrid-custom/controller.cdigrid.config.php',
        include 'cdi-datagrid-custom/action.cdigrid.config.php',
         include 'cdi-datagrid-custom/controller_commons.cdigrid.config.php'
);

return $setting;
