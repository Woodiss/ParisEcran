# Rapport sur l'avancement du projet

Ici est répertoriée toutes les demandes concernant le projet et leur avancement ainsi que leur emplacement dans le projet.

✔️ = Terminer  
❌ = Pas commencé  
🚧 =  En cours  

## Cas d'utilisation

1. **Création :**
    1. Créer un utilisateur (s'inscrire) : ✔️ ***Page :*** inscription.php
    2. Associer un acteur à un film : ✔️ ***Page :*** update-casting.php?id_film=4
    3. Créer un film : ✔️ ***Page :*** create-film.php
    4. Effectuer une réservation pour un film donné : ✔️ ***Page :*** infos-film.php

2. **Mise à jour :**
    1. Modifier le mot de passe d'un utilisateur: ✔️ ***Page :*** update-subscriber.php?id_sub=2
    2. Ajouter une place à une réservation si le paiement n'a pas encore été effectué et modifier le montant à payer : ✔️ ***Page :*** reservation.php
    3. Pour tous les films ayant lieu un jour donné, augmenter le prix de 10% (les réservations déjà payées ne sont pas concernées) : ✔️ ***Page :*** inflation.php

3. **Consultation :**
    1. Afficher la liste des lieux de film : ✔️ ***Page :*** infos-film.php?id_film=4
    2. Afficher les films par arrondissement : ✔️ ***Page :*** index-cinema.php
    3. Afficher les salles par arrondissement (borough) : ✔️ ***Page :*** room-borough.php
    4. Afficher les films en cours pour une catégorie donnée : ✔️ ***Page :*** index-film.php
    5. Afficher le nombre de films par catégorie : ✔️ ***Page :*** index-film.php
    6. Afficher les nombre moyen de places réservées (au total) par les personnes inscrites : ✔️ ***Page :*** all-sub.php
    7. Afficher la distribution statistique des réservations de places (c'est-à-dire le nombre de personnes ayant réservé au total un certain nombre de places) : ✔️ ***Page :*** static-reservation.php
    8. Afficher le taux de remplissage des salles par film, trié par ordre décroissant : ✔️ ***Page :*** average-fill-room.php
    9. Faire la liste des artistes qui ont participé avec un artiste donné à au moins deux films différents : ✔️ ***Page :*** actor.html.php
    10. Afficher la liste de tous les réalisateurs qui sont diffusés dans un cinéma donné : ✔️ ***Page :*** index-cinema.php
    11. Afficher les trois genres de films pour lesquels le plus de places ont été réservées : ✔️ ***Page :*** best-genre.php 
    12. Recommandation : proposer à une personne X des films qu'elle pourrait aimer, proposition basée sur les films vus par les gens qui ont vu des films en commun avec X : ✔️ ***Page :*** profil.php (bas de page)
    13. Afficher la liste des cinémas, triée par la note moyenne obtenue par les films qui s'y sont joués : ✔️ ***Page :*** index-cinema.php?order_by=notation
    14. Existe-t-il des artistes ayant tenu au moins trois fonctions différentes (dans différents films) ? : ✔️ ***Page :*** actor.html.php
    15. Afficher la liste des recettes par film et par ordre décroissant : ✔️ ***Page :*** films-revenue.php
    16. Y a-t-il des films qui ont affiché complet parmi ceux qui ne se jouent plus ? : ✔️ ***Page :*** average-fill-room.php
    17. Quels sont les artistes préférés des spectateurs, c'est-à-dire ceux ayant participé aux films les mieux notés en moyenne ? : ✔️ ***Page :*** actor.html.php

4. **Suppression :**
    1. Supprimer une réservation connaissant le spectateur et le film : ✔️ ***Page :*** reservation-sub-list.php?id_sub=5
    2. Annuler un film : ✔️ ***Page :*** all-film.php

5. **Bonus**
    2. DELETE : Supprimer un compte utilisateur (subscriber). Quels problèmes cela pose-t-il ? ✔️ ***Page :*** all-sub.php
    3. UPDATE : Ajouter une réaction au commentaire d'un utilisateur. ✔️ ***Page :*** infos-film.php?id_film=4
    4. SELECT : Trouver les trois cinémas les plus proches du point de géolocalisation (48.3 2.21). ✔️ ***Page :*** index-cinema.php?geo_loc=true
    5. SELECT : Trouver les commentaires qui ont obtenu plus de 5 « likes ». ✔️ ***Page :*** more-5.php
    6. SELECT : Trouver dans les synopsis des films ceux qui correspondent le mieux à une sélection de mots. ✔️ ***Page :*** index-film.php (input recherche)

6. **Bonus non demandé**
    1. Design soigné et entièrement responsive.
    2. Génération de donnée custom avec FakerPHP ainsi que des scripts PHP
    3. Génération par IA d'une cinquantaine d'affiches de film.
    4. Ajout d'une fonction asynchrone pour la recherche des séances ***Page :*** infos-film.php?id_film=4
    5. Ajout de réactions par utilisateur connecté et suppression en asynchrone ***Page :*** infos-film.php?id_film=4
    6. Visuel d'une carte avec l'emplacement de tous les cinémas ***Page :*** index-cinema.php
    7. Récupération des photos d'acteur via l'API de Wikipedia ***Page :*** actor.html.php
    8. Fonction asynchrone pour la liste des collaborateurs ***Page :*** actor.html.php
    9. Modification des commentaire ou de la note pour un film donnée en asynchrone ***Page :*** profil.php
    10. Création d'un back office complet pour les admins.
    11. Mise en place d'un CRUD pour les films, des genres et des utilisateurs.