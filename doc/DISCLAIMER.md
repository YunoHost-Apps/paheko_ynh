### Migrate from Garradin

This package handle the migration from Garradin to Paheko. For that, you will have to upgrade your Garradin application with this repository. This can only be done from the command-line interface - e.g. through SSH. Once you're connected, you simply have to execute the following:

```bash
sudo yunohost app upgrade garradin -u https://github.com/YunoHost-Apps/paheko_ynh --debug
```

The --debug option will let you see the full output. If you encounter any issue, please report it aand paste the logs.
