<?php 

use parisecran\DBAL\Connector;
use parisecran\Entity\Comment;

require_once __DIR__ . '/../auth.php';

$dbh = new Connector();
$commentModel = new Comment($dbh->dbConnector);

$comments = $commentModel->MoreThanFiveLike();


$titlePage = "Commentaire like";
require_once "../admin-header.html.php";

?>
<h2>Commentaire avec plus de 5 likes</h2>
<table>
    <thead>
        <tr>
            <th>Auteur</th>
            <th>Note</th>
            <th>Commentaire</th>
            <th>Likes</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($comments as $comment) { ?>
            <tr>
                <td data-column-name="Auteur"><?= $comment['first_name'] . " " . $comment['last_name'] ?></td>
                <td data-column-name="Note"><?= $comment['notation'] ?></td>
                <td data-column-name="Commentaire" data-content="<?= $comment['comment'] ?>" class="text-collapse"><?= tronquerTexte($comment['comment'], 200) ?></td>
                <td data-column-name="Likes"><?= $comment['like_count'] ?></td>
            </tr>
        <?php } ?>
</table>


<?php require_once "../admin-footer.html.php"; ?>