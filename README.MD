# SYMFONY

## NOUVEAU PROJET

- ouvrir un nouveau terminal
- se rendre dans le dossier où l'on veux créer le projet (ex : wamp64/www) :
```
cd chemin_vers_le_dossier
```
- créer le projet avec Symfony CLI (pas besoin de créer le dossier du projet) :
```
symfony new --webapp nom_du_projet --version=5.4
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
-envoyer des modifications (ou (master)) :
```
git push origin main
```
-voir la liste des commits (flèches haut et bas pour naviguer dans la liste, q pour quitter) :
```
git log
```

## APACHE-PACK

- suite d'outils pour Apache (barre de débug, routing, .htaccess)
- dans le terminal :
```
composer require symfony/apache-pack
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

- Recréer le fichier .env à la racine du projet (avc ses propres informations), les informations importantes sont APP_ENV, APP_SECRET, DATABASE_URL et MAILER_URL)

- Mettre à jour le projet (installer les dépendances, génerer le cache)
```
composer install
```

## Supprimer un package
- Concerne uniquement le pack encore)
```
composer remove [package présent dans composer.json]
composer remove symfony/webpack-encore-bundle
```

## CONTROLER
- Pour créer une nouvelle page, on utilise un controller (note, pour accéder à cette page, on rajoute le nom du dossier dans la barre d'adresse, ex : si le nom est Home, dans le lien on aura ...public/Home)
```
php bin/console make:controller nom_du_fichier
```

## BASE DE DONNÉES

- .env, créer le chemin d'accès dans ce fichier : ([BDD_utilisé]://[nom_utilisateur]:[mdp_utilisateur]@[adresse_connexion]:[port_connexion]/[nom_BDD]?serverVersion=5.7)
```
DATABASE_URL="mysql://root:@127.0.0.1:3306/symfony_dwwm20?serverVersion=5.7"
```

- Créer la BDD avec la commande doctrine
```
php bin/console doctrine:database:create
```

- Créer une entité (table) (le fichier sera créer dans le dossier : src/Entity):
```
php bin/console make:entity nom_de_l_entite
```
(note : suivre les indications selon les besoins de la BDD)
(Pour lier deux tables, utiliser le type relation : n;1 / 1;n / n;n / 1;1 )

- Exeption : créer un utilisateur :
```
php bin/console make:user
```
- Modifier l'utilisateur :
```
php bin/console make:entity User
```

(note : une valeur unique est demandé : laisser en email pour avoir un champ unique pour chaque user)

- migration (vérification + doctrine):
```
php bin/console make:migration
```
```
php bin/console doctrine:migrations:migrate
```

## FIXTURES (à part)
- installer le bundle (fixtures permet de créer des données bidons pour faire des tests)
```
composer require --dev orm-fixtures
```
- compléter le fichier srv/DataFixtures/AppFixtures.php
- persist ()
- flush()

- envoyer en base de données (en écrasant les données existantes)
```
php bin/console doctrine:fixtures:load
```

- envoyer en base de données (en ajoutant à la suite)
```
php bin/console doctrine:fixtures:load --append
```

- bundle pour générer de fausses données :
```
composer require fakerphp/faker
```
