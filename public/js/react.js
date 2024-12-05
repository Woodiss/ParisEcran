// react-svg-red
document.addEventListener("DOMContentLoaded", () => {
    const buttonsSvg = document.querySelectorAll('.comment-reaction button')

    buttonsSvg.forEach(button => {
        button.addEventListener('click', (event) => {
            // Exemple d'action à effectuer lors du clic
            console.log(`Bouton cliqué :`);
            // Vous pouvez ajouter ici toute autre logique
            let svg =  button.querySelector('svg')
            let span = button.previousElementSibling
            let NbReact = parseInt(span.textContent)
            let ReactType = button.value;
            let commId = button.getAttribute('data-comment-id')
            
            if (svg.classList.contains('react-svg-red')) {
                svg.classList.remove("react-svg-red")
                span.textContent = NbReact - 1

                fetchReact(ReactType, commId)

            } else {
                svg.classList.add("react-svg-red")
                span.textContent = NbReact + 1

                fetchReact(ReactType, commId)
            }
        });
    });

    async function fetchReact(reactType, commId) {

        try {
            const response = await fetch(`../../../public/api/updateReact.php?react_type=${reactType}&comm_id=${commId}`)
            // console.log(response);

            if (!response.ok) {
                throw new Error(`Erreur avec les informations données : ${response.status}`);
            }


        } catch (error) {
            console.error(`Erreur lors de la récupération des données :`, error);
        }
    }

})