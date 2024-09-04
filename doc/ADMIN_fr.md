## Configurations personnelles

Si nécessaire, dans le panneau SMTP personnalisé, vous pouvez modifier l'utilisateur SMTP avec un service tiers SMTP qui enverra des courriels au nom de votre propre serveur SMTP.
Vous pouvez, si vous le souhaitez ajouter des configurations personnelles en éditant le fichier `__DATA_DIR__/data/config.local.user.php`.

## Sur le stockage des fichiers

Privilégiez le dossier `__DATA_DIR__/data` si vous voulez conserver des documents ailleurs que dans la base de données.  
Example dans le fichier `__DATA_DIR__/data/config.local.user.php` :

```php
const FILE_STORAGE_BACKEND = 'FileSystem';

const FILE_STORAGE_CONFIG = DATA_ROOT . '/files';
```

## Configuration de la recherche d'adresse postale

Si vous voulez mettre en place la configuration de la recherche d'adresse postale ([documentation](https://fossil.kd2.org/paheko/wiki?name=Configuration/Adresses_postales)), voici la procédure :
en vous connectant avec le user root :

```bash
cd __DATA_DIR__/data/local_addresses/
wget https://paheko.cloud/addresses/fr.sqlite
chown -R __APP__:www-data fr.sqlite
```

La base de données devrait normalement être mise à jour tous les mois, pour la mettre à jour, il vous faudra supprimer le fichier `fr.sqlite` et recommencer cette procédure.

## Activation de la génération des PDF

Afin que Paheko puisse générer des documents PDF, il est nécessaire d'installer l'extension "DomPDF".  
Pour cela, rendez-vous dans Paheko, puis Configuration, Extensions, Inactives, DomPDF et cliquez sur "Activer".  
Ou cliquez [sur ce lien](https://__DOMAIN____PATH__admin/config/ext/details.php?type=plugin&name=dompdf) pour y accéder directement et cliquez sur "Activer".


