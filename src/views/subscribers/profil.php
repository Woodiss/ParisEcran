<?php

use parisecran\DBAL\Connector;
use parisecran\Entity\Subscribers;

session_start();

require_once __DIR__ . "/../../../vendor/autoload.php";

$dbh = new Connector();
$subscribersModel = new Subscribers($dbh->dbConnector);

if (!isset($_SESSION['id'])) {
    header("Location: ../subscribers/login.php");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['deco'])) {
        $subscribersModel->logoutSubcriber();
    }
}

$reservationList = $subscribersModel->SelectReservationPaid($_SESSION['id']);
$reco = $subscribersModel->recommendationFilms($_SESSION['id']);
// print_r($reservationList);

$currentDate = new DateTime();
// print_r($currentDate);

$titlePage = "Profil";
$moisFrancais = [
    'January' => 'Janvier',
    'February' => 'Février',
    'March' => 'Mars',
    'April' => 'Avril',
    'May' => 'Mai',
    'June' => 'Juin',
    'July' => 'Juillet',
    'August' => 'Août',
    'September' => 'Septembre',
    'October' => 'Octobre',
    'November' => 'Novembre',
    'December' => 'Décembre'
];
$birthdate = new DateTime($_SESSION['birthdate']);
$formatedBirthdate = $birthdate->format('d F Y');
$formatedBirthdate = strtr($formatedBirthdate, $moisFrancais);

require_once __DIR__ . "/../../../src/views/header.html.php";

?>

