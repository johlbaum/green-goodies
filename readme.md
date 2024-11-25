# OCR Développeur d'application PHP Symfony - Projet n° 13 : Mettez en place un site de e-commerce avec Symfony

## Mission :

GreenGoodies, une boutique lyonnaise spécialisée dans la vente de produits biologiques, éthiques et écologiques, souhaite élargir sa cible commerciale.<br>

Le développement du site comprend deux aspects distincts :<br>

- **La partie front-end** : Cet aspect du site permet aux clients de visualiser les produits, de s’authentifier et de passer des commandes.

- **La partie back-end** : Création d’une API composée de deux routes principales :
  - Une route pour se connecter à l’API.
  - Une route pour récupérer la liste des produits.

Un bouton a été ajouté pour permettre à l'utilisateur d’activer son accès API depuis la gestion de son compte utilisateur.

---

## Spécifications techniques - API GreenGoodies :

### Routes :

- **POST /api/login** : permet à l'utilisateur de s’authentifier et d’obtenir un token JWT.
- **GET /api/products** : permet à l'utilisateur de récupérer la liste de tous les produits.

### Réponses :

- **Identifiants corrects** : Statut **200**
- **Identifiants incorrects** : Statut **401**
- **Accès API non activé** : Statut **403**

---

## Données de test :

### Utilisateurs :

- **E-mail** : `user.one@greengoodies.com`  
  **Mot de passe** : `password`

- **E-mail** : `user.two@greengoodies.com`  
  **Mot de passe** : `password`

- **E-mail** : `user.three@greengoodies.com`  
  **Mot de passe** : `password`

### Produits :

9 produits sont créés.

Chaque produit comprend :

- Un nom
- Une description courte
- Une description longue
- Un prix
- Une image

## Prérequis

- Un serveur local (MAMP, WAMP, LAMP, etc.)
- PHP
- MySQL
- Composer
- Symfony CLI

## Instructions d'installation

## 1. Cloner le projet

Clonez le dépôt du projet avec la commande suivante :

git clone <URL_DU_DEPOT>
cd <NOM_DU_DOSSIER>

## 2. Installer les dépendances

Installez les dépendances du projet en utilisant Composer avec la commande suivante :

```bash
composer install
```

## 3. Configurer l’environnement

Créez un fichier `.env.local` à la racine du projet avec les configurations suivantes :

```bash
DATABASE_URL="mysql://<utilisateur>:<mot_de_passe>@127.0.0.1:3306/greengoodies?charset=utf8"
```

Remplacez "utilisateur" et "mot_de_passe" par vos informations d'accès MySQL.

## 4. Générer des clés pour l'authentification

Créez un dossier config/jwt :

```bash
mkdir -p config/jwt
```

Générez les clés publiques et privées nécessaires pour JWT :

```bash
openssl genpkey -out config/jwt/private.pem -algorithm rsa -pkeyopt rsa_keygen_bits:4096
```

```bash
openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout
```

Dans le fichier .env.local, ajoutez les lignes suivantes :

```bash
JWT_SECRET_KEY=%kernel.project_dir%/config/jwt/private.pem
JWT_PUBLIC_KEY=%kernel.project_dir%/config/jwt/public.pem
JWT_PASSPHRASE=<votre_mot_de_passe_jwt>
```

## 5. Créer la base de données

Créez la base de données avec la commande suivante :

```bash
symfony console doctrine:database:create --if-not-exists
```

## 6. Créer la structure de la base de données

Appliquez les migrations pour créer la structure de la base de données :

```bash
symfony console doctrine:migrations:migrate
```

## 7. Générer les données de test

Chargez les données de test avec la commande suivante :

```bash
symfony console doctrine:fixtures:load
```
