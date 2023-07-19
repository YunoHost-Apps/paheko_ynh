### Migrate from Garradin

This package handle the migration from Garradin to Paheko. For that, you will have to upgrade your Garradin application with this repository. This can only be done from the command-line interface - e.g. through SSH. Once you're connected, you simply have to execute the following:

```bash
sudo yunohost app upgrade garradin -u https://github.com/YunoHost-Apps/paheko_ynh/tree/garradin-migration --debug
```

The --debug option will let you see the full output. If you encounter any issue, please report it aand paste the logs.

**Important**: After the migration, you'll have to wait a couple of minutes (at most 3 minutes) before you can start using Paheko.

Once the migration is done, you should then upgrade to new release of Paheko.


