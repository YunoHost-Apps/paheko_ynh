<?php

/**
 * Ce fichier est ici pour ajouter des personnalisations à votre configuration.
 *
 * Modifiez ce fichier à votre guise, il ne sera pas modifié lors des prochaines mises à jour.
 * Consultez le fichier __INSTALL_DIR__/config.local.php pour choisir des constantes à ajouter.
 * Pour une nouvelle installation, ce fichier sera pris en compte après la première mise à jour.
 */

// Nécessaire pour situer les constantes dans le bon namespace
namespace Paheko;

if (array_key_exists('REMOTE_USER', $_SERVER)) {
	$username = $_SERVER["REMOTE_USER"];
	define('Paheko\LOCAL_LOGIN', [
		'user' => [
			'_name' => $username,
		],
		'permissions' => [
			'users'      => 9,
			'accounting' => 9,
			'web'        => 9,
			'documents'  => 9,
			'config'     => 9,
		],
	]
);}
