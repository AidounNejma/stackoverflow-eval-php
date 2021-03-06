<?php

require_once './src/View/includes/header.inc.php';

?>

<div class="d-flex my-4 px-2">
    <a href="?page=index"><i class="fas fa-home"></i> Home</a>
    <p class="px-2"> > </p>
    <p>Answers Dashboard</p>
</div>

<h1 class="text-center py-4">Answers Dashboard</h1>

<table class="table">
    <thead class="thead-dark">
        <tr>
            <?php foreach ($metas as $meta) : ?>
                <th scope="col"><?= $meta->COLUMN_NAME ?></th>
            <?php endforeach ?>
            <th scope="col">Edit</th>
            <th scope="col">Delete</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($answers as $answer) :?>
        <tr>
            <th scope="row"><?= $answer->getId() ?></th>
            <td><?= strlen($answer->getContent()) > 50 ? substr($answer->getContent(),0,50)."..." : $answer->getContent();?></td>
            <td><?= $answer->getStatus() ?></td>
            <td><?= $answer->created_at ?></td>
            <td><?= $answer->updated_at ?></td>
            <td><?= $answer->user_id ?></td>
            <td><?= $answer->question_id ?></td>
            <td><button class="btn btn-primary editAnswer" data-id="<?= $answer->getId() ?>"><i class="fas fa-edit"></i></button></td>
            <td><button class="btn btn-danger deleteAnswer" data-id="<?= $answer->getId() ?>"><i class="fas fa-eraser"></i></button></td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>



<?php

require_once './src/View/includes/footer.inc.php';

?>