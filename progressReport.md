# Rapport sur l'avencement du projet

Ici est répertorié tous les demandes concernant le projet et leurs état ainsi que l'emplacement ou il ce trouve dans le projet.

✔️= Terminer  
❌ = Pas commencé  
🚧 =  En cours  

## Cas d'utilisation

1. **Création :**
    1. Créer un utilisateur (s'incrire) : ✔️ ***Page :*** inscription.php
    2. Associer un artiste à un spectacle : ✔️
    3. Créer un spectacle : ✔️ ***Page :*** create-film.php
    4. Effectuer une réservation pour un spectacle donné : ✔️ ***Page :*** infos-film.php

2. **Mise à jour :**
    1. Modifier le mot de passe d'un utilisateur: ❌
    2. Ajouter une place à une réservation si le paiement n'a pas encore été effectué et modifier le montant à payer : ✔️ ***Page :*** reservation.php
    3. Pour tous les spectacles ayant lieu un jour donné, augmenter le prix de 10% (les réservations déjà payées ne sont pas concernées) : ✔️ ***Page :*** inflation.php

3. **Consultation :**
    1. Afficher la liste des lieux de spectacle : ✔️ ***Page :*** index-cinema.php
    2. Afficher les spectacles par arrondissement : 🚧 ***Page :*** index-cinema.php
    3. Afficher les salles par arrondissement (borough) : ❌
    4. Afficher les spectacles en cours pour une catégorie donnée : ✔️ ***Page :*** index-film.php
    5. Afficher le nombre de spectacles par catégorie : ✔️ ***Page :*** index-film.php
    6. Afficher les nombre moyen de places réservées (au total) par les personnes inscrites : ❌
    7. Afficher la distribution statistique des réservations de places (c'est-à-dire le nombre de personnes ayant réservé au total un certain nombre de places) : ❌
    8. Afficher le taux de remplissage des salles par spectacle, trié par ordre décroissant : ❌
    9. Faire la liste des artistes qui ont participé avec un artiste donné à au moins deux spectacles différents : ✔️ ***Page :*** actor.html.php
    10. Afficher les liste de tous les metteurs en scène qui sont travaillé dans un théâtre donné : ✔️ ***Page :*** index-cinema.php
    11. Afficher les trois catégories de spectacles pour lesquelles le plus de places ont été réservées : ✔️ ***Page :*** best-genre.php 
    12. Recommandation : proposer à un personne X des spectacles qu'elle pourrait aimer, proposition basée sur les spectacles vus par les gens qui ont vu des spectacles en commun avec X : 🚧 ***Page :*** profil.php
    13. Afficher la liste des théâtres, triée par la note moyenne obtenue par les spectacles qui s'y sont joués : 🚧 ***Page :*** index-cinema.php
    14. Existe-t-il des artistes ayant tenu au moins trois fonctions différentes (dans différents spectacles) ? : ✔️ ***Page :*** actor.html.php
    15. Afficher la liste des recettes par spectacle et par ordre décroissant : ✔️ ***Page :*** films-revenue.php
    16. Y a-t-il des spectacles qui ont affiché complet parmi ceux qui ne se jouent plus ? : ❌
    17. Quels sont les artistes préférés des spectateurs, c'est-à-dire ceux ayant participé aux spectacles les mieux notés en moyenne ? : ✔️ ***Page :*** actor.html.php

4. **Suppression :**
    1. Supprimer une réservation connaissant le spectateur et le spectacle : ❌
    2. Annuler un spectacle : ❌

5. **Bonus**
    1. INSERT : Créer un spectacle avec les dates des représentations et y associer une salle. ❌
    2. DELETE : Supprimer un compte utilisateur (subscriber). Quels problèmes cela pose-t-il ? ❌
    3. UPDATE : Ajouter une réaction au commentaire d'un utilisateur. ✔️
    4. SELECT : Trouver les trois théâtres les plus proches du point de géolocalisation (48.3 2.21). ❌
    5. SELECT : Trouver les commentaires qui ont obtenu plus de 5 « likes ». ❌
    6. SELECT : Trouver dans les synopsis des spectacles ceux qui correspondent le mieux à une
    sélection de mots. ❌