<aside id="user-information">
    <button id="toggle-user-information">
        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M16 14.6667C18.9455 14.6667 21.3333 12.2789 21.3333 9.33333C21.3333 6.38781 18.9455 4 16 4C13.0544 4 10.6666 6.38781 10.6666 9.33333C10.6666 12.2789 13.0544 14.6667 16 14.6667Z" stroke="#ff0020" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            <path d="M26.6666 26.6807V21.8667C26.6666 21.018 26.3295 20.204 25.7294 19.6039C25.1293 19.0038 24.3153 18.6667 23.4666 18.6667H8.53331C7.68462 18.6667 6.87069 19.0038 6.27057 19.6039C5.67046 20.204 5.33331 21.018 5.33331 21.8667V26.6807" stroke="#ff0020" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"></path>
        </svg>
        <svg class="hide" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M8.92078 21.7213C8.54594 22.0962 8.54594 22.704 8.92078 23.0789C9.2957 23.4538 9.90357 23.4538 10.2785 23.0789L8.92078 21.7213ZM16.6784 16.6789C17.0533 16.304 17.0533 15.6962 16.6784 15.3213C16.3035 14.9464 15.6958 14.9464 15.3208 15.3213L16.6784 16.6789ZM15.3208 15.3213C14.9459 15.6962 14.9459 16.304 15.3208 16.6789C15.6958 17.0538 16.3035 17.0538 16.6784 16.6789L15.3208 15.3213ZM23.0784 10.279C23.4533 9.90406 23.4533 9.29618 23.0784 8.92127C22.7035 8.54642 22.0958 8.54642 21.7208 8.92127L23.0784 10.279ZM16.6784 15.3213C16.3035 14.9464 15.6958 14.9464 15.3208 15.3213C14.9459 15.6962 14.9459 16.304 15.3208 16.6789L16.6784 15.3213ZM21.7208 23.0789C22.0958 23.4538 22.7035 23.4538 23.0784 23.0789C23.4533 22.704 23.4533 22.0962 23.0784 21.7213L21.7208 23.0789ZM15.3208 16.6789C15.6958 17.0538 16.3035 17.0538 16.6784 16.6789C17.0533 16.304 17.0533 15.6962 16.6784 15.3213L15.3208 16.6789ZM10.2785 8.92127C9.90357 8.54642 9.2957 8.54642 8.92078 8.92127C8.54594 9.29618 8.54594 9.90406 8.92078 10.279L10.2785 8.92127ZM10.2785 23.0789L16.6784 16.6789L15.3208 15.3213L8.92078 21.7213L10.2785 23.0789ZM16.6784 16.6789L23.0784 10.279L21.7208 8.92127L15.3208 15.3213L16.6784 16.6789ZM15.3208 16.6789L21.7208 23.0789L23.0784 21.7213L16.6784 15.3213L15.3208 16.6789ZM16.6784 15.3213L10.2785 8.92127L8.92078 10.279L15.3208 16.6789L16.6784 15.3213Z" fill="#FF0020" />
        </svg>
    </button>
    <h2>Profil de <span><?= $_SESSION['first_name'] . " " . $_SESSION['last_name'] ?></span></h2>
    <div class="user-info">
        <h3>Nom :</h3>
        <p><?= $_SESSION['last_name'] ?></p>
    </div>
    <div class="user-info">
        <h3>Prénom :</h3>
        <p><?= $_SESSION['first_name'] ?></p>
    </div>
    <div class="user-info">
        <h3>Email :</h3>
        <p><?= $_SESSION['email'] ?></p>
    </div>
    <div class="user-info">
        <h3>Date de Naissance :</h3>
        <p><?= $formatedBirthdate ?></p>
    </div>
    <button id="password-change">Changer votre mot de passe</button>
    <a id="user-logout" href="./logout.php">
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M6.42265 7.25581L4.51181 9.16665H14.1668C14.3878 9.16665 14.5998 9.25444 14.7561 9.41072C14.9124 9.567 15.0001 9.77897 15.0001 9.99998C15.0001 10.221 14.9124 10.433 14.7561 10.5892C14.5998 10.7455 14.3878 10.8333 14.1668 10.8333H4.51181L6.42265 12.7441C6.50224 12.821 6.56572 12.913 6.6094 13.0146C6.65307 13.1163 6.67606 13.2257 6.67702 13.3363C6.67798 13.447 6.6569 13.5567 6.615 13.6591C6.5731 13.7615 6.51122 13.8546 6.43298 13.9328C6.35473 14.0111 6.26169 14.0729 6.15928 14.1148C6.05686 14.1567 5.94713 14.1778 5.83648 14.1769C5.72583 14.1759 5.61648 14.1529 5.51481 14.1092C5.41314 14.0656 5.32119 14.0021 5.24431 13.9225L1.91098 10.5891C1.75475 10.4329 1.66699 10.221 1.66699 9.99998C1.66699 9.77901 1.75475 9.56709 1.91098 9.41081L5.24431 6.07748C5.32119 5.99789 5.41314 5.9344 5.51481 5.89073C5.61648 5.84705 5.72583 5.82407 5.83648 5.8231C5.94713 5.82214 6.05686 5.84323 6.15928 5.88513C6.26169 5.92703 6.35473 5.98891 6.43298 6.06715C6.51122 6.14539 6.5731 6.23844 6.615 6.34085C6.6569 6.44327 6.67798 6.553 6.67702 6.66365C6.67606 6.7743 6.65307 6.88365 6.6094 6.98532C6.56572 7.08699 6.50224 7.17894 6.42265 7.25581ZM17.5001 0.833313H10.8335C10.6125 0.833313 10.4005 0.92111 10.2442 1.07739C10.0879 1.23367 10.0001 1.44563 10.0001 1.66665C10.0001 1.88766 10.0879 2.09962 10.2442 2.2559C10.4005 2.41218 10.6125 2.49998 10.8335 2.49998H16.6668V17.5H10.8335C10.6125 17.5 10.4005 17.5878 10.2442 17.7441C10.0879 17.9003 10.0001 18.1123 10.0001 18.3333C10.0001 18.5543 10.0879 18.7663 10.2442 18.9226C10.4005 19.0789 10.6125 19.1666 10.8335 19.1666H17.5001C17.7212 19.1666 17.9331 19.0789 18.0894 18.9226C18.2457 18.7663 18.3335 18.5543 18.3335 18.3333V1.66665C18.3335 1.44563 18.2457 1.23367 18.0894 1.07739C17.9331 0.92111 17.7212 0.833313 17.5001 0.833313Z" fill="white" />
        </svg>
        Déconnexion</a>
