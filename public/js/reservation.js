document.addEventListener("DOMContentLoaded", () => {
  const allReservationCard = document.querySelectorAll(".pr-reservation-card")
  // console.log(allReservationCard);
  
  allReservationCard.forEach(reservationCard => {
    const updateBtns = reservationCard.querySelectorAll("button")
    const inputQuantity = reservationCard.querySelector("input")
    // console.log(updateBtns, inputQuantity);

    updateBtns.forEach(button => {
      button.addEventListener("click", () => updateQuantityReservation(reservationCard, button.name))
    });
    
  });
})



const updateQuantityReservation = async (card, actionType) => {
    const reservationId = card.getAttribute('data-reservation-id')
    console.log(reservationId);

    const reservationQuantity = card.querySelector("input")
    const reservationPrice = card.querySelector(".pr-price")
    const totalReservation = document.querySelector(".pr-total-price")
    if (actionType === "decrement" && reservationQuantity.value == 1) {
      card.remove()
    }
    try {
        const response = await fetch(`../../../public/api/updateReservation.php?id_reservation=${reservationId}&action_type=${actionType}`);
    
        if (!response.ok) {
          throw new Error(`Erreur avec la reservation ${reservationId}: ${response.status}`);
        }
    
        const data = await response.json();
    
        if (data.total_reservation.number_of_reservation === 0) {
            const titleReservation = document.querySelector(".pr-reservation-container h1")
            const containerSubmit = document.querySelector(".pr-button-submit")
            const submitBtn = document.querySelector(".pr-reserve-button")
            titleReservation.textContent = `Vous n'avez pas de réservation`
            totalReservation.textContent = `0 € TTC`
            submitBtn.remove()
            const linkFilms = document.createElement('a')
            linkFilms.href = "../film/index-film.php"
            linkFilms.id = "link-no-reservation"
            linkFilms.textContent = "Découvrez les films dans nos cinémas"
            containerSubmit.append(linkFilms)
            console.log("La Taille de la data est 0");
            
          return;
        }
        console.log(data);
        reservationQuantity.value = data.reservation.quantity_reservation
        reservationPrice.textContent = `${data.reservation.amount_reservation} €`
        totalReservation.textContent = `${data.total_reservation.total_amount_reservation} € TTC`
      } catch (error) {
        
        console.error(
          `Erreur lors de la récupération des données pour la reservation ${reservationId}:`,
          error
        );
      }
}