### Migrer depuis Garradin

Ce paquet supporte la migration de Garradin vers Paheko. Pour ce faire, vous allez devoir mettre à jour l'application Garradin à l'aide de ce dépôt. Cette opération ne peut se faire seulement depuis une interface en ligne de commande, autrement dit en SSH. Une fois connecté/e, vous devez simplement lancer la commande suivante :

```bash
sudo yunohost app upgrade garradin -u https://github.com/YunoHost-Apps/paheko_ynh --debug
```

L'option debug vous permet de voir l'entièreté du journal d'installation. Si vous rencontrez des difficultés, merci de créer un ticket en collant le journal d'erreur.
