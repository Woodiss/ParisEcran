<?php

use parisecran\DBAL\Connector;
use parisecran\Entity\Subscribers;

session_start();
// print_r($_SESSION);

require_once __DIR__ . "/../../../vendor/autoload.php";

$dbh = new Connector();
$subscribersModel = new Subscribers($dbh->dbConnector);

if (!empty($_SESSION['id'])) {
    // $subscribersModel->logoutSubcriber();
} else {
    header("Location: ../subscribers/login.php");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['confirm'])) {
        $subscribersModel->confirmReservation($_SESSION['id']);
        header("Location: ../subscribers/profil.php");
        exit;
    }
}

$subscribersModel->deleteReservationNotPaidAndNotValid($_SESSION['id']);
$reservationList = $subscribersModel->selectReservationNotPaid($_SESSION['id']);
$totalReservation = $subscribersModel->getAllNotPaidReservationTotal($_SESSION['id']);
if (empty($reservationList)) {
    header("Location: ../film/index-film.php");
}
// print_r($reservationList);

$moisFrancais = [
    'January' => 'Janvier', 'February' => 'Février', 'March' => 'Mars',
    'April' => 'Avril', 'May' => 'Mai', 'June' => 'Juin',
    'July' => 'Juillet', 'August' => 'Août', 'September' => 'Septembre',
    'October' => 'Octobre', 'November' => 'Novembre', 'December' => 'Décembre'
];

$titlePage = "Réservations";
require_once __DIR__ . "/../../../src/views/header.html.php";
?>

