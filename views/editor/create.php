<?php
/**
 * Created by Anton Korniychuk <ancor.dev@gmail.com>.
 * Template for create a product.
 */
use core\Core;
use models\PageORM;

/* @var $this Core */
/* @var $page PageORM */
?>

<div class="row">
    <h1 class="col-sm-offset-2 col-sm-10">Create new page</h1>
</div>
<div class="row">
    <p class="col-sm-offset-2 col-sm-10 text-muted">This action will not create real page. It only create rocord in database with information about title and meta tags.</p>
</div>

<?= $this->render('editor/_form', [
    'model' => $page,
]) ?>
