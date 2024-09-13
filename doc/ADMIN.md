## Custom configurations*

If needed, in the Custom SMTP Panel you can edit the SMTP user with a third party hosted SMTP server that will send emails on behalf of your own SMTP server.  
If you want, you can add custom configurations by editing the file `__DATA_DIR__/data/config.local.user.php`.

## About file storage

Use the `__DATA_DIR__/data` folder if you want to store documents elsewhere than in the database (recommanded).  
Example in file `__DATA_DIR__/data/config.local.user.php`:

```php
const FILE_STORAGE_BACKEND = 'FileSystem';

const FILE_STORAGE_CONFIG = DATA_ROOT . /files';
```

## Postal address search configuration

If you want to set up the postal address search configuration ([documentation](https://fossil.kd2.org/paheko/wiki?name=Configuration/Adresses_postales)), here's how:
Logged as root:

```bash
cd __DATA_DIR__/data/local_addresses/
wget https://paheko.cloud/addresses/fr.sqlite
chown -R __APP__:www-data en.sqlite
```

The database should normally be updated every month. To update it, you'll need to delete the `fr.sqlite` file and repeat this procedure.

## Enable PDF generation

To allow Paheko to generate PDF documents, you need to install the “DomPDF” extension.  
To do this, go to your Paheko, then Configuration, Extensions, Inactives, DomPDF and click on “Activate”.  
Or click [on this link](https://__DOMAIN____PATH__admin/config/ext/details.php?type=plugin&name=dompdf) to access it directly then click on “Activate”.
