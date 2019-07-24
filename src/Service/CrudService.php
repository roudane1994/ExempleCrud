<?php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Produit;
use App\Entity\Categorie;
use Knp\Component\Pager\PaginatorInterface;


class CrudService {
    
    private $em;
    private $paginator;
    private $max_line;
    
    public function __construct(EntityManagerInterface $em, PaginatorInterface $paginator) {
        
        $this->em=$em;
        $this->paginator=$paginator;
        $this->max_line=3;
  
    }
    
    public function creeCategorie(Categorie $categorie){
        $this->em->persist($categorie);
        $this->em->flush();    
    }

     public function suppCategorie(int $id){
        $categorie = $this->em->getRepository(Categorie::class)->find($id);
        $produits = $this->em->getRepository(Produit::class)->findBy(array('categorie' =>$categorie));
        foreach ($produits as $p) {
           $this->em->remove($p);
           }  
        $this->em->remove($categorie);
        $this->em->flush();    
    }
    
     public function oneCategorie(int $id):Categorie{
        return $this->em->getRepository(Categorie::class)->find($id);
          
    }
    
     public function listCategorie(int $page){
        $categories= $this->em->getRepository(Categorie::class)->findAll();
        
         $categories_p = $this->paginator->paginate($categories,$page,$this->max_line);
         
        
         
         return $categories_p;
          
    }
      public function creeProduit(Produit $produit){
        $this->em->persist($produit);
        $this->em->flush();    
    }
       public function listproduit(int $page){
           
         $produits= $this->em->getRepository(Produit::class)->findAll();  
         
         $produits_p = $this->paginator->paginate($produits,$page,$this->max_line);
         
         return $produits_p;
         
         
         
    }
    
      public function suppProduit(int $id){
        $produit = $this->em->getRepository(Produit::class)->find($id);
        $this->em->remove($produit);
        $this->em->flush();    
    }
     public function oneProduit(int $id):Produit{
        return $this->em->getRepository(Produit::class)->find($id);
          
    }
}
