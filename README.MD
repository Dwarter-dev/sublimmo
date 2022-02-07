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
```s
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
