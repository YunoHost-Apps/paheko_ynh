<!--
Ohart ongi: README hau automatikoki sortu da <https://github.com/YunoHost/apps/tree/master/tools/readme_generator>ri esker
EZ editatu eskuz.
-->

# Paheko YunoHost-erako

[![Integrazio maila](https://apps.yunohost.org/badge/integration/paheko)](https://ci-apps.yunohost.org/ci/apps/paheko/)
![Funtzionamendu egoera](https://apps.yunohost.org/badge/state/paheko)
![Mantentze egoera](https://apps.yunohost.org/badge/maintained/paheko)

[![Instalatu Paheko YunoHost-ekin](https://install-app.yunohost.org/install-with-yunohost.svg)](https://install-app.yunohost.org/?app=paheko)

*[Irakurri README hau beste hizkuntzatan.](./ALL_README.md)*

> *Pakete honek Paheko YunoHost zerbitzari batean azkar eta zailtasunik gabe instalatzea ahalbidetzen dizu.*  
> *YunoHost ez baduzu, kontsultatu [gida](https://yunohost.org/install) nola instalatu ikasteko.*

## Aurreikuspena

Paheko (a word from the Māori language meaning "to cooperate", illustrating the purpose of the software: to improve together the daily management of an association) is software for associative management.  
It is the tool of choice for managing an association, a sports club, an NGO, etc.  
It is designed to meet the needs of a small to medium-sized structure: management of members, accounting, website, note-taking in meetings, archiving and sharing of the association's operating documents, discussion between members.

⚠️ Paheko is a French only software for now, even if an English translation is planned.


**Paketatutako bertsioa:** 1.3.12~ynh4

**Demoa:** <https://paheko.cloud/essai/>

## Pantaila-argazkiak

![Paheko(r)en pantaila-argazkia](./doc/screenshots/screenshot.png)

## Dokumentazioa eta baliabideak

- Aplikazioaren webgune ofiziala: <https://paheko.cloud>
- Erabiltzaileen dokumentazio ofiziala: <https://paheko.cloud/aide>
- Administratzaileen dokumentazio ofiziala: <https://fossil.kd2.org/paheko/wiki?name=Documentation>
- Jatorrizko aplikazioaren kode-gordailua: <https://fossil.kd2.org/paheko/dir?ci=tip>
- YunoHost Denda: <https://apps.yunohost.org/app/paheko>
- Eman errore baten berri: <https://github.com/YunoHost-Apps/paheko_ynh/issues>

## Garatzaileentzako informazioa

Bidali `pull request`a [`testing` abarrera](https://github.com/YunoHost-Apps/paheko_ynh/tree/testing).

`testing` abarra probatzeko, ondorengoa egin:

```bash
sudo yunohost app install https://github.com/YunoHost-Apps/paheko_ynh/tree/testing --debug
edo
sudo yunohost app upgrade paheko -u https://github.com/YunoHost-Apps/paheko_ynh/tree/testing --debug
```

**Informazio gehiago aplikazioaren paketatzeari buruz:** <https://yunohost.org/packaging_apps>
