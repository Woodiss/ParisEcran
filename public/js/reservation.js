document.addEventListener("DOMContentLoaded", () => {

    const CinemaSelect = document.getElementById("select-cinema");
    const hourContainer = document.getElementById('hour-container')
    const dateContainer = document.getElementById('date-container')

    CinemaSelect.addEventListener("change", async (event) => {
        const SelectValue = event.target.value;
        // console.log(SelectValue);

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
                // console.log("Données reçues :", dataDate);
    
                if (dataDate.length === 0) {
                    dateContainer.textContent = "Aucune séance trouvé pour ce film"              
                    return
                }

                dateContainer.innerHTML = ""              
                addTitleReservation(dateContainer, "date")
                dateContainer.parentNode.querySelector("h3") ?? dateContainer.parentNode.querySelector("h3").remove()
                hourContainer.parentNode.querySelector("h3")?.remove()

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
                            // console.log("Données reçues :", dataHour);

                            hourContainer.innerHTML = ""
                            addTitleReservation(hourContainer, "hour")
                            hourContainer.parentNode.querySelector("h3") ?? hourContainer.parentNode.querySelector("h3").remove()

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

function addTitleReservation (element, type){
    if (element.parentNode.querySelector("h3")) {
        return
    }
    const title = document.createElement('h3');
    type === "date" ? title.textContent = "Date de la séance" : title.textContent = "Séance disponnible"
    
    element.parentNode.prepend(title)
}

const reservationForm = document.querySelector("#reservation-form");

// Vérifie si le formulaire est valide
reservationForm.addEventListener("change", isFormValid);

function isFormValid() {
    const selectCinemaValue = document.querySelector("#reservation-form #select-cinema").value;
    const inputDateValue = document.querySelector("#reservation-form input[name='date']:checked")?.value || null;
    const inputHourValue = document.querySelector("#reservation-form input[name='hour']:checked")?.value || null;
    const submitButton = document.querySelector("#reservation-form button")

    // console.log(`Select Cinéma Value: ${selectCinemaValue}, Input Date Value: ${inputDateValue}, Input Hour Value: ${inputHourValue}`);
    if (selectCinemaValue && inputDateValue && inputHourValue) {
        submitButton.classList.remove("hide")
    } else {
        submitButton.classList.add("hide")
    }
}

// Reset dates et heures lorsqu'un cinéma est sélectionné
const selectCinema = document.querySelector("#reservation-form #select-cinema");
selectCinema.addEventListener("change", resetInputs);

function resetInputs() {
    // Reset des dates
    const allInputs = reservationForm.querySelectorAll("input[name='date'], input[name='hour']");
    allInputs.forEach(input => {
        input.checked = false;
    });
    console.log("All inputs reset after cinema change");
}

// Reset des heures au chagement de la date
reservationForm.addEventListener("change", (event) => {
    if (event.target.name === 'date') {
        resetHours();
    }
});

function resetHours() {
    // Fonction du Reset des heures
    const hourInputs = reservationForm.querySelectorAll("input[name='hour']");
    hourInputs.forEach(input => {
        input.checked = false;
    });
    console.log("Hour inputs reset after date change");
    isFormValid()
}