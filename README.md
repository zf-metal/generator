## ZF GENERATOR: Development accelerator

Friendly and fast interface to generate Zend Framework 3 modules focused on Doctrine 2.

### Features
- Generate module. (Directory, Module.php, module.config.php, composer.json psr4 autoload, composer dump-autoload)
- Doctrine Entity. (string, text, integer, date/time, decimal, boolean, OneToOne, ManyToOne, OneToMany, ManyToMany)
- Controllers (Include Controller, ControllerFactory and controller.config.php)
- Action Templates (Code template for Method and View)
- Actions (Generate Method and View. Optional Route. Optional Template)
- Route (BootrsapTreeView for friendly ABM)
- Navigation (BootrsapTreeView for friendly ABM)
- ModuleOption (Include ModuleOption.php and ModuleOptionFactory.php) (Also include PluginController and ViewHelper)
- View Helpers (Class, Factory and Config)
- Plugin Controllers (Class, Factory and Config)
- Forms (Comming soon)

#### ZfMetal Team:
- Cristian Incarnato cristian.cdi@gmail.com
- Alejandro Furgeri alesitoman@gmail.com

### Docs/Wiki

[Documentation](/docs/index.md)

### Modules Dependency (Important!)

Add the following modules to modules.config.php, at least in developer mode for use ZfMetal Generator

    'Zend\Router',
    'Zend\Validator',
    'Zend\I18n',
    "DoctrineModule",
    'DoctrineORMModule',
    'SwissEngine\Tools\Doctrine\Extension',
    'ZfMetal\Commons',
    'ZfMetal\Datagrid',
    'ZfMetal\Generator'

### CSS Dependency

Bootstrap 3

### Preview

#### Entity
![alt text](/docs/img/generator_entity.jpg)

#### Route
![alt text](/docs/img/generator_route.jpg)