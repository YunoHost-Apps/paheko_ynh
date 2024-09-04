If you wish, you can add custom configurations inside `__DATA_DIR__/data/config.local.user.php`.

Use the `__DATA_DIR__/data` folder if you want to store documents elsewhere than in the database. Example in `__DATA_DIR__/data/config.local.user.php` file

```
const FILE_STORAGE_BACKEND = 'FileSystem';

const FILE_STORAGE_CONFIG = DATA_ROOT . /files';
``` 

**Important**: for some reason, email does not work when installing on a subpath. You are encouraged to use a full, dedicated for this domain (with path set to /).


