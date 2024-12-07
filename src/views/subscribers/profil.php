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

$birthdate = new DateTime($_SESSION['birthdate']);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Lobster&family=Manrope:wght@200..800&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../../../public/css/profil.css">

    <title>Document</title>
</head>

<body>

    <div class="container">

        <div class="spec">
            <h3>Profil de <span style="color: red;"><?= $_SESSION['first_name'] . ' ' . $_SESSION['last_name'] ?></span></h3>
            <div>
                <span style="font-weight: bold;">Nom :</span>
                <span><?= $_SESSION['last_name'] ?></span>
            </div>
            <div>
                <span style="font-weight: bold;">Prénom :</span>
                <span><?= $_SESSION['first_name'] ?></span>
            </div>
            <div>
                <span style="font-weight: bold;">Email :</span>
                <span><?= $_SESSION['email'] ?></span>
            </div>
            <div>
                <span style="font-weight: bold;">Date de naissance :</span>
                <span><?= $birthdate->format('d F Y') ?></span>
            </div>
            <a href="changerMDP">Changer votre mot de passe</a>

            <form action="" method="post">
                <button type="submit" name="deco" value="true">Déconnexion</button>
            </form>
        </div>
               

        <div class="historique">
            <div>
                <h3>Vos réservations <span style="color: red;">(<?= count($reservationList) ?>)</span></h3>
                <?php foreach ($reservationList as $reservation) { ?>
                    <div class="reserv">
                        <img src="<?= "../../../public/images_film/" . $reservation['image'] ?>" alt="Film <?= $reservation['title'] ?>">
                        <div>
                            <h3><?= $reservation['title'] ?></h3>
                            <p><?php echo date('d F Y', strtotime($reservation['time_slot'])); ?></p>
                            <p>Cinema <?= $reservation['cinema_name'] ?></p>
                            <p>Salle <?= $reservation['room_name'] ?></p>
                        </div>
                        <?php if ($reservation['comment_id'] == null)  {?>
                            <div class="notation">
                                <p>Notez ce film <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_24_1239)">
                                        <path d="M7.99998 1.86667L10.1333 5.86667L15.2 6.66667L11.7333 9.86667L12.2666 14.6667L7.73332 12.5333L3.73332 14.6667L3.99998 9.86667L1.06665 6.4L5.59998 5.86667L7.99998 1.86667Z" fill="#FF0020" stroke="black" />
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.99971 0.5C8.13859 0.499911 8.27476 0.538382 8.39306 0.611125C8.51135 0.683869 8.60713 0.788029 8.66971 0.912L10.7337 5.006L15.3557 5.668C15.4951 5.68787 15.6261 5.74657 15.7336 5.83738C15.8412 5.92819 15.9211 6.04745 15.964 6.18151C16.007 6.31557 16.0114 6.45902 15.9767 6.59545C15.942 6.73189 15.8695 6.85579 15.7677 6.953L12.4327 10.133L13.2187 14.621C13.2427 14.7585 13.2279 14.9 13.1759 15.0295C13.1239 15.1591 13.0368 15.2715 12.9244 15.3543C12.8119 15.437 12.6786 15.4867 12.5395 15.4978C12.4003 15.5088 12.2608 15.4809 12.1367 15.417L7.99971 13.287L3.86271 15.417C3.7386 15.4809 3.59911 15.5088 3.45996 15.4978C3.32081 15.4867 3.18751 15.437 3.07507 15.3543C2.96263 15.2715 2.87551 15.1591 2.8235 15.0295C2.7715 14.9 2.75668 14.7585 2.78071 14.621L3.56671 10.132L0.231714 6.952C0.130177 6.85475 0.0580203 6.73092 0.023477 6.59463C-0.0110663 6.45834 -0.00660522 6.31509 0.0363513 6.18121C0.0793077 6.04734 0.15903 5.92824 0.266421 5.83749C0.373813 5.74675 0.504549 5.68802 0.643714 5.668L5.26571 5.006L7.32971 0.912C7.3923 0.788029 7.48808 0.683869 7.60637 0.611125C7.72467 0.538382 7.86084 0.499911 7.99971 0.5ZM7.99971 2.916L6.42971 6.03C6.37531 6.13797 6.29561 6.23118 6.19741 6.3017C6.0992 6.37222 5.98541 6.41795 5.86571 6.435L2.38571 6.933L4.89271 9.323C4.98181 9.40829 5.0485 9.51423 5.08688 9.63145C5.12525 9.74866 5.13413 9.87354 5.11271 9.995L4.51871 13.391L7.65671 11.775C7.76282 11.7204 7.8804 11.692 7.99971 11.692C8.11903 11.692 8.23661 11.7204 8.34272 11.775L11.4807 13.391L10.8857 9.995C10.8644 9.87345 10.8735 9.74853 10.912 9.63131C10.9506 9.51409 11.0174 9.40819 11.1067 9.323L13.6137 6.933L10.1337 6.435C10.0142 6.4178 9.90061 6.372 9.80259 6.30149C9.70457 6.23098 9.62503 6.13784 9.57071 6.03L7.99971 2.916Z" fill="#FF0020" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_24_1239">
                                            <rect width="16" height="16" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg></p>
                                <p>Laisser une critique <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13.9417 18.5463C14.4188 18.5463 14.6867 18.2031 14.6867 17.6841V15.2483H15.6242C17.5578 15.2483 18.8636 13.9258 18.8636 11.9169V4.65961C18.8636 2.64229 17.5578 1.45368 15.6242 1.45368H4.37416C2.36523 1.45368 1.13477 2.65068 1.13477 4.65961V11.9169C1.13477 13.9174 2.36523 15.2483 4.37416 15.2483H9.9573L12.9791 18.0106C13.3725 18.3789 13.6069 18.5463 13.9417 18.5463Z" fill="#FF0020"/>
                                    </svg>
                                    </p>
                            </div>
                        <?php } else {?>
                            <div class="notation">
                                <p>modifier votre critique</p>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>

            <div class="reco-top">
                <h3>Film qui pourrait vous plaire</h3>
                <div class="reco">
                    <img src="../Image/Deva.jpg" alt="Deva"> <img src="../Image/Willex.jpg" alt="Willex">
                </div>
            </div>

        </div>

    </div>

</body>

</html>