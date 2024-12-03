document.addEventListener("DOMContentLoaded", () => {
    
    const CinemaSelect = document.getElementById("select-cinema");
    const hourContainer = document.getElementById('hour-container')
    const dateContainer = document.getElementById('date-container')
                            
    CinemaSelect.addEventListener("change", async (event) => {
        const SelectValue = event.target.value;
        console.log(SelectValue);

        if (SelectValue != '#') {
            
            const queryString = window.location.search;
            // Crée un objet URLSearchParams
            const urlParams = new URLSearchParams(queryString);
            // Récupère un paramètre spécifique
            const FilmId = urlParams.get('id_film');
    
            try {
                const response = await fetch(`../../../public/api/getSeances.php?cinema_id=${SelectValue}&id_film=${FilmId}`)
    
                if (!response.ok) {
                    throw new Error(`Erreur avec le cinema ${SelectValue}: ${response.status}`);
                }
    
                // Extraire le JSON de la réponse
                const dataDate = await response.json();
                console.log("Données reçues :", dataDate);
    
                dateContainer.innerHTML = ""
                hourContainer.innerHTML = ""
                for (const date in dataDate) {
                    const seances = dataDate[date]
                    // Créer l'élément input
                    const input = document.createElement('input');
                    input.type = 'radio';
                    input.id = `date-${date}`;
                    input.name = 'date';
                    input.value = seances[0].time_slot; // Vous pouvez définir la valeur à la date brute si nécessaire

                    // Créer l'élément label
                    const label = document.createElement('label');
                    label.htmlFor = `date-${date}`;
                    label.classList.add('date-reservation');
                    label.textContent = date;

                    // Ajouter les éléments au container
                    dateContainer.appendChild(input);
                    dateContainer.appendChild(label);

                    // **Ajouter l'écouteur d'événement à l'input**
                    input.addEventListener("change", async (event) => {
                        valueDate = event.target.value
                        // Traitez la sélection ici
                        try {
                            const response = await fetch(`../../../public/api/getSeances.php?cinema_id=${SelectValue}&id_film=${FilmId}&date=${valueDate}`)
                            // console.log(response);
                
                            if (!response.ok) {
                                throw new Error(`Erreur avec le cinema ${SelectValue}: ${response.status}`);
                            }
                
                            // Extraire le JSON de la réponse
                            const dataHour = await response.json();
                            console.log("Données reçues :", dataHour);

                            hourContainer.innerHTML = ""
                            for (const hour in dataHour) {
                                const seances = dataHour[hour]
                                // Créer l'élément input
                                const input = document.createElement('input');
                                input.type = 'radio';
                                input.name = 'hour';
                                input.id = `hour-${seances[0].id}`;
                                input.required = true; // Ajouter l'attribut required
                                input.value = seances[0].id;

                                // Créer l'élément label
                                const label = document.createElement('label');
                                label.htmlFor = input.id;
                                label.classList.add('hour-reservation');

                                // Ajouter le contenu HTML au label
                                label.innerHTML = `
                                    <h4>${hour}</h4>
                                    <span>Salle ${seances[0].name}</span>
                                    <span>${seances[0].language}</span>
                                `;

                                // Ajouter les éléments au container
                                hourContainer.appendChild(input);
                                hourContainer.appendChild(label);
                            }

                        } catch (error) {
                            console.error(`Erreur lors de la récupération des données pour ${SelectValue}:`, error);
                        }
                    });
                }
    
            } catch (error) {
                console.error(`Erreur lors de la récupération des données pour ${SelectValue}:`, error);
            }
        }
        
    })
});