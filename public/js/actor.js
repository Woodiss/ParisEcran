document.addEventListener("DOMContentLoaded", () => {
  const actorCards = document.querySelectorAll(".actor");
  actorCards.forEach(async (card) => getActorImage(card));
});

const selectActor = document.querySelector("#actor-select");

selectActor.addEventListener("change", async (e) => {
  const actorId = e.target.value;

  const titleActorCollabs = document.querySelector("#title-actor-collabs span");
  const containerActorCollabs = document.querySelector("#container-actor-collabs");

  containerActorCollabs.innerHTML = "";
  containerActorCollabs.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" id="loader-infinite" width="200" viewBox="0 0 300 150"><path fill="none" stroke="#FF0020" stroke-width="15" stroke-linecap="round" stroke-dasharray="300 385" stroke-dashoffset="0" d="M275 75c0 31-27 50-50 50-58 0-92-100-150-100-28 0-50 22-50 50s23 50 50 50c58 0 92-100 150-100 24 0 50 19 50 50Z"><animate attributeName="stroke-dashoffset" calcMode="spline" dur="2" values="685;-685" keySplines="0 0 1 1" repeatCount="indefinite"></animate></path></svg>`;

  try {
    const response = await fetch(`../../../public/api/getActorCollabs.php?id=${actorId}`);

    if (!response.ok) {
      throw new Error(`Erreur avec l'acteur ${actorId}: ${response.status}`);
    }

    const data = await response.json();

    if (data.length === 0) {
      titleActorCollabs.textContent = `(0)`;
      containerActorCollabs.textContent = "Aucune collaboration trouvée pour cet acteur.";
      return;
    }

    titleActorCollabs.textContent = `(${data.length})`;
    containerActorCollabs.innerHTML = "";

    data.forEach((actor) => {
      const card = document.createElement("div");
      card.className = "actor";
      card.dataset.name = `${actor.actor2_firstname} ${actor.actor2_lastname}`;

      card.innerHTML = `
                <img src="${
                  actor.image ||
                  "../../../public/images_film/anonymous-profile.jpg"
                }" alt="Image de ${actor.actor2_firstname} ${actor.actor2_lastname}">
                <h3>${actor.actor2_firstname} ${actor.actor2_lastname}</h3>
                <div class="actor-rating">
                    ${generateStars(actor.average_notation || 0)}
                </div>
                <a href="#">En savoir plus</a>
            `;

      containerActorCollabs.appendChild(card);
      getActorImage(card);
    });
  } catch (error) {
    titleActorCollabs.textContent = `(0)`;
    console.log(error);

    containerActorCollabs.textContent =
      "Erreur lors de la récupération des collaborations.";
    console.error(
      `Erreur lors de la récupération des données pour ${actorId}:`,
      error
    );
  }
});

