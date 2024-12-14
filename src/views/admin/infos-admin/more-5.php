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
<table>
    <thead>
        <tr>
            <th>Auteur</th>
            <th>Note</th>
            <th>Commentaire</th>
            <th>Like</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($comments as $comment) { ?>
            <tr>
                <td><?= $comment['first_name'] . " " . $comment['last_name'] ?></td>
                <td><?= $comment['notation'] ?></td>
                <td><?= $comment['comment'] ?></td>
                <td><?= $comment['like_count'] ?></td>
            </tr>
        <?php } ?>
</table>


<?php require_once "../admin-footer.html.php"; ?>