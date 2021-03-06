<?php 

namespace Buildings;

use \Model\UserModel;
/**
* 
*/
class GardeManger
{
	private $nom = "food_stock";
	private $RatioStock = 2;
	private $StockageBase = 2000;
	private $StockageCourant;

	private $RatioPrix = 2;
	private $PrixBoisBase = 1000;
	private $PrixBoisCourant;
	private $PrixNourritureBase = 1000;
	private $PrixNourritureCourant;

	private $RatioTemps = 1.6;
	private $TempsBase = 25;
	private $TempsCourant; 
	
	private $Niveau = 5;

	public function __construct () {
		$this->Niveau = $_SESSION["buildings"]->food_stock;
		$this->SetStock();
		$this->SetPrix();
		$this->SetTemps();
	}

	public function SetStock () {
		if ($this->Niveau !== 0) {
			$this->StockageCourant = round($this->StockageBase * pow($this->RatioStock, ($this->Niveau - 1)) + $this->StockageBase);
		} else {
			$this->StockageCourant = $this->StockageBase;
		}
	}

	public function GetStock () {
		return $this->StockageCourant;
	}

	public function SetPrix () {
		if ($this->Niveau !== 0) {
			$this->PrixBoisCourant = round($this->PrixBoisBase * pow($this->RatioPrix, ($this->Niveau - 1)) + $this->PrixBoisBase);
		} else {
			$this->PrixBoisCourant = $this->PrixBoisBase;
		}

		if ($this->Niveau !== 0) {
			$this->PrixNourritureCourant = round($this->PrixNourritureBase * pow($this->RatioPrix, ($this->Niveau - 1)) + $this->PrixNourritureBase);
		} else {
			$this->PrixNourritureCourant = $this->PrixNourritureBase;
		}
	}

	public function GetPrixBois () {
		return $this->PrixBoisCourant;
	}

	public function GetPrixNourriture () {
		return $this->PrixNourritureCourant;
	}

	public function SetTemps () {
		if ($this->Niveau !== 0) {
			$this->TempsCourant = round($this->TempsBase * pow($this->RatioTemps, ($this->Niveau - 1)) + $this->TempsBase);
		} else {
			$this->TempsCourant = $this->TempsBase;
		}
	}

	public function GetTemps () {
		return $this->TempsCourant;
	}

	public function SetNiveau () {
		// Requête récupération ressources de l'utilisateur

		if (($_SESSION["ressources"]->wood >= $this->PrixBoisCourant && $_SESSION["ressources"]->food >= $this->PrixNourritureCourant)) {
			
			$UserModel = new UserModel();
			$this->Niveau = $this->Niveau + 1;
			$id_user = $_SESSION["user"]["id"];

			$UserModel->refreshBuildings($this->nom, ":".$this->nom, $this->Niveau, $id_user);
			$nom = $this->nom;
			$_SESSION["buildings"]->$nom = $this->Niveau;

			// Requête suppression des ressources en fonction du prix
			

			$wood 	= &$_SESSION["ressources"]->wood;
            $water 	= &$_SESSION["ressources"]->water;
	        $food 	= &$_SESSION["ressources"]->food;

	        $wood 	-= $this->PrixBoisCourant;
            $food 	-= $this->PrixNourritureCourant;

			$UserModel->refreshRessources($wood, $water, $food, $id_user);

		} else {
			// Afficher message manque de ressource dans une div 
			echo "Manque de ressource";
		}
	}
}

