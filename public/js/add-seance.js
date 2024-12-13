document.addEventListener('DOMContentLoaded', () => {
    const selectCinema = document.getElementById('cinema');
    const selectRoom = document.getElementById('room');
    const erreur = document.getElementById('erreur'); // Ajoutez un élément pour afficher les erreurs

    selectCinema.addEventListener("change", async (event) => {
        const selectedCinema = event.target.value;

        if (selectCinema !== '#') {
            try {
                // Réinitialise les options de "selectRoom"
                selectRoom.innerHTML = '<option value="">Sélectionnez une salle</option>';
                erreur.textContent = ""; // Réinitialise les erreurs
                
                const response = await fetch(`../../../../public/api/add-seance.php?cinema_id=${selectedCinema}`);
                
                if (!response.ok) {
                    throw new Error(`Erreur avec le cinéma ${selectedCinema}: ${response.status}`);
                }
                
                const data = await response.json();
                
                if (data.error) {
                    erreur.textContent = data.error; // Affiche l'erreur retournée par l'API
                    return;
                }
                
                if (data.length === 0) {
                    erreur.textContent = "Aucune salle trouvée pour ce cinéma";
                    return;
                }
                
                // Ajoute les options au selectRoom
                data.forEach(room => {
                    const option = document.createElement('option');
                    option.value = room.id; // Assurez-vous que la clé correspond
                    option.textContent = room.name; // Assurez-vous que la clé correspond
                    selectRoom.appendChild(option);
                });
                
            } catch (error) {
                console.error(`Erreur lors de la récupération des données:`, error);
                erreur.textContent = "Une erreur est survenue lors du chargement des salles.";
            }
        }
    });
});
