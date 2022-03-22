<?php
class Panier
{
    private $panier;
    // Panier initial
    public function __construct()
    {
        if (!isset($_SESSION['panier'])) {
            $_SESSION['panier'] = array();
        }
        $this->panier = &$_SESSION['panier'];
    }

    // Affiche le panier 
    public function getPanier(){
		return $this->panier;
	}

    
    public function ajouter($id, $qte)
    {
        if (!isset($this->panier[$id])) {
            $this->panier[$id] = 0; 
        }
        $this->panier[$id] += $qte;
    }
    
    public function retirer($id)
    {
       unset($this->panier[$id]); 
    }    
  
    public function vider()
    {
        $this->panier = array();
    }  

    public function ajouterQte($id)
    {
        $this->panier[$id] += 1;
    }

    public function retirerQte($id)
    {
        if ($this->panier[$id] == 1) {

          unset($this->panier[$id]);
        }
        else{
        $this->panier[$id] -= 1;
        }
    }
}
