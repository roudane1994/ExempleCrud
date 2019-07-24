<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Produit;
use App\Entity\Categorie;

use App\Service\CrudService;

use App\Form\CategorieType;
use App\Form\ProduitType;



class GestionController extends AbstractController
{
  
    
    /**
     * @Route("/creeCategorie/{id}", name="creeCategorie")
     */
    public function creeCategorie(Request $request,CrudService $crud,$id=-1)
    {
      if($id==-1){
        $categorie=new Categorie();
      }
      else{
          $categorie=$crud->oneCategorie($id);
      }
        $form   = $this->get('form.factory')->create(CategorieType::class,$categorie);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
        
             $crud->creeCategorie($categorie);
             return $this->redirectToRoute('listCategorie', []);
         }
        
        
        return $this->render('gestion/creeCategorie.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
     /**
     * @Route("/listCategorie/{page}", name="listCategorie")
     */
    public function listCategorie(Request $request,CrudService $crud,int $page=1)
    {
      
       $categories=$crud->listCategorie($page);
        
        
        return $this->render('gestion/listCategorie.html.twig', [
            'categories' => $categories,
        ]);
    }
    
     /**
     * @Route("/suppCategorie/{id}", name="suppCategorie")
     */
    public function suppCategorie(Request $request,CrudService $crud,$id)
    {
      
       $produits=$crud->suppCategorie($id);
        
        
       return $this->redirectToRoute('listCategorie', []);
    }
    
    /**
     * @Route("/creeProduit/{id}", name="creeProduit")
     */
    public function creeProduit(Request $request,CrudService $crud,$id=-1)
    {
      if($id==-1){
        $produit=new Produit();
      }
      else{
        $produit=$crud->oneProduit($id);  
      }
        $form   = $this->get('form.factory')->create(ProduitType::class,$produit);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
        
             $crud->creeProduit($produit);
              return $this->redirectToRoute('listProduit', []);
         }
        
        
        return $this->render('gestion/creeProduit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/{page}", name="listProduit")
     */
    public function listProduit(Request $request,CrudService $crud,int $page=1)
    {
      
       $produits=$crud->listproduit($page);
        
        
        return $this->render('gestion/listProduit.html.twig', [
            'produits' => $produits,
        ]);
    }
    
     /**
     * @Route("/suppProduit/{id}", name="suppProduit")
     */
    public function suppProduit(Request $request,CrudService $crud,$id)
    {
      
       $produits=$crud->suppProduit($id);
        
        
       return $this->redirectToRoute('listProduit', []);
    }
}
