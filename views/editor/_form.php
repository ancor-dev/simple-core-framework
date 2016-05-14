<?php
/**
 * Created by Anton Korniychuk <ancor.dev@gmail.com>.
 */
use core\Core;
use models\PageORM;

/* @var $this Core */
/* @var $model PageORM */
?>

<form class="form-horizontal" method="POST">
    <?php if ($model->isNew()) : ?>
        <div class="form-group<?= $model->getError('name') ? ' has-error' : '' ?>">
            <label for="inputName" class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="inputName" name="Page[name]" placeholder="Page name" value="<?= $model->name ?>">
            </div>
            <?php if ($model->getError('name')) : ?>
                <div class="help-block col-sm-10 col-sm-offset-2"><?= $model->getError('name') ?></div>
            <?php endif ?>
        </div>
    <?php endif ?>
    <div class="form-group<?= $model->getError('title') ? ' has-error' : '' ?>">
        <label for="inputTitle" class="col-sm-2 control-label">Title</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="inputTitle" name="Page[title]" placeholder="Page title" value="<?= $model->title ?>">
        </div>
        <?php if ($model->getError('title')) : ?>
            <div class="help-block col-sm-10 col-sm-offset-2"><?= $model->getError('title') ?></div>
        <?php endif ?>
    </div>
    <div class="form-group<?= $model->getError('description') ? ' has-error' : '' ?>">
        <label for="inputDescription" class="col-sm-2 control-label">Description</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="inputDescription" name="Page[description]" placeholder="Description meta tag" value="<?= $model->description ?>">
        </div>
        <?php if ($model->getError('description')) : ?>
            <div class="help-block col-sm-10 col-sm-offset-2"><?= $model->getError('description') ?></div>
        <?php endif ?>
    </div>
    <div class="form-group<?= $model->getError('keywords') ? ' has-error' : '' ?>">
        <label for="inputKeywords" class="col-sm-2 control-label">Keywords</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="inputKeywords" name="Page[keywords]" placeholder="Keywords meta tag" value="<?= $model->keywords ?>">
        </div>
        <?php if ($model->getError('keywords')) : ?>
            <div class="help-block col-sm-10 col-sm-offset-2"><?= $model->getError('keywords') ?></div>
        <?php endif ?>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?php if ($model->isNew()) : ?>
                <button type="submit" class="btn btn-default btn-primary">Create</button>
            <?php else : ?>
                <button type="submit" class="btn btn-default btn-primary">Update</button>
            <?php endif ?>
        </div>
    </div>
</form>