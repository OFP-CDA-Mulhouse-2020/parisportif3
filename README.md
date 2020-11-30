![PHPUnit](https://github.com/OFP-CDA-Mulhouse-2020/parisportif3/workflows/PHPUnit/badge.svg?branch=develop)

# parisportif3

 Cahier des charges : https://github.com/OFP-CDA-Mulhouse-2020/specs

## Architecture des dossiers (peu évoluer)

- assets
    - img
    - js
    - css
    - scss
    - divers
    
- src
    - Model
    - View
    - Controller
    - Entity
    
- tests
- Wirefrime
- UML

## Méthode de travail

    - Respecter les normes PSR-4 et PSR-12
    - Tests unitaires : PHPUnit
    - Tests fonctionnels : Codeception
   
## Utilisation de git

### Ressource : 

   - https://www.grafikart.fr/tutoriels/git-flow-742 (video)
   - https://danielkummer.github.io/git-flow-cheatsheet/

### Marche à suivre : (nécessite un git status clean)

```html
    - git flow init 
        (On appuie sur entrée sans rien modifier, sur chaque demande)
    
    - git flow feature start <nomDeFeature>
        (Lorsqu'on commence à développer)
        
    - git flow feature finish <nomDeFeature>
        (Une fois le développement de la feature fini
        Ce qui vas merge la feature dans la branche dev)
        
    - git flow feature publish <nomDeFeature>
        (Si la feature à besoin d'être utiliser avant son merge
        ceci va push la branche feature sur le remote)
    
    - git flow feature pull origin <nomDeFeature>
        (vas récupérer la feature du remote, en créant la branche
        local correspondante)
        
    -- Dans le cadre d'une correction légère --
    
    - git flow hotfix start <version> <nomHotFix>
        ( créer une nouvelle branch pour une correction
        rapide)

    - git flow hotfix finish <version>
        (ferme le hotfix et le merge avec dev et le master
        correspondant à la version)
``` 
    

## Etape 1 - Conception et modélisation

Du 03/11/2020 au 12/11/2020

### Outils de conception :

    - Adobe XD
    - Plant UML

### Répartition du travail :
    
    - Wireframe : Jannick Parmentier
    - Diagramme de classe : Julien Calise / Etienne Schmitt


## UML 

![Image of UML representation](https://i.postimg.cc/33fN5LQb/Diagram-UML.png)


## Étape 2 - Création de l'entité User et tests

### Initialisation du projet

Outils :

    Projet sous Symfony
    Composer
    PHPUnit
    PHPCS
    PHPStan
    PHPUnit-Watcher
    
Dockerisation :

    Traefik
    php7.4-apache avec XDebug
    mysql
    composer
    phpmyadmin
    mailhog
    
## Étape 3 - Ajout du login / signup

Détails :

    - Utilisation des composants :
        - Form
        - Validator
        
    - Méthodologie TDD :
        - Test
        - Echec
        - Code
        - Repeat