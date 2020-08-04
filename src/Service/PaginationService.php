<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class PaginationService {

    private $entityClass;
    private $limit = 10;
    private $currentPage = 1;
    private $man;



    public function __construct(EntityManagerInterface $manager)
    {
        $this->man = $manager;
    }


    public function getPages(){
        //faire le total des enregistrements de la table
        $repo = $this->man->getRepository($this->entityClass);

        $total = count($repo->findAll());


        //faire la division, l'arrondie et l'envoye
        $pages = ceil($total/$this->limit);
        return $pages;
        
    }

    public function getData(){

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
}