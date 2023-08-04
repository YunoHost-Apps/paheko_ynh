<?php

/**
 * NE PAS MODIFIER CE FICHIER!
 *
 * Ce fichier sera mis à jour à chaque nouvelle version de Yunohost
 *
 * Pour ajouter vos configurations personnalisées, rendez-vous dans le fichier config.local.user.php
 *
 */

// Nécessaire pour situer les constantes dans le bon namespace
namespace Paheko;

/**
 * Clé secrète, doit être unique à chaque instance de Garradin
 *
 * Ceci est utilisé afin de sécuriser l'envoi de formulaires
 * (protection anti-CSRF).
 *
 * Cette valeur peut être modifiée sans autre impact que la déconnexion des utilisateurs
 * actuellement connectés.
 *
 * Si cette constante n'est définie, Garradin ajoutera automatiquement
 * une valeur aléatoire dans le fichier config.local.php.
 */

const SECRET_KEY = '__SECRET_KEY__';

/**
 * Répertoire où se situe le code source de Paheko
 *
 * Défaut : répertoire racine de Paheko (__DIR__)
 */

const ROOT = '__INSTALL_DIR__';

/**
 * Répertoire où sont situées les données de Paheko
 * (incluant la base de données SQLite, les sauvegardes, le cache, les fichiers locaux et les plugins)
 *
 * Défaut : sous-répertoire "data" de la racine
 */

//const DATA_ROOT = ROOT . '/data';

/**
 * Répertoire où est situé le cache,
 * exemples : graphiques de statistiques, templates Brindille, etc.
 *
 * Défaut : sous-répertoire 'cache' de DATA_ROOT
 */

//const CACHE_ROOT = DATA_ROOT . '/cache';

/**
 * Répertoire où est situé le cache partagé entre instances
 * Paheko utilisera ce répertoire pour stocker le cache susceptible d'être partagé entre instances, comme
 * le code PHP généré à partir des templates Smartyer.
 *
 * Défaut : sous-répertoire 'shared' de CACHE_ROOT
 */

//const SHARED_CACHE_ROOT = CACHE_ROOT . '/shared';

/**
 * Motif qui détermine l'emplacement des fichiers de cache du site web.
 *
 * Le site web peut créer des fichiers de cache pour les pages et catégories.
 * Ensuite le serveur web (Apache) servira ces fichiers directement, sans faire
 * appel au PHP, permettant de supporter beaucoup de trafic si le site web
 * a une vague de popularité.
 *
 * Certaines valeurs sont remplacées :
 * %host% = hash MD5 du hostname (utile en cas d'hébergement de plusieurs instances)
 * %host.2% = 2 premiers caractères du hash MD5 du hostname
 *
 * Utiliser NULL pour désactiver le cache.
 *
 * Défault : CACHE_ROOT . '/web/%host%'
 *
 * @var null|string
 */

//const WEB_CACHE_ROOT = CACHE_ROOT . '/web/%host%';

/**
 * Emplacement du fichier de base de données de Paheko
 *
 * Défaut : DATA_ROOT . '/association.sqlite'
 */

//const DB_FILE = DATA_ROOT . '/association.sqlite';

/**
 * Emplacement de stockage des plugins
 *
 * Défaut : DATA_ROOT . '/plugins'
 */

//const PLUGINS_ROOT = DATA_ROOT . '/plugins';

/**
 * Adresse URI de la racine du site Paheko
 * (doit se terminer par un slash)
 *
 * Défaut : découverte automatique à partir de SCRIPT_NAME
 */
const WWW_URI = '__PATH__/';

/**
 * Activer la possibilité de faire une mise à jour semi-automatisée
 * depuis fossil.kd2.org.
 *
 * Si mis à TRUE, alors un bouton sera accessible depuis le menu "Configuration"
 * pour faire une mise à jour en deux clics.
 *
 * Il est conseillé de désactiver cette fonctionnalité si vous ne voulez pas
 * permettre à un utilisateur de casser l'installation !
 *
 * Défaut : true, ajout pour l'environement Yunohost défaut : false
 *
 * @var bool
 */

const ENABLE_UPGRADES = false;

/**
 * Since 1.2.4, I downgraded the default SQLite journal mode to TRUNCATE instead of WAL because 
 * it might have been a cause of corruption on some hosting providers using NFS.
 *
 * I don't think that Yunohost can use NFS, so you should set it back to WAL 
 * by adding the following line to config.local.php when installing:
*/

const SQLITE_JOURNAL_MODE = 'WAL';

