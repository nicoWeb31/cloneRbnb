<?php

namespace App\Service;

use Twig\Environment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class PaginationService {

    private $entityClass;
    private $limit = 10;
    private $currentPage = 1;
    private $man;
    private $twig;
    private $route;
    private $templetePath;



    public function __construct(EntityManagerInterface $manager, Environment $twig, RequestStack $req, $templetePath)
    {
        $this->man = $manager;
        $this->twig = $twig;
        $this->route = $req->getCurrentRequest()->attributes->get('_route');
        $this->templetePath = $templetePath;
    }


    public function getPages(){


        if(empty($this->entityClass)){

            throw new \Exception("Vous n'avez pas specifier d'entités  sur laquel nous devons paginer ! utilisez setEntityClass ");
        }


        //faire le total des enregistrements de la table
        $repo = $this->man->getRepository($this->entityClass);

        $total = count($repo->findAll());


        //faire la division, l'arrondie et l'envoye
        $pages = ceil($total/$this->limit);
        return $pages;
        
    }

    public function getData(){

        if(empty($this->entityClass)){

            throw new \Exception("Vous n'avez pas specifier d'entités  sur laquel nous devons paginer ! utilisez setEntityClass ");
        }
        //calculer l'offset
        $offset = $this->currentPage * $this->limit  - $this->limit;

        //demande du repo
        $repo = $this->man->getRepository($this->entityClass);
        $data = $repo->findBy([],[],$this->limit,$offset);

        //renvoyer les elements


        return $data;

    }

    /**
     * Get the value of currentPage
     */ 
    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    /**
     * Set the value of currentPage
     *
     * @return  self
     */ 
    public function setCurrentPage($currentPage)
    {
        $this->currentPage = $currentPage;

        return $this;
    }

    /**
     * Get the value of limit
     */ 
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * Set the value of limit
     *
     * @return  self
     */ 
    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * Get the value of entityClass
     */ 
    public function getEntityClass()
    {
        return $this->entityClass;
    }

    /**
     * Set the value of entityClass
     *
     * @return  self
     */ 
    public function setEntityClass($entityClass)
    {
        $this->entityClass = $entityClass;

        return $this;
    }


    /**
     * Render du contenu du partial en integrant les variables necéssaire
     *
     * @return  self
     */ 
    public function render()
    {
    $this->twig->display($this->getTempletePath(),[

        'page'=>$this->currentPage,
        'nbrPage'=>$this->getPages(),
        'route'=> $this->getRoute()

    ]);
    }




    /**
     * Set the value of route
     *
     * @return  self
     */ 
    public function setRoute($route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * Get the value of route
     */ 
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Get the value of templetePath
     */ 
    public function getTempletePath()
    {
        return $this->templetePath;
    }

    /**
     * Set the value of templetePath
     *
     * @return  self
     */ 
    public function setTempletePath($templetePath)
    {
        $this->templetePath = $templetePath;

        return $this;
    }
}