</aside>

<main id="profil">
    <h2>Vos réservation <span>(<?= count($reservationList) ?>)</span></h2>
    <div class="container-profil-reservation">
        <?php foreach ($reservationList as $reservation) {
            $reservatinDateTime = new DateTime($reservation['time_slot']);
            $formatedDate = $reservatinDateTime->format('d F H:i');
            $formatedDate = strtr($formatedDate, $moisFrancais)
        ?>
            <div class="reservation" data-comment-id="<?= $reservation['comment_id'] ?>" data-film-id="<?= $reservation['film_id'] ?>">
                <div class="reservation-description">
                    <img src="<?= "../../../public/images_film/" . $reservation['image'] ?>" alt="Film <?= $reservation['title'] ?>">
                    <div class="reservation-info">
                        <h3><?= $reservation['title'] ?></h3>
                        <h4><?= $formatedDate ?></h4>
                        <p>Cinema <?= $reservation['cinema_name'] ?></p>
                        <p>Salle <?= $reservation['room_name'] ?> <span><?= $reservation['language'] ?></span></p>
                    </div>
                </div>
                <div class="reservation-actions">
                    <?php if ($currentDate < $reservatinDateTime) { ?>
                        <p>En cours</p>
                        <?php } else {
                        if ($reservation['comment_notation'] == null) { ?>
                            <button class="reservation-rating-toggle">Noter ce film <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_60_349)">
                                        <path d="M9.9987 2.33334L12.6654 7.33334L18.9987 8.33334L14.6654 12.3333L15.332 18.3333L9.66536 15.6667L4.66536 18.3333L4.9987 12.3333L1.33203 8L6.9987 7.33334L9.9987 2.33334Z" fill="#FF0020" stroke="black" />
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.99903 0.625C10.1726 0.624889 10.3428 0.672977 10.4907 0.763907C10.6386 0.854836 10.7583 0.985036 10.8365 1.14L13.4165 6.2575L19.194 7.085C19.3682 7.10984 19.532 7.18321 19.6664 7.29673C19.8009 7.41024 19.9007 7.55931 19.9544 7.72688C20.0082 7.89446 20.0136 8.07377 19.9702 8.24431C19.9268 8.41486 19.8363 8.56974 19.709 8.69125L15.5403 12.6663L16.5228 18.2763C16.5528 18.4481 16.5343 18.625 16.4693 18.7869C16.4043 18.9489 16.2954 19.0894 16.1548 19.1928C16.0143 19.2962 15.8477 19.3584 15.6737 19.3722C15.4998 19.3861 15.3254 19.3511 15.1703 19.2713L9.99903 16.6088L4.82778 19.2713C4.67263 19.3511 4.49828 19.3861 4.32434 19.3722C4.1504 19.3584 3.98378 19.2962 3.84323 19.1928C3.70268 19.0894 3.59377 18.9489 3.52877 18.7869C3.46376 18.625 3.44524 18.4481 3.47528 18.2763L4.45778 12.665L0.289032 8.69C0.162111 8.56844 0.071915 8.41365 0.0287359 8.24329C-0.0144432 8.07293 -0.00886687 7.89386 0.0448287 7.72652C0.0985243 7.55918 0.198177 7.4103 0.332416 7.29687C0.466656 7.18343 0.630076 7.11002 0.804032 7.085L6.58153 6.2575L9.16153 1.14C9.23976 0.985036 9.35949 0.854836 9.50736 0.763907C9.65523 0.672977 9.82544 0.624889 9.99903 0.625ZM9.99903 3.645L8.03653 7.5375C7.96853 7.67246 7.8689 7.78898 7.74615 7.87712C7.62339 7.96527 7.48115 8.02244 7.33153 8.04375L2.98153 8.66625L6.11528 11.6538C6.22666 11.7604 6.31002 11.8928 6.35799 12.0393C6.40596 12.1858 6.41705 12.3419 6.39028 12.4938L5.64778 16.7388L9.57028 14.7188C9.70291 14.6505 9.8499 14.615 9.99903 14.615C10.1482 14.615 10.2952 14.6505 10.4278 14.7188L14.3503 16.7388L13.6065 12.4938C13.5799 12.3418 13.5912 12.1857 13.6394 12.0391C13.6876 11.8926 13.7712 11.7602 13.8828 11.6538L17.0165 8.66625L12.6665 8.04375C12.5171 8.02225 12.3751 7.965 12.2526 7.87686C12.1301 7.78872 12.0307 7.6723 11.9628 7.5375L9.99903 3.645Z" fill="#FF0020" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_60_349">
                                            <rect width="20" height="20" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>

                            </button>
                        <?php } else { ?>
                            <button data-rating="<?= $reservation['comment_notation'] ?>" class="reservation-rating-toggle">Modifier votre note <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.6671 6.66667H15.8338V2.5M15.5916 13.6307C14.815 14.8265 13.6756 15.7418 12.3406 16.2422C11.0056 16.7427 9.54515 16.802 8.17391 16.4114C6.8027 16.0208 5.59307 15.2011 4.72217 14.0722C3.85126 12.9434 3.36531 11.565 3.33545 10.1396C3.30559 8.71408 3.73317 7.31667 4.55605 6.15234C5.37891 4.98801 6.55343 4.11833 7.90708 3.67066C9.26073 3.22297 10.7224 3.22083 12.0772 3.66496C13.4321 4.10909 14.6088 4.97579 15.4347 6.13797" stroke="#FF0020" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                        <?php }
                        if ($reservation['comment_text'] == null) { ?>
                            <button class="btn-review">Laisser une critique <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13.9417 18.5463C14.4188 18.5463 14.6867 18.2031 14.6867 17.6841V15.2483H15.6242C17.5578 15.2483 18.8636 13.9258 18.8636 11.9169V4.65961C18.8636 2.64229 17.5578 1.45368 15.6242 1.45368H4.37416C2.36523 1.45368 1.13477 2.65068 1.13477 4.65961V11.9169C1.13477 13.9174 2.36523 15.2483 4.37416 15.2483H9.9573L12.9791 18.0106C13.3725 18.3789 13.6069 18.5463 13.9417 18.5463Z" fill="#FF0020" />
                                </svg>
                            </button>

                        <?php } else { ?>
                            <button data-review="<?= $reservation['comment_text'] ?>" class="btn-review">Modifier votre critique <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12.9165 4.58328L15.2735 6.9403M2.5 17.4997L2.53954 17.2229C2.67947 16.2435 2.74943 15.7537 2.90857 15.2965C3.04979 14.8907 3.2427 14.5049 3.48255 14.1486C3.75284 13.7469 4.10266 13.3971 4.80228 12.6975L14.5089 2.9908C15.1598 2.33992 16.2151 2.33992 16.866 2.9908C17.5168 3.64167 17.5168 4.69695 16.866 5.34782L6.9812 15.2326C6.34649 15.8673 6.02914 16.1847 5.66767 16.437C5.34682 16.661 5.00078 16.8466 4.63665 16.9899C4.22643 17.1514 3.78646 17.2402 2.90661 17.4177L2.5 17.4997Z" stroke="#FF0020" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                    <?php }
                    } ?>
                </div>
            </div>
        <?php  } ?>
    </div>
    <div class="recomendation">
        <h2>Film qui pourrait vous plaire</h2>
        <div class="container-recomendation-film">
            <?php foreach ($reco as $film) { ?>

                <a href="../film/infos-film.php?id_film=<?= $film['id'] ?>">
                    <img src="<?= "../../../public/images_film/" . $film['image'] ?>" alt="film <?= $film['title'] ?>">
                    <p>Recommandé à <span><?= $film['nb_sub_reco'] ?>0%</span></p>
                </a>
            <?php } ?>

        </div>
    </div>
</main>
<?php require_once __DIR__ . "/../../../src/views/footer.html.php" ?>