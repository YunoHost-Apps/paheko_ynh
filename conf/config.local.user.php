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

// LDAP
const LDAP_HOST = 'ldap://localhost:389';
const LDAP_DN = 'cn=%s,ou=users,dc=yunohost,dc=org';

session_start();

if (empty($_SESSION['ldap_user']) && !empty($_POST['ldap_login']) && !empty($_POST['ldap_password'])) {
	$l = ldap_connect(LDAP_HOST) or die('Connexion impossible');
	ldap_set_option($l, LDAP_OPT_PROTOCOL_VERSION, 3);
	ldap_set_option($l, LDAP_OPT_REFERRALS, 0);
	ldap_set_option($l, LDAP_OPT_NETWORK_TIMEOUT, 10);

	$login = trim($_POST['ldap_login']);

	if (ldap_bind($l, sprintf(LDAP_DN, $login), $_POST['ldap_password'])) {
		$_SESSION['ldap_user'] = $login;
	}

	ldap_close($l);
}

if (empty($_SESSION['ldap_user'])) {
	echo '<!DOCTYPE html>
	<html>
	<body>
	<form method="post" action="">';

	if (!empty($_POST['ldap_login'])) {
		echo '<p style="color: red">Identifiants invalides</p>';
	}

	echo '
		<fieldset>
			<legend>Connexion</legend>
			<dl>
				<dt>Login</dt>
				<dd><input type="text" name="ldap_login" required /></dd>
				<dt>Mot de passe</dt>
				<dd><input type="password" name="ldap_password" required /></dd>
			</dl>
			<p><input type="submit" value="Connexion" /></p>
		</fieldset>
	</form>
	</body>
	</html>';
	exit;
}

define('Paheko\LOCAL_LOGIN', [
	'user' => [
		'_name' => $_SESSION['ldap_user'],
	],
	'permissions' => [
		'users'      => 9,
		'accounting' => 9,
		'web'        => 9,
		'documents'  => 9,
		'config'     => 9,
	],
]);