<div class="pr-reservation-container">
    <h1>Confirmer votre réservation</h1>
    <?php foreach ($reservationList as $reservation) {
        $reservatinDateTime = new DateTime($reservation['reservation_date']);
        $formatedDate = $reservatinDateTime->format('d F H:i');
        $formatedDate = strtr($formatedDate, $moisFrancais)
    ?>
        <div class="pr-box pr-reservation-card" data-reservation-id="<?= $reservation['reservation_id'] ?>">
            <img src="<?= "../../../public/images_film/" . $reservation['film_image'] ?>" alt="<?= $reservation['film_title'] ?>" class="pr-film-poster">
            <div class="pr-details-container">

                <div class="pr-reservation-details">
                    <h2><?= $reservation['film_title'] ?></h2>
                    <p><?= $reservation['cinema_name'] ?></p>
                    <p><?= $formatedDate ?></p>
                    <p>Salle <?= $reservation['room_name'] ?> <?= $reservation['film_language'] ?></p>
                </div>

                <div class="pr-reservation-price">
                    <span class="pr-price"><?= $reservation['film_unit_price'] * $reservation['reservation_quantity'] ?> €</span>
                    <div class="pr-quantity-control">

                        <form method="" action="">
                            <button type="button" name="decrement" class="pr-btn-decrease">-</button>
                            <input type="text" name="quantity" value="<?= $reservation['reservation_quantity'] ?>" readonly>
                            <button type="button" name="increment" class="pr-btn-increase">+</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="pr-box pr-total-container">
        <p>Total : <span class="pr-total-price"><?= $totalReservation['total_amount_reservation'] ?> € TTC</span></p>
    </div>

    <div class="pr-button-submit">
        <form method="POST" action="">
            <button type="submit" class="pr-reserve-button" name="confirm">
                <svg width="30" height="25" viewBox="0 0 33 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18.0297 4.113C18.3157 3.827 18.7027 3.667 19.1077 3.667C19.5127 3.667 19.8997 3.827 20.1857 4.113L22.3517 6.282C22.6227 6.552 22.7817 6.915 22.7977 7.297C22.8137 7.681 22.6837 8.057 22.4347 8.349L22.4327 8.352C22.2757 8.536 22.1927 8.772 22.2017 9.014C22.2107 9.256 22.3107 9.484 22.4807 9.655C22.6517 9.825 22.8807 9.925 23.1227 9.933C23.3647 9.941 23.6007 9.859 23.7837 9.701L23.7877 9.697C24.0797 9.448 24.4557 9.318 24.8397 9.334C25.2227 9.35 25.5847 9.51 25.8547 9.781L25.8577 9.784L28.0207 11.947C28.3067 12.233 28.4677 12.621 28.4677 13.025C28.4677 13.429 28.3067 13.817 28.0217 14.103L24.5677 17.557C24.3147 17.81 24.0097 18.006 23.6747 18.131C23.5497 18.467 23.3547 18.773 23.1007 19.028L14.2407 27.887C13.9547 28.173 13.5667 28.333 13.1627 28.333C12.7587 28.333 12.3707 28.172 12.0847 27.887L9.91873 25.721C9.64773 25.451 9.48773 25.088 9.47173 24.706C9.45573 24.322 9.58573 23.946 9.83473 23.654L9.83773 23.651C9.99573 23.467 10.0777 23.231 10.0687 22.99C10.0597 22.749 9.95973 22.519 9.78873 22.348C9.61773 22.177 9.38873 22.077 9.14673 22.068C8.90473 22.059 8.66873 22.141 8.48473 22.299L8.48173 22.302C8.18973 22.551 7.81373 22.681 7.42973 22.665C7.04673 22.649 6.68473 22.489 6.41473 22.218L6.41173 22.215L4.24873 20.052C3.96273 19.766 3.80273 19.378 3.80273 18.974C3.80273 18.57 3.96273 18.182 4.24873 17.896L13.1077 9.039C13.3607 8.786 13.6667 8.59 14.0017 8.465C14.1267 8.128 14.3227 7.822 14.5767 7.568L18.0297 4.113ZM13.9727 8.543L14.1337 8.597L14.1347 8.599L13.9717 8.545L13.9727 8.543ZM14.1367 8.599L14.1357 8.597L15.2377 8.964L14.1367 8.599ZM14.5037 9.701L14.8707 10.803L14.8737 10.806L14.5037 9.701ZM14.8747 10.807L14.8717 10.804L14.9257 10.965L14.9277 10.964L14.8747 10.807ZM14.9637 10.952L6.94173 18.972L7.66773 19.698C8.16173 19.484 8.70073 19.38 9.24773 19.401C10.1617 19.436 11.0277 19.814 11.6747 20.46C12.3217 21.106 12.6997 21.973 12.7337 22.887C12.7547 23.434 12.6507 23.974 12.4367 24.467L13.1627 25.193L21.1847 17.171C21.3077 16.819 21.5087 16.499 21.7727 16.235C22.0367 15.971 22.3577 15.768 22.7107 15.643L25.3287 13.025L24.6037 12.3C24.1107 12.514 23.5717 12.618 23.0257 12.598C22.1127 12.565 21.2457 12.188 20.5987 11.543L21.5397 10.598L20.5967 11.541C19.9507 10.895 19.5727 10.028 19.5377 9.115C19.5167 8.568 19.6197 8.028 19.8347 7.534L19.1077 6.806L16.4897 9.424C16.3667 9.776 16.1657 10.095 15.9027 10.36C15.6377 10.625 15.3177 10.828 14.9647 10.952H14.9637ZM22.7477 15.63L23.1707 16.894L22.7497 15.629L22.7477 15.63ZM23.5377 17.996L22.4367 17.631L23.5387 17.998L23.5377 17.996ZM23.5407 17.999L23.5397 17.996L23.7027 18.05L23.7017 18.052L23.5407 17.999Z" fill="white" />
                    <path d="M14.5827 9.043C14.8427 8.783 15.2647 8.783 15.5257 9.043L16.3367 9.854C16.5967 10.114 16.5967 10.536 16.3367 10.797C16.0767 11.058 15.6547 11.057 15.3937 10.797L14.5827 9.986C14.3227 9.726 14.3227 9.304 14.5827 9.043ZM17.0147 11.475C17.2747 11.215 17.6967 11.214 17.9577 11.475L18.4987 12.015C18.7587 12.275 18.7597 12.697 18.4987 12.958C18.2377 13.219 17.8167 13.219 17.5557 12.958L17.0147 12.418C16.7537 12.158 16.7537 11.736 17.0147 11.475ZM19.1767 13.637C19.4367 13.377 19.8597 13.377 20.1197 13.637L20.6597 14.178C20.9197 14.438 20.9197 14.861 20.6597 15.121C20.3997 15.381 19.9767 15.381 19.7167 15.121L19.1767 14.58C18.9167 14.319 18.9167 13.897 19.1767 13.637ZM21.3387 15.799C21.5987 15.539 22.0217 15.539 22.2817 15.799L23.0927 16.61C23.3527 16.87 23.3527 17.292 23.0927 17.553C22.8327 17.814 22.4107 17.813 22.1497 17.553L21.3387 16.742C21.0787 16.482 21.0787 16.06 21.3387 15.799Z" fill="white" />
                </svg>

                <span>Réserver</span>
            </button>
        </form>
    </div>
</div>
<?php require_once __DIR__ . "/../../../src/views/footer.html.php" ?>