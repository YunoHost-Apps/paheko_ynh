Vous pouvez si vous le souhaitez ajouter des configurations personnelles en éditant le fichier `__DATA_DIR__/data/config.local.user.php`.

Privilégiez le dossier `__DATA_DIR__/data` si vous voulez conserver des documents ailleurs que dans la base de données. Example dans le fichier `__DATA_DIR__/data/config.local.user.php`

```
const FILE_STORAGE_BACKEND = 'FileSystem';

const FILE_STORAGE_CONFIG = DATA_ROOT . '/files';
``` 

Si vous voulez mettre en place la configuration de la recherche d'adresse postale ([documentation](https://fossil.kd2.org/paheko/wiki?name=Configuration/Adresses_postales)), voici la procédure:
en vous connectant avec le user root:

```
mkdir "$data_dir/data/local_addresses"
chmod 770 "$data_dir/data/local_addresses"
cd __DATA_DIR__/data/local_addresses/
wget https://paheko.cloud/addresses/fr.sqlite
chown -R $app:www-data fr.sqlite
```
puis dans le fichier `__DATA_DIR__/data/config.local.user.php`, décommentez la ligne `//const LOCAL_ADDRESSES_ROOT = '__DATA_DIR__/data/local_addresses/';`.

La base de données devrait normalement être mise à jours tous les mois, pour la mettre à jour, il vous faudra supprimer le fichier `fr.sqlite` et recommencer cette procédure.

**Important** : Pour une raison quelconque, le courriel ne fonctionne pas lors de l’installation sur une sous-instance. Nous vous encourageons à utiliser un nom de domaine complet dédié à ce domaine (avec le chemin défini sur /).

