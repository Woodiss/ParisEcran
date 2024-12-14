document.addEventListener('DOMContentLoaded', () => {
    // acteur
    const actorsContainer = document.getElementById('actors-container');
    const addActorButton = document.getElementById('add-actor');

    // soundDesigner
    const soundDesignerContainer = document.getElementById('soundDesigner-container');
    const addSoundDesignerButton = document.getElementById('add-soundDesigner');

    // récup le seclect de realisateur et récup tout les option pour créer une liste
    const realisateurSelect = document.getElementById('realisateur');
    const options = Array.from(realisateurSelect.options).map(option => ({
        id: option.value,
        name: option.textContent
    }));

    // Fonction pour créer un nouvel acteur avec un select
    function createSelect(index, role) {
        const div = document.createElement('div');
        const divSelectButton = document.createElement('div');
        div.classList.add(`${role}-select`);
        divSelectButton.classList.add('select-button');
    
        const label = document.createElement('label');
        label.setAttribute('for', `${role}_${index}`);
        label.textContent = `${role === 'actor' ? 'Acteur' : 'Sound Designer'} ${index + 1} :`;
    
        const select = document.createElement('select');
        select.name = `${role}s[]`;
        select.id = `${role}_${index}`;
    
        // Création des options
        options.forEach(option => {
            const opt = document.createElement('option');
            opt.value = option.id;
            opt.textContent = option.name;
            select.appendChild(opt);
        });
    
        // Bouton "Supprimer"
        const removeButton = document.createElement('button');
        removeButton.type = 'button';
        removeButton.classList.add(`remove-${role}`);
        removeButton.textContent = 'Supprimer';
    
        // Ajout de l'événement "Supprimer"
        removeButton.addEventListener('click', () => div.remove());
    
        // Ajouter les éléments dans la div
        div.appendChild(label);
        divSelectButton.appendChild(select);
        divSelectButton.appendChild(removeButton);
        div.appendChild(divSelectButton);
    
        return div;
    }
    

    // add acteur
    addActorButton.addEventListener('click', () => {
        const index = actorsContainer.querySelectorAll('.actor-select').length;
        const newActor = createSelect(index, 'actor');
        actorsContainer.appendChild(newActor);
    });
    // supp acteur
    actorsContainer.addEventListener('click', (event) => {
        if (event.target.classList.contains('remove-actor')) {
            event.target.closest('.actor-select').remove();
        }
    });


    // add soundDesigner
    addSoundDesignerButton.addEventListener('click', () => {
        const index = soundDesignerContainer.querySelectorAll('.soundDesigner-select').length;
        const newActor = createSelect(index, 'soundDesigner');
        soundDesignerContainer.appendChild(newActor);
    });
    // supp soundDesigner
    soundDesignerContainer.addEventListener('click', (event) => {
        if (event.target.classList.contains('remove-soundDesigner')) {
            event.target.closest('.soundDesigner-select').remove();
        }
    });
});
