<?php
/**
 * Created by Anton Korniychuk <ancor.dev@gmail.com>.
 */
use core\Core;
use models\PageORM;

/* @var $this Core */
/* @var $page PageORM */
?>

<div class="row">
    <h1 class="col-sm-10 col-sm-offset-2">Update a record</h1>
</div>

<?= $this->render('editor/_form', [
    'model' => $page,
]) ?>
