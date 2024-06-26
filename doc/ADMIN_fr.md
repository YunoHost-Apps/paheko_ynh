Vous pouvez si vous le souhaitez ajouter des configurations personnelles en éditant le fichier `__DATA_DIR__/data/config.local.user.php`.

Privilégiez le dossier `__DATA_DIR__/data` si vous voulez conserver des documents ailleurs que dans la base de données. Example dans le fichier `__DATA_DIR__/data/config.local.user.php`

```
const FILE_STORAGE_BACKEND = 'FileSystem';

const FILE_STORAGE_CONFIG = DATA_ROOT . '/files';
``` 

Si vous voulez mettre en place la configuration de la recherche d'adresse postale ([documentation](https://fossil.kd2.org/paheko/wiki?name=Configuration/Adresses_postales)), voici la procédure:
en vous connectant avec le user root:

```
cd __DATA_DIR__/data/local_addresses/
wget https://paheko.cloud/addresses/fr.sqlite
chown -R __APP__:www-data fr.sqlite
```

La base de données devrait normalement être mise à jours tous les mois, pour la mettre à jour, il vous faudra supprimer le fichier `fr.sqlite` et recommencer cette procédure.

**Important** : Pour une raison quelconque, le courriel ne fonctionne pas lors de l’installation sur une sous-instance. Nous vous encourageons à utiliser un nom de domaine complet dédié à ce domaine (avec le chemin défini sur /). Sur une première installation, vous aurez peut-être besoin d'une première mise à jour  pour mettre à jour le dossier `__DATA_DIR__/data`, vous pouvez forcer la mise à jour:
```
yunohost app __APP__ upgrade -F
```

