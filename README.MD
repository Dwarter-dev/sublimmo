# SYMFONY

## NOUVEAU PROJET

- ouvrir un nouveau terminal
- se rendre dans le dossier où l'on veux créer le projet (ex : wamp64/www) :
```
cd chemin_vers_le_dossier
```
- créer le projet avec Symfony CLI (pas besoin de créer le dossier du projet) :
```
symfony new --webapp nom_du_projet --version-5.4
```
-créer le projet avec Composer (pas besoin de créer le dossier du projet)
```
composer create-projet symfony/website-skeleton nom_du_projet ^5.4
```

## GIT

- Créer un dépôt Git sur Github
- Avec un terminal, se rendre dans le dossier du projet (cd chemin_du_dossier ou VSC ou Atom)
- initialiser un dépôt local :

```
git init
```
-lier le dépôt local au dépot distant :
```
git remote add origin https://github.com/nom_d_utilisateur/nom_du_dépot_distant.git
```
-ajoutter tous les fichiers :
```
git add *
```
-donner un nom au commit :
```
git commit -m "message_du_commit"
```
-récupérer les dernières modifications :
```
git pull origin main
```
-envoyer des modifications :
```
git push origin main ou (master)
```
-voir la liste des commits (flèches haut et bas pour naviguer dans la liste, q pour quitter) :
```
git log
```

## SYMFONY SERVER

- Démarrer le serveur (moins pratique qu'en arrière-plan): (Ctrl + C pour quitter)
```
symfony server:start
```

- Démarrer le serveur en arrière plan (règlera certains soucis comparer au démarrage normal)
```
symfony server:start -d
```

- Arrêter le service :
```
symfony server:stop
```


## RÉCUPÉRER UN FICHIER

- Télecharger le zip ou faire un pull sur un nouveau dossier
```
git init
```
```
git remote add origin https://github.com/nom_d_utilisateur/nom_du_dépot_distant.git
```

- Recréer le fichier .env à la racine du projet (avc ses propres informations), les informations importantes sont APP_ENV, APP_SECRET, et DATABASE_URL(éventuellement : MAILER_URL)

- Mettre à jour le projet (installer les dépendances, génerer le cache)
```
composer install
```

## Supprimer un package

```
composer remove [package présent dans composer.json]
```

## CONTROLER
- Pour créer une nouvelle page, on utilise un controller (note, pour accéder à cette page, on rajoute le nom du dossier dans la barre d'adresse, ex : si le nom est Home, dans le lien on aura ...public/Home)
```
php bin/console make:controller nom_du_fichier
```
