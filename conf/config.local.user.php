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

/**
 * Hôte du serveur SMTP, mettre à false (défaut) pour utiliser la fonction
 * mail() de PHP
 *
 * Défaut : false
 */

const SMTP_HOST = '__DOMAIN__';

/**
 * Port du serveur SMTP
 *
 * 25 = port standard pour connexion non chiffrée (465 pour Gmail)
 * 587 = port standard pour connexion SSL
 *
 * Défaut : 587
 */

const SMTP_PORT = 25;

/**
 * Login utilisateur pour le server SMTP
 *
 * mettre à null pour utiliser un serveur local ou anonyme
 *
 * Défaut : null
 */

const SMTP_USER = '__APP__';

/**
 * Mot de passe pour le serveur SMTP
 *
 * mettre à null pour utiliser un serveur local ou anonyme
 *
 * Défaut : null
 */

const SMTP_PASSWORD = '__MAIL_PWD__';

/**
 * Sécurité du serveur SMTP
 *
 * NONE = pas de chiffrement
 * SSL = connexion SSL native
 * TLS = connexion TLS native (le plus sécurisé)
 * STARTTLS = utilisation de STARTTLS (moyennement sécurisé)
 *
 * Défaut : STARTTLS
 */

const SMTP_SECURITY = 'STARTTLS';

/**
 * Nom du serveur utilisé dans le HELO SMTP
 *
 * Si NULL, alors le nom renseigné comme SERVER_NAME (premier nom du virtual host Apache)
 * sera utilisé.
 *
 * Defaut : NULL
 *
 * @var null|string
 */

const SMTP_HELO_HOSTNAME = '__DOMAIN__';

/**
 * Adresse e-mail destinée à recevoir les erreurs de mail
 * (adresses invalides etc.) — Return-Path / MAIL FROM
 *
 * Si laissé NULL, alors l'adresse e-mail de l'association sera utilisée.
 * En cas d'hébergement de plusieurs associations, il est conseillé
 * d'utiliser une adresse par association.
 *
 * Voir la documentation de configuration sur des exemples de scripts
 * permettant de traiter les mails reçus à cette adresse.
 *
 * Si renseigné, cette adresse sera utilisée également comme "MAIL FROM"
 * lors de la session avec le serveur SMTP.
 *
 * Défaut : null
 */

const MAIL_RETURN_PATH = '__APP__@__DOMAIN__';


/**
 * Adresse e-mail expéditrice des messages (Sender)
 *
 * Si vous envoyez des mails pour plusieurs associations, il est souhaitable
 * de forcer l'adresse d'expéditeur des messages pour passer les règles SPF et DKIM.
 *
 * Dans ce cas l'adresse de l'association sera indiquée en "Reply-To", et
 * l'adresse contenue dans MAIL_SENDER sera dans le From.
 *
 * Si laissé NULL, c'est l'adresse de l'association indiquée dans la configuration
 * qui sera utilisée.
 *
 * Défaut : null
 */

const MAIL_SENDER = '__APP__@__DOMAIN__';

/**
 * Chemin vers le répertoire contenant les bases de données d'adresses
 * locales.
 *
 * Cela permet d'auto-compléter l'adresse d'un membre quand on crée
 * ou modifie sa fiche membre, sans faire appel à un service externe.
 *
 * Dans ce répertoire, chaque pays correspond à une BDD SQLite contenant
 * la liste de toutes les adresses du pays.
 *
 * Par exemple 'fr.sqlite' pour la France.
 *
 * Défaut : null
 *
 * @var null|string
 */

//const LOCAL_ADDRESSES_ROOT = '__DATA_DIR__/data/local_addresses/';