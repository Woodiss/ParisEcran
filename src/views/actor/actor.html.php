<?php

use parisecran\Entity\Actor;
use parisecran\DBAL\Connector;

session_start();

require_once __DIR__ . "/../../../vendor/autoload.php";

$dbh = new Connector();

$actorModel = new Actor($dbh->dbConnector);
$allActors = $actorModel->getAllActors();
$favoriteActors = $actorModel->getFavoriteActors();
$versatileActors = $actorModel->getVersatileActors();

// Déclaration de la variable pour le titre de la page
$titlePage = "Acteurs";
require_once __DIR__ . "/../../../src/views/header.html.php";

?>
<main id="actors">
    <section class="actors">
        <h2>Les acteurs préférés des spectateurs
            <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M15 17.5V21.25M15 17.5C11.9763 17.5 9.45411 15.3528 8.87502 12.5M15 17.5C18.0237 17.5 20.5459 15.3528 21.125 12.5M15 21.25C16.1625 21.25 16.7437 21.25 17.2206 21.3777C18.5146 21.7245 19.5255 22.7354 19.8723 24.0294C20 24.5062 20 25.0875 20 26.25H10C10 25.0875 10 24.5062 10.1278 24.0294C10.4745 22.7354 11.4853 21.7245 12.7794 21.3777C13.2563 21.25 13.8375 21.25 15 21.25ZM8.87502 12.5H8.75H8.4375C7.56628 12.5 7.13066 12.5 6.76841 12.4279C5.28083 12.132 4.11795 10.9692 3.82205 9.48159C3.75 9.11934 3.75 8.68372 3.75 7.8125C3.75 7.52209 3.75 7.37689 3.77401 7.25614C3.87265 6.76028 4.26027 6.37265 4.75614 6.27401C4.87689 6.25 5.02209 6.25 5.3125 6.25H8.75M8.87502 12.5C8.79304 12.0961 8.75 11.6781 8.75 11.25V5.71429C8.75 5.04789 8.75 4.7147 8.87379 4.45765C8.99665 4.20251 9.20251 3.99665 9.45765 3.87379C9.7147 3.75 10.0479 3.75 10.7143 3.75H19.2858C19.9521 3.75 20.2853 3.75 20.5424 3.87379C20.7975 3.99665 21.0034 4.20251 21.1262 4.45765C21.25 4.7147 21.25 5.04789 21.25 5.71429V11.25C21.25 11.6781 21.207 12.0961 21.125 12.5M21.125 12.5H21.25H21.5625C22.4338 12.5 22.8694 12.5 23.2316 12.4279C24.7191 12.132 25.882 10.9692 26.178 9.48159C26.25 9.11934 26.25 8.68372 26.25 7.8125C26.25 7.52209 26.25 7.37689 26.226 7.25614C26.1274 6.76028 25.7398 6.37265 25.2439 6.27401C25.1231 6.25 24.9779 6.25 24.6875 6.25H21.25" stroke="#FF0020" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </h2>
        <div class="container-actors">
            <?php foreach ($favoriteActors as $actor) { ?>
                <div class="actor" data-name="<?= $actor['firstname'] . " " . $actor['lastname'] ?>">
                    <img src="../../../public/images_film/anonymous-profile.jpg" alt="">
                    <h3><?= $actor['firstname'] . " " . $actor['lastname'] ?></h3>
                    <div class="actor-rating">
                        <?php for ($i = 0; $i < 5; $i++) {
                            if ($i < $actor['average_notation']) { ?>
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
                                </svg>
                            <?php  } else { ?>
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
                                </svg>
                        <?php  }
                        } ?>
                    </div>
                    <a href="#">En savoir plus</a>
                </div>
            <?php } ?>
        </div>
    </section>
    <section class="actors">
        <h2>Voir les collaborateurs d'un artiste <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M27.5 9.99994H25M25 9.99994H23.75C21.25 7.50216 17.5 4.99967 15 7.49994M25 9.99994V19.9999M15 7.49994L11.2494 11.252C11.1502 11.3512 11.1006 11.4008 11.0607 11.4447C10.1937 12.3986 10.1941 13.8552 11.0616 14.8087C11.1015 14.8526 11.1512 14.9022 11.2504 15.0014C11.3496 15.1005 11.3992 15.1501 11.4431 15.19C12.3968 16.0566 13.853 16.0565 14.8064 15.1895C14.8502 15.1496 14.8999 15.1 14.999 15.0009L16.2495 13.7504M15 7.49994C12.5 4.99967 8.75 7.50225 6.25 10H5M25 19.9999V23.7499H27.5M25 19.9999H21.4645M5 10H2.5M5 10V19.9999M5 19.9999H7.5L7.97746 20.9549C8.61954 22.239 10.3886 22.3985 11.25 21.2499C11.9316 21.9315 12.2723 22.2722 12.64 22.4545C13.3394 22.801 14.1606 22.801 14.86 22.4545C15.2276 22.2722 15.5685 21.9315 16.25 21.2499L16.875 21.8749C16.9745 21.9744 17.0244 22.0242 17.0684 22.0644C18.022 22.9311 19.478 22.9311 20.4316 22.0644C20.4756 22.0242 20.5255 21.9744 20.625 21.8749C20.7245 21.7754 20.7744 21.7256 20.8144 21.6815C21.6811 20.728 21.6811 19.2719 20.8144 18.3184C20.7744 18.2742 20.7245 18.2245 20.625 18.1249L18.75 16.2499M5 19.9999V23.7499H2.5" stroke="#FF0020" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </h2>
        <select name="actor" id="actor-select">
            <option value="" selected disabled>Sélectionner un acteur</option>
            <?php foreach ($allActors as $actor) { ?>
                <option value="<?= $actor['casting_id'] ?>"><?= $actor['firstname'] . " " . $actor['lastname'] ?></option>
           <?php } ?>
        </select>
        <h4 id="title-actor-collabs">Acteurs <span>(0)</span></h4>
        <div id="container-actor-collabs" class="container-actors">
            <p>Veuillez sélectionner un acteur</p>
        </div>
    </section>
    <section class="actors">
        <h2>Acteurs multitâches</h2>
        <h4>Acteurs <span>(<?= count($versatileActors) ?>)</span></h4>
        <div class="container-actors">
            <?php foreach ($versatileActors as $actor) { 
                $actorRoles = explode(", ", $actor['roles_distincts'])
                ?>
                <div class="actor" data-name="<?= $actor['firstname'] . " " . $actor['lastname'] ?>">
                    <img src="../../../public/images_film/anonymous-profile.jpg" alt="">
                    <h3><?= $actor['firstname'] . " " . $actor['lastname'] ?></h3>
                    <ul>
                        <?php foreach ($actorRoles as $role) { ?>
                            <li><?= $role ?></li>
                       <?php } ?>
                    </ul>
                    <a href="#">En savoir plus</a>
                </div>
            <?php } ?>
        </div>
        </div>
    </section>
</main>

<?php require_once __DIR__ . "/../../../src/views/footer.html.php" ?>