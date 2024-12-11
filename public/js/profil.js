const allReservation = document.querySelectorAll(
  ".container-profil-reservation .reservation"
);
let selectedScore;

allReservation.forEach((reservation) => {
  const btnToggleRating = reservation.querySelector(
    ".reservation-rating-toggle"
  );
  // console.log(btnToggleRating);
  if (btnToggleRating) {
    btnToggleRating.addEventListener("click", () =>
      handleBtnToggleClick(reservation)
    );
    console.log(btnToggleRating);
  }
});

function handleBtnToggleClick(reservation) {
  const reservationNote = reservation
    .querySelector(".reservation-rating-toggle")
    .getAttribute("data-rating");
  console.log(reservationNote);

  const modalContent = document.createElement("div");
  modalContent.className = "profil-modal";
  modalContent.innerHTML = `
    
    <button id="modal-close">
        <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M13.9393 33.9394C13.3536 34.5252 13.3536 35.4748 13.9393 36.0606C14.5251 36.6464 15.4749 36.6464 16.0607 36.0606L13.9393 33.9394ZM26.0606 26.0606C26.6464 25.4748 26.6464 24.5252 26.0606 23.9394C25.4748 23.3536 24.5252 23.3536 23.9394 23.9394L26.0606 26.0606ZM23.9394 23.9394C23.3536 24.5252 23.3536 25.4748 23.9394 26.0606C24.5252 26.6464 25.4748 26.6464 26.0606 26.0606L23.9394 23.9394ZM36.0606 16.0607C36.6464 15.4749 36.6464 14.5251 36.0606 13.9393C35.4748 13.3536 34.5252 13.3536 33.9394 13.9393L36.0606 16.0607ZM26.0606 23.9394C25.4748 23.3536 24.5252 23.3536 23.9394 23.9394C23.3536 24.5252 23.3536 25.4748 23.9394 26.0606L26.0606 23.9394ZM33.9394 36.0606C34.5252 36.6464 35.4748 36.6464 36.0606 36.0606C36.6464 35.4748 36.6464 34.5252 36.0606 33.9394L33.9394 36.0606ZM23.9394 26.0606C24.5252 26.6464 25.4748 26.6464 26.0606 26.0606C26.6464 25.4748 26.6464 24.5252 26.0606 23.9394L23.9394 26.0606ZM16.0607 13.9393C15.4749 13.3536 14.5251 13.3536 13.9393 13.9393C13.3536 14.5251 13.3536 15.4749 13.9393 16.0607L16.0607 13.9393ZM16.0607 36.0606L26.0606 26.0606L23.9394 23.9394L13.9393 33.9394L16.0607 36.0606ZM26.0606 26.0606L36.0606 16.0607L33.9394 13.9393L23.9394 23.9394L26.0606 26.0606ZM23.9394 26.0606L33.9394 36.0606L36.0606 33.9394L26.0606 23.9394L23.9394 26.0606ZM26.0606 23.9394L16.0607 13.9393L13.9393 16.0607L23.9394 26.0606L26.0606 23.9394Z" fill="white" />
        </svg>
    </button>
    <div class="modal-content">
        <img src="../../../public/images_film/leyn.webp" alt="">
        <div class="modal-info">
            <h3>Titre du film</h3>
            <div class="modal-stars">
            </div>
            <button id="submit-note">Valider la note</button>
        </div>
    </div>
    `;
  const containerStars = modalContent.querySelector(".modal-stars");
  for (let i = 0; i < 5; i++) {
    let starBtn = document.createElement("button");
    if (i < reservationNote) {
      starBtn.innerHTML = `
                    <svg class="star hovered" width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_429_27)">
                            <path d="M15 3.5L19 11L28.5 12.5L22 18.5L23 27.5L14.5 23.5L7 27.5L7.5 18.5L2 12L10.5 11L15 3.5Z" fill="#8D8D8D" stroke="black" />
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M14.9995 0.9375C15.2599 0.937333 15.5152 1.00947 15.737 1.14586C15.9588 1.28225 16.1384 1.47755 16.2558 1.71L20.1258 9.38625L28.792 10.6275C29.0533 10.6648 29.2989 10.7748 29.5006 10.9451C29.7023 11.1154 29.852 11.339 29.9326 11.5903C30.0132 11.8417 30.0214 12.1107 29.9563 12.3665C29.8912 12.6223 29.7555 12.8546 29.5645 13.0369L23.3114 18.9994L24.7852 27.4144C24.8302 27.6722 24.8024 27.9375 24.7049 28.1804C24.6074 28.4233 24.4441 28.6341 24.2332 28.7892C24.0224 28.9443 23.7725 29.0375 23.5116 29.0583C23.2507 29.0791 22.9891 29.0266 22.7564 28.9069L14.9995 24.9131L7.24265 28.9069C7.00993 29.0266 6.7484 29.0791 6.48749 29.0583C6.22658 29.0375 5.97665 28.9443 5.76582 28.7892C5.55499 28.6341 5.39163 28.4233 5.29413 28.1804C5.19662 27.9375 5.16884 27.6722 5.2139 27.4144L6.68765 18.9975L0.434525 13.035C0.244143 12.8527 0.108849 12.6205 0.0440804 12.3649C-0.0206883 12.1094 -0.0123237 11.8408 0.0682196 11.5898C0.148763 11.3388 0.298242 11.1154 0.499601 10.9453C0.70096 10.7752 0.946091 10.665 1.20702 10.6275L9.87327 9.38625L13.7433 1.71C13.8606 1.47755 14.0402 1.28225 14.262 1.14586C14.4838 1.00947 14.7391 0.937333 14.9995 0.9375ZM14.9995 5.4675L12.0558 11.3063C11.9538 11.5087 11.8043 11.6835 11.6202 11.8157C11.4361 11.9479 11.2227 12.0337 10.9983 12.0656L4.47328 12.9994L9.1739 17.4806C9.34096 17.6405 9.466 17.8392 9.53796 18.059C9.60991 18.2787 9.62655 18.5129 9.5864 18.7406L8.47265 25.1081L14.3564 22.0781C14.5553 21.9758 14.7758 21.9224 14.9995 21.9224C15.2232 21.9224 15.4437 21.9758 15.6427 22.0781L21.5264 25.1081L20.4108 18.7406C20.3709 18.5127 20.3878 18.2785 20.4601 18.0587C20.5324 17.8389 20.6578 17.6404 20.8252 17.4806L25.5258 12.9994L19.0008 12.0656C18.7767 12.0334 18.5637 11.9475 18.3799 11.8153C18.1961 11.6831 18.047 11.5085 17.9452 11.3063L14.9995 5.4675Z" fill="#8D8D8D" />
                        </g>
                        <defs>
                            <clipPath id="clip0_429_27">
                                <rect width="30" height="30" fill="white" />
                            </clipPath>
                        </defs>
                    </svg>
                `;
    } else {
      starBtn.innerHTML = `
                    <svg class="star" width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_429_27)">
                            <path d="M15 3.5L19 11L28.5 12.5L22 18.5L23 27.5L14.5 23.5L7 27.5L7.5 18.5L2 12L10.5 11L15 3.5Z" fill="#8D8D8D" stroke="black" />
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M14.9995 0.9375C15.2599 0.937333 15.5152 1.00947 15.737 1.14586C15.9588 1.28225 16.1384 1.47755 16.2558 1.71L20.1258 9.38625L28.792 10.6275C29.0533 10.6648 29.2989 10.7748 29.5006 10.9451C29.7023 11.1154 29.852 11.339 29.9326 11.5903C30.0132 11.8417 30.0214 12.1107 29.9563 12.3665C29.8912 12.6223 29.7555 12.8546 29.5645 13.0369L23.3114 18.9994L24.7852 27.4144C24.8302 27.6722 24.8024 27.9375 24.7049 28.1804C24.6074 28.4233 24.4441 28.6341 24.2332 28.7892C24.0224 28.9443 23.7725 29.0375 23.5116 29.0583C23.2507 29.0791 22.9891 29.0266 22.7564 28.9069L14.9995 24.9131L7.24265 28.9069C7.00993 29.0266 6.7484 29.0791 6.48749 29.0583C6.22658 29.0375 5.97665 28.9443 5.76582 28.7892C5.55499 28.6341 5.39163 28.4233 5.29413 28.1804C5.19662 27.9375 5.16884 27.6722 5.2139 27.4144L6.68765 18.9975L0.434525 13.035C0.244143 12.8527 0.108849 12.6205 0.0440804 12.3649C-0.0206883 12.1094 -0.0123237 11.8408 0.0682196 11.5898C0.148763 11.3388 0.298242 11.1154 0.499601 10.9453C0.70096 10.7752 0.946091 10.665 1.20702 10.6275L9.87327 9.38625L13.7433 1.71C13.8606 1.47755 14.0402 1.28225 14.262 1.14586C14.4838 1.00947 14.7391 0.937333 14.9995 0.9375ZM14.9995 5.4675L12.0558 11.3063C11.9538 11.5087 11.8043 11.6835 11.6202 11.8157C11.4361 11.9479 11.2227 12.0337 10.9983 12.0656L4.47328 12.9994L9.1739 17.4806C9.34096 17.6405 9.466 17.8392 9.53796 18.059C9.60991 18.2787 9.62655 18.5129 9.5864 18.7406L8.47265 25.1081L14.3564 22.0781C14.5553 21.9758 14.7758 21.9224 14.9995 21.9224C15.2232 21.9224 15.4437 21.9758 15.6427 22.0781L21.5264 25.1081L20.4108 18.7406C20.3709 18.5127 20.3878 18.2785 20.4601 18.0587C20.5324 17.8389 20.6578 17.6404 20.8252 17.4806L25.5258 12.9994L19.0008 12.0656C18.7767 12.0334 18.5637 11.9475 18.3799 11.8153C18.1961 11.6831 18.047 11.5085 17.9452 11.3063L14.9995 5.4675Z" fill="#8D8D8D" />
                        </g>
                        <defs>
                            <clipPath id="clip0_429_27">
                                <rect width="30" height="30" fill="white" />
                            </clipPath>
                        </defs>
                    </svg>
                
            `;
    }
    containerStars.append(starBtn);
  }

  document.body.append(modalContent);
  console.log(containerStars);

  handleStars(reservationNote);

  const submitNote = modalContent.querySelector("#submit-note");
  console.log(submitNote);
  submitNote.addEventListener("click", () =>{
    let idComment = reservation.getAttribute("data-comment-id")
    if (idComment) {
        console.log(idComment);
        
    } else {
        idComment = null
        console.log(idComment);
        
    }
    
    changeReservationRating(selectedScore, idComment)
});

  const btnQuitModal = document.querySelector("#modal-close");
  console.log(btnQuitModal);
  btnQuitModal.addEventListener("click", () => {
    const profilModal = document.querySelector(".profil-modal");
    profilModal.remove(modalContent);
  });
}
console.log(selectedScore);

