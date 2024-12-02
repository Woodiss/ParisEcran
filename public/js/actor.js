document.addEventListener("DOMContentLoaded", () => {
    const actorCards = document.querySelectorAll(".actor");

    actorCards.forEach(async (card) => {
        const actorName = card.getAttribute("data-name");

        try {
            const response = await fetch(`../../../public/api/getActorImage.php?name=${encodeURIComponent(actorName)}`);
            console.log(response);

            if (!response.ok) {
                throw new Error(`Erreur avec l'acteur ${actorName}: ${response.status}`);
            }

            const data = await response.json();
            console.log(data);
            
            if (data.image) {
                const imageElement = card.querySelector("img");
                imageElement.src = data.image;
            } else {
                console.warn(`Image non trouvée pour ${actorName}`);
            }

            if (data.url) {
                const linkElement = card.querySelector("a");
                linkElement.href = data.url;
            } else {
                console.warn(`Page Wikipédia non trouvée pour ${actorName}`);
            }

        } catch (error) {
            console.error(`Erreur lors de la récupération des données pour ${actorName}:`, error);
        }
    });
});
