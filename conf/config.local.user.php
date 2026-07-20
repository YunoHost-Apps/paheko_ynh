<?php

/**
 * Ce fichier est ici pour ajouter des personnalisations à votre configuration.
 *
 * Modifiez ce fichier à votre guise, il ne sera pas modifié lors des prochaines mises à jour.
 * Consultez le fichier __INSTALL_DIR__/config.local.php pour choisir des constantes à ajouter.
 * Pour une nouvelle installation, ce fichier sera pris en compte après la première mise à jour.
 */

<?php

/**
 * Ce fichier est ici pour ajouter des personnalisations à votre configuration.
 *
 * Modifiez ce fichier à votre guise, il ne sera pas modifié lors des prochaines mises à jour.
 * Consultez le fichier __INSTALL_DIR__/config.local.php pour choisir des constantes à ajouter.
 * Pour une nouvelle installation, ce fichier sera pris en compte après la première mise à jour.
 */

if (array_key_exists('REMOTE_USER', $_SERVER)) {
	$username = $_SERVER["REMOTE_USER"];
	$db = new SQLite3('/home/yunohost.app/paheko/data/association.sqlite');
	$stmt = $db->prepare('SELECT id FROM users WHERE identifiant_adhesion = :username');
	$stmt->bindValue(':username', $username, SQLITE3_TEXT);

	$result = $stmt->execute();
	$row = $result->fetchArray(SQLITE3_ASSOC);

	$user_id = $row ? $row['id'] : null;
	if ($user_id) {
		define('Paheko\LOCAL_LOGIN', $user_id);
	}
	else {
		$permission = 0;
		// ajouter les noms d'utilisateurices de yunohost qui n'ont pas de compte paheko dans l'array avec lesquels vous souhaitez administrer paheko sans créer de compte
		if (in_array($username, [""])) {
			$permission = 9;
		}
		define('Paheko\LOCAL_LOGIN', [
			'user' => [
				'_name' => $username,
			],
			'permissions' => [
				'users'      => $permission,
				'accounting' => $permission,
				'web'        => $permission,
				'documents'  => $permission,
				'config'     => $permission,
			],
		]);
	}
}