function generateStars(rating) {
  let stars = "";
  for (let i = 0; i < 5; i++) {
    if (i < rating) {
      stars += `
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_24_1239)">
                        <path d="M7.99998 1.86667L10.1333 5.86667L15.2 6.66667L11.7333 9.86667L12.2666 14.6667L7.73332 12.5333L3.73332 14.6667L3.99998 9.86667L1.06665 6.4L5.59998 5.86667L7.99998 1.86667Z" fill="#FF0020" stroke="black" />
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.99971 0.5C8.13859 0.499911 8.27476 0.538382 8.39306 0.611125C8.51135 0.683869 8.60713 0.788029 8.66971 0.912L10.7337 5.006L15.3557 5.668C15.4951 5.68787 15.6261 5.74657 15.7336 5.83738C15.8412 5.92819 15.9211 6.04745 15.964 6.18151C16.007 6.31557 16.0114 6.45902 15.9767 6.59545C15.942 6.73189 15.8695 6.85579 15.7677 6.953L12.4327 10.133L13.2187 14.621C13.2427 14.7585 13.2279 14.9 13.1759 15.0295C13.1239 15.1591 13.0368 15.2715 12.9244 15.3543C12.8119 15.437 12.6786 15.4867 12.5395 15.4978C12.4003 15.5088 12.2608 15.4809 12.1367 15.417L7.99971 13.287L3.86271 15.417C3.7386 15.4809 3.59911 15.5088 3.45996 15.4978C3.32081 15.4867 3.18751 15.437 3.07507 15.3543C2.96263 15.2715 2.87551 15.1591 2.8235 15.0295C2.7715 14.9 2.75668 14.7585 2.78071 14.621L3.56671 10.132L0.231714 6.952C0.130177 6.85475 0.0580203 6.73092 0.023477 6.59463C-0.0110663 6.45834 -0.00660522 6.31509 0.0363513 6.18121C0.0793077 6.04734 0.15903 5.92824 0.266421 5.83749C0.373813 5.74675 0.504549 5.68802 0.643714 5.668L5.26571 5.006L7.32971 0.912C7.3923 0.788029 7.48808 0.683869 7.60637 0.611125C7.72467 0.538382 7.86084 0.499911 7.99971 0.5ZM7.99971 2.916L6.42971 6.03C6.37531 6.13797 6.29561 6.23118 6.19741 6.3017C6.0992 6.37222 5.98541 6.41795 5.86571 6.435L2.38571 6.933L4.89271 9.323C4.98181 9.40829 5.0485 9.51423 5.08688 9.63145C5.12525 9.74866 5.13413 9.87354 5.11271 9.995L4.51871 13.391L7.65671 11.775C7.76282 11.7204 7.8804 11.692 7.99971 11.692C8.11903 11.692 8.23661 11.7204 8.34272 11.775L11.4807 13.391L10.8857 9.995C10.8644 9.87345 10.8735 9.74853 10.912 9.63131C10.9506 9.51409 11.0174 9.40819 11.1067 9.323L13.6137 6.933L10.1337 6.435C10.0142 6.4178 9.90061 6.372 9.80259 6.30149C9.70457 6.23098 9.62503 6.13784 9.57071 6.03L7.99971 2.916Z" fill="#FF0020" />
                    </g>
                    <defs>
                        <clipPath id="clip0_24_1239">
                            <rect width="16" height="16" fill="white" />
                        </clipPath>
                    </defs>
                </svg>`;
    } else {
      stars += `
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_24_1243)">
                        <path d="M7.99998 1.86667L10.1333 5.86667L15.2 6.66667L11.7333 9.86667L12.2666 14.6667L7.73332 12.5333L3.73332 14.6667L3.99998 9.86667L1.06665 6.4L5.59998 5.86667L7.99998 1.86667Z" fill="#8D8D8D" stroke="black" />
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.99971 0.5C8.13859 0.499911 8.27476 0.538382 8.39306 0.611125C8.51135 0.683869 8.60713 0.788029 8.66971 0.912L10.7337 5.006L15.3557 5.668C15.4951 5.68787 15.6261 5.74657 15.7336 5.83738C15.8412 5.92819 15.9211 6.04745 15.964 6.18151C16.007 6.31557 16.0114 6.45902 15.9767 6.59545C15.942 6.73189 15.8695 6.85579 15.7677 6.953L12.4327 10.133L13.2187 14.621C13.2427 14.7585 13.2279 14.9 13.1759 15.0295C13.1239 15.1591 13.0368 15.2715 12.9244 15.3543C12.8119 15.437 12.6786 15.4867 12.5395 15.4978C12.4003 15.5088 12.2608 15.4809 12.1367 15.417L7.99971 13.287L3.86271 15.417C3.7386 15.4809 3.59911 15.5088 3.45996 15.4978C3.32081 15.4867 3.18751 15.437 3.07507 15.3543C2.96263 15.2715 2.87551 15.1591 2.8235 15.0295C2.7715 14.9 2.75668 14.7585 2.78071 14.621L3.56671 10.132L0.231714 6.952C0.130177 6.85475 0.0580203 6.73092 0.023477 6.59463C-0.0110663 6.45834 -0.00660522 6.31509 0.0363513 6.18121C0.0793077 6.04734 0.15903 5.92824 0.266421 5.83749C0.373813 5.74675 0.504549 5.68802 0.643714 5.668L5.26571 5.006L7.32971 0.912C7.3923 0.788029 7.48808 0.683869 7.60637 0.611125C7.72467 0.538382 7.86084 0.499911 7.99971 0.5ZM7.99971 2.916L6.42971 6.03C6.37531 6.13797 6.29561 6.23118 6.19741 6.3017C6.0992 6.37222 5.98541 6.41795 5.86571 6.435L2.38571 6.933L4.89271 9.323C4.98181 9.40829 5.0485 9.51423 5.08688 9.63145C5.12525 9.74866 5.13413 9.87354 5.11271 9.995L4.51871 13.391L7.65671 11.775C7.76282 11.7204 7.8804 11.692 7.99971 11.692C8.11903 11.692 8.23661 11.7204 8.34272 11.775L11.4807 13.391L10.8857 9.995C10.8644 9.87345 10.8735 9.74853 10.912 9.63131C10.9506 9.51409 11.0174 9.40819 11.1067 9.323L13.6137 6.933L10.1337 6.435C10.0142 6.4178 9.90061 6.372 9.80259 6.30149C9.70457 6.23098 9.62503 6.13784 9.57071 6.03L7.99971 2.916Z" fill="#8D8D8D" />
                    </g>
                    <defs>
                        <clipPath id="clip0_24_1243">
                            <rect width="16" height="16" fill="white" />
                        </clipPath>
                    </defs>
                </svg>`;
    }
  }
  return stars;
}

const getActorImage = async (card) => {
  const actorName = card.getAttribute("data-name");

  try {
    const response = await fetch(
      `../../../public/api/getActorImage.php?name=${encodeURIComponent(
        actorName
      )}`
    );

    if (!response.ok) {
      throw new Error(`Erreur avec l'acteur ${actorName}: ${response.status}`);
    }

    const data = await response.json();

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
    console.error(
      `Erreur lors de la récupération des données pour ${actorName}:`,
      error
    );
  }
};
