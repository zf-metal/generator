<?php

namespace ZfMetal\Generator\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class FormBuilder extends AbstractPlugin
{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;
    
    function __construct(\Doctrine\ORM\EntityManager $em) {
        $this->em = $em;
    }

    
    
    function getEm() {
        return $this->em;
    }

    
    public function getForm($entity)
    { 
        $builder = new \DoctrineORMModule\Form\Annotation\AnnotationBuilder($this->getEm());
        $form = $builder->createForm($entity);
        $form->setHydrator(new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($this->getEm()));
        return $form;
    }
}
