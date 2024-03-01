# symfony-denisBucspun-A3
 ## Voici un README s'adressant aux développeurs :
 

### 1. Sécurisation d'ArticleController :
  - **Vérifications des Rôles** : Assurez-vous que les actions telles que la création, la modification et la suppression d'articles sont protégées par des vérifications de rôle. Autorisez uniquement les utilisateurs authentifiés avec des rôles spécifiques (par exemple,         
  ROLE_ADMIN) à effectuer ces actions.
  
  - **Validation des Formulaires** : Validez toujours les entrées des formulaires pour prévenir les injections SQL et autres attaques. Utilisez les fonctionnalités de validation des formulaires de Symfony.
  
  - **Protection CSRF** : Assurez-vous que tous les formulaires incluent des jetons CSRF pour prévenir les attaques de Cross-Site Request Forgery.

### 2. Sécuriser les Templates Twig :
- **Échappement des Sorties** : Assurez-vous que toutes les sorties sont correctement échappées pour prévenir les attaques XSS. Twig échappe automatiquement les sorties, mais soyez prudent avec des filtres comme raw.

- **Formulaires Sécurisés** : Utilisez des formulaires Twig avec des jetons CSRF pour vous protéger contre les attaques CSRF.

- **Entrées Utilisateur** : Ne faites jamais confiance aux entrées des utilisateurs affichées dans les templates. Validez et nettoyez toujours.

### 3. Mesures de Sécurité Générales :

- **HTTPS** : Forcez l'utilisation de HTTPS pour sécuriser les données en transit.

- **Contrôle d'Accès** : Définissez et appliquez des contrôles d'accès stricts basés sur les rôles des utilisateurs.

- **Sécurité de la Base de Données** : Utilisez des requêtes paramétrées ou DBAL de Doctrine pour éviter l'injection SQL.

- **Hashage des mots de passe** : N'oubliez pas de faire en sorte que les mots de passe soit hashé !

### Bonus 
- N'oubliez pas de **Composer install**
- **php bin/console doctrine:fixtures:load** pour les ajouter les fixtures ainsi que le compte admin qui va avec !

