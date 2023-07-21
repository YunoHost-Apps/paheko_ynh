### Migrer depuis Garradin

Ce paquet supporte la migration de Garradin vers Paheko. Pour ce faire, vous allez devoir mettre à jour l'application Garradin à l'aide de ce dépôt. Cette opération ne peut se faire seulement depuis une interface en ligne de commande, autrement dit en SSH. Une fois connecté/e, vous devez simplement lancer la commande suivante :

```bash
sudo yunohost app upgrade garradin -u https://github.com/YunoHost-Apps/paheko_ynh/tree/garradin-migration --debug
```

L'option debug vous permet de voir l'entièreté du journal d'installation. Si vous rencontrez des difficultés, merci de créer un ticket en collant le journal d'erreur.

**Important** : Après la migration, veuillez attendre quelques instants (maximum 3 minutes) avant de commencer à utiliser Paheko.

Une fois la migration terminée, vous pourrez mettre à jour avec la dernière version stable de Paheko.

### Configurations personnelles

Vous pouvez si vous le souhaitez ajouter des configurations personnelles en éditant le fichier `/var/www/paheko/config.local.user.php`, pour voir les possibilités vous pouvez lire auparavant le fichier `/var/www/paheko/config.dist.php`.
