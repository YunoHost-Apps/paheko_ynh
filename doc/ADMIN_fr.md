Vous pouvez si vous le souhaitez ajouter des configurations personnelles en éditant le fichier `__DATA_DIR__/data/config.local.user.php`.

Privilégiez le dossier `__DATA-DIR__/data` si vous voulez conserver des documents ailleurs que dans la base de données. Example dans le fichier `__DATA_DIR__/data/config.local.user.php`

```
const FILE_STORAGE_BACKEND = 'FileSystem';

const FILE_STORAGE_CONFIG = DATA_ROOT . '/files';
``` 

**Important** : Pour une raison quelconque, le courriel ne fonctionne pas lors de l’installation sur une sous-instance. Nous vous encourageons à utiliser un nom de domaine complet dédié à ce domaine (avec le chemin défini sur /).


