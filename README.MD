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

- Générer un CRUD (ex : comment)
```
php bin/console make:crud nom_de_l_entité
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

## ROUTER

- voir toutes les routes :
```
php bin/console debug:router
```
- mise en forme de la route (vérifie que la route existe dans le Controller)
```
php bin/console route:match /url_de_la_route
```

## FORMULAIRE

- créer le formulaire :
```
php bin/console make:form nom_du_formulaire
```
- mise en forme des formulaires avec un thème (config/packages/twig.yaml) :
```
twig:
    form_themes: ['bootstrap_5_layout.html.twig']
```

## REGISTER (gestion de l'admin)

- créer l'entité User (nom + préciser la valeur unique) :
```
php bin/console make:user
```
- ajouter des champs à l'entité User  :
```
php bin/console make:entity user
```
- migration (habituelle)
- créer le formulaire d'inscription
```
php bin/console make:registration-form
```
- Installer le package manquant
```
composer require symfonycasts/verify-email-bundle
```
- modifier la dernière redirection après la vérification de l'adresse mail (RegistrationController::verifyUserEmail())
- gérer l'affichage des messages flash (register.html.twig, ...)
- personnaliser le formulaire, le controller et les templates
- migration pour gérer la propriété User::isVerified

- Installer Rollerworks (pour vérifier la sécurité du mdp)
```
composer require rollerworks/password-strength-bundle
```
-dans le formulaire
```
use Rollerworks\...\PasswordStrength;
....
new PasswordStrength
```
- y ajouter les contraintes souhaitées

## EMAIL

- installer le mailer :
```
composer require symfony/mailer
```
- installer le package tiers (uniquement les mails google, voir doc → mailer, 3rd party transport):
```
composer require symfony/
```
- dans les paramètres du compte Google => Sécurité => Connexion à Google : activer la validation en deux étapes
- créer un nouveau mot de passe d'application (autre, sublimmo)
- .env : MAILER_DSN=gmail://USERNAME:PASSWORD@default

- voir les mails dans la toolbar (config/packages/dev/web__profiler.yaml) :
```YAML
web_profiler:
    intercept_redirects: true # intercepte les redirections
```
- config/packages/mailer.yaml
```YAML
dsn: 'null://null' #  désactive l'envoie de mail
envelope:
    recipients: ['dacostasteven91@gmail.com'] # envoie tous les mails à cette adresse
```
## LOGIN
- installer le package :
```
php bin/console make:auth
```
- 1
- LoginFormAuthentificator
- SecurityController
- yes

- Modifier la route d'envoie après la connexion de l'utilisateur (src → security → LoginForm...)
```
return new RedirectResponse($this->urlGenerator->generate('admin'));
```
- pour se deconnecter
```
<a href="{{path('app_logout')}}"></a>
```

## PAIEMENT STRIPE

- créer un controller (et la vue associée)
- ajouter le script à la page de paiement (front) :
```HTML
<script src="https://js.stripe.com/v3/"></script>
```
- installer le bundle (back) :
```
composer require stripe/stripe-php
```
- ajouter le lien sur la page panier
-


## SÉCURITÉ - DROITS - ACCÈS - HIERARCHIE

- dans config/packages/security.yaml, décommenter :
```
access_control:
      - { path: ^/admin, roles: ROLE_ADMIN }
```
- Si on veux modifier les accès aux pages selon un rôle :
```
- { path: ^/nom_de_la_page, roles: ROLE_NOM }
```
- Si on veux restructurer les valeurs des roles :
```
role_hierarchy :
  ROLE_NOM_1: ROLE_NOM_2
ex : ROLE_ADMIN: ROLE_USER => Admin = Admin + User
```
- afficher du code selon un rôle
```
{% if is_granted('LE_ROLE') %}
  [le code ici]
{% endif %}
```
- enfin
```
composer update
```

## COMMANDES IMPORTANTES

- vider le cache :
```
php bin/console cache:clear
```
- faire partiellement fonctionner l'envoie du mail de confirmation par symfony
```
php bin/console menssenger:consume async
```
## Changement de Symfony 6.0->5.4
- composer.json
```
1. [tout les fichier qui on un attribut 6.0] → 5.4
2. Supprimer "symfony/doctrine-messenger": "5.4.*", (pour éviter qu'il le réinstalle)
```
- Supprimer les dossiers : var et vendor
- .env :
 ```
Supprimer symfony/webapp-meta et symfony/messenger
 ```
- enfin : composer update → erreur normale
- Ajouter dans User.php
```
    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }
```