function handleStars(reservationNote) {
  const buttons = document.querySelectorAll(".modal-stars button");
  reservationNote != null
    ? (selectedScore = parseInt(reservationNote))
    : (selectedScore = 0);
  console.log("Score avant changement ", selectedScore);

  buttons.forEach((button, index) => {
    //   const star = button.querySelector('.star');

    // Gestion du survol
    button.addEventListener("mouseenter", () => {
      // Ajoute la classe "hovered" aux étoiles jusqu'à celle survolée
      for (let i = 0; i <= index; i++) {
        const hoveredStar = buttons[i].querySelector(".star");
        hoveredStar.classList.add("hovered");
      }
    });

    button.addEventListener("mouseleave", () => {
      // Supprime la classe "hovered" des étoiles non sélectionnées
      buttons.forEach((btn, i) => {
        const hoveredStar = btn.querySelector(".star");
        if (i >= selectedScore) {
          hoveredStar.classList.remove("hovered");
        }
      });
    });

    // Gestion du clic
    button.addEventListener("click", () => {
      // Met à jour le score et applique la classe "hovered" aux étoiles sélectionnées
      selectedScore = index + 1;
      buttons.forEach((btn, i) => {
        const selectedStar = btn.querySelector(".star");
        if (i < selectedScore) {
          selectedStar.classList.add("hovered");
        } else {
          selectedStar.classList.remove("hovered");
        }
      });
      console.log(`Score sélectionné : ${selectedScore}`);
    });
  });
}

const changeReservationRating = async (selectedScore, idComment) => {
  console.log(selectedScore);

  try {
    const response = await fetch(`../../../public/api/updateCommentRating.php?rating=${selectedScore}&id_comment=${idComment}`);

    if (!response.ok) {
      throw new Error(
        `Erreur avec la reservation ${idComment}: ${response.status}`
      );
    }

    const data = await response.json();
    console.log(data);
    const modalInfo = document.querySelector(".modal-info")
    if (!modalInfo.querySelector('.message')) {
        const successMessage = document.createElement("h6")
        successMessage.className = "message"
        successMessage.textContent = "Note prise en compte"
        modalInfo.append(successMessage)
        setTimeout(() => {
            successMessage.remove()
        }, 4000);
    }
    if (data.length === 0) {
      return;
    }
  } catch (error) {
    console.error(
      `Erreur lors de la récupération des données pour la reservation ${idComment}:`,
      error
    );
  }
};
