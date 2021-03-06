<?php

namespace Controller;

use \W\Controller\Controller;
use \W\Security\AuthentificationModel;
use \Model\UserModel;
use \Model\DefaultModel;
use \Model\BuildingsModel;
use \Model\RessourcesModel;

class DefaultController extends Controller
{
	public function camp()
	{
		$DefaultModel = new DefaultModel();
		$DefaultModel->refreshTimer();
		spl_autoload_register(function($class) {
		    include  $class . '.php';
		});
		$bucheron = new \Buildings\Bucheron();
		$ferme = new \Buildings\Ferme();
		$puit = new \Buildings\Puit();
		$hangar = new \Buildings\Hangar();
		$garde_manger = new \Buildings\GardeManger();
		$citerne = new \Buildings\Citerne();
		$cabane = new \Buildings\Cabane();
		$mur = new \Buildings\Mur();
		$radio = new \Buildings\StationRadio();

		$this->show('default/camp', [
										"bucheron" 		=> $bucheron,
										"ferme"			=> $ferme,
										"puit"			=> $puit,
										"hangar"		=> $hangar,
										"garde_manger"	=> $garde_manger,
										"citerne"		=> $citerne,
										"cabane"		=> $cabane,
										"mur"			=> $mur,
										"radio"			=> $radio
									] );


	}

	public function building($idBuilding)
	{
		$DefaultModel = new DefaultModel();
		$DefaultModel->refreshTimer();
		$this->show('default/building');
	}

	public function classement()
	{
		$DefaultModel = new DefaultModel();
		$user_manager = new UserModel();

		$users = $user_manager->findAllJoinCampers("camper", "DESC");

		$DefaultModel->refreshTimer();
		$this->show('default/classement', [
			'users' => $users,
		]);
	}

	public function tchat()
	{
		$DefaultModel = new DefaultModel();
		$DefaultModel->refreshTimer();
		$this->show('default/tchat');
	}

	public function upgrade ($idBuilding) {
		$DefaultModel = new DefaultModel();
		$UserModel = new UserModel();

		if ($idBuilding == 2) {
			$bucheron = new \Buildings\Bucheron();
			$bucheron->SetNiveau();
		}

		if ($idBuilding == 3) {
			$ferme = new \Buildings\Ferme();
			$ferme->SetNiveau();
		}

		if ($idBuilding == 4) {
			$puit = new \Buildings\Puit();
			$puit->SetNiveau();
			var_dump($puit);
		}

		if ($idBuilding == 5) {
			$hangar = new \Buildings\Hangar();
			$hangar->SetNiveau();
		}

		if ($idBuilding == 6) {
			$garde_manger = new \Buildings\GardeManger();
			$garde_manger->SetNiveau();
		}

		if ($idBuilding == 7) {
			$citerne = new \Buildings\Citerne();
			$citerne->SetNiveau();
		}

		if ($idBuilding == 8) {
			$cabane = new \Buildings\Cabane();
			$cabane->SetNiveau();
		}

		if ($idBuilding == 9) {
			$radio = new \Buildings\StationRadio();
			$radio->SetNiveau();
		}

		if ($idBuilding == 10) {
			$mur = new \Buildings\Mur();
			$mur->SetNiveau();
		}


		$this->redirectToRoute('default_camp');
	}

}
