## ZfMetal Generator Documentation


### Persistence

Persistence is in sqlite. This allows you to move the configuration made in ZfMetal Generator.

#### Default path 

The default directory is in vendor (vendor/zf-metal/generator/data/zf-metal-generator/generator.db)

You can move generator.db to the project data folder to keep the configuration in the project repository.

1. Move vendor/zf-metal/generator/data/zf-metal-generator/generator.db to data/zf-metal-generator/generator.db
2. Move vendor/zf-metal/generator/data/config/autoload/doctrine-generator.global.php to config/autoload/doctrine-generator.global.php


### Update Schema

'''
vendor/bin/doctrine-module.bat orm:schema-tool:update --force --em=orm_zf_metal_generator

'''

### Start

1. Go to /generator/main
2. Create a module "+"