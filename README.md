# ProjetSiteWebCOACHME
Ceci est mon projet licence informatique ,j'ai été responsable de la partie backend de tout le site .

on a crée avec mon groupe un site de prise de rendez vous avec un coach sportif (avec une partie boutique en ligne),le but du site est de permettre au client de trouver et de prendre des RDV avec des coachs dont il en aura besoin , et aussi permettre au coachs de gerez leurs emplois du temps et suivre les clients depuis le site.

Les fonctionnalités des differantes interfaces :

_Visiteur : Consulter l'acceuil, les produits de la boutique,s'inscrire ,se connecter , et contacter le site via formulaire .

_Client (Apres connexion): modifier son profil , prendre RDV , annuler RDV , version PDF du RDV et les autres fonctionnalités visiteur.

_Coach : consulter/modifier son profil , ajouter/modifier/supprimer des RDV , mettre un commentaire aux clients

_Admin :Ajoutez/modifier/supprimer (les comptes clients , coachs , RDV ), accés au tableau de bord (dashboard).

Le dossier "images du sites" illustre en grande partie le site et ses fonctionnalités.

Pour tester le site (WAMP) il suffit de mettre le contenu de ce dossier dans le dossier "www" de Wamp , et d'importer le fichier "coach_appointment.sql" dans PhpMyAdmin pour creer la base de données du site.

PS: Pour acceder a la partie Admin ou Coach il vous suffit de clicker sur le boutton Admin/Coach dans le footer du site.

Compte admin : ummto@gmail.com / password , pour changer ou ajouter un admin vous pouvez changer dans la base de données ou dans le fichier "coach_appointment.sql" avant de l'executer , il suffit de changer la partie VALUES de INSERT INTO `admin_table`

Exemple compte Coach : himeuramayas@gmail.com / password

Exemple compte client : jacobmartin@gmail.com / password
