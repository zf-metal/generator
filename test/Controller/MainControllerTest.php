<?php

namespace Test\Controller;

use Doctrine\ORM\EntityManager;

use PHPUnit\Framework\TestCase;
use Zend\Crypt\Password\Bcrypt;
use Zend\Http\Request;
use Zend\ServiceManager\ServiceManager;
use ZfMetal\Security\Repository\UserRepository;
use ZfMetal\SecurityJwt\Controller\JwtController;
use ZfMetal\SecurityJwt\Options\ModuleOptions;
use ZfMetal\SecurityJwt\Service\JwtService;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class MainControllerTest extends AbstractHttpControllerTestCase
{



    /**
     * Inicializo el MVC
     */
    public function setUp()
    {
        $this->setApplicationConfig(
            include __DIR__ . '/../config/application.config.php'
        );
        parent::setUp();
    }


    /**
     * Verifico un controlador protegido sin token
     */
    public function testMainAction()
    {
        $this->dispatch("/generator/main", "get");

        echo $this->getResponse()->getContent();
        $this->assertResponseStatusCode(200);
    }

    //TODO Test all controllers and generated files

}
