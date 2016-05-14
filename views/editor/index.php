<?php
/**
 * Created by Anton Korniychuk <ancor.dev@gmail.com>.
 */
use core\Core;
use models\PageORM;

/* @var $this  Core      */
/* @var $pages PageORM[] */
?>

<h1>Choose a page</h1>

<p>
    <a href="<?= $this->url->urlToRoute('admin', 'editor', 'create') ?>" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-plus"></i> Create page</a>
</p>

<table class="table">
    <thead>
    <tr>
        <th>#</th>
        <th>Name</th>
        <th>Title</th>
        <th>&nbsp;</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($pages as $page) : ?>
        <tr>
            <td><?= $page->id ?></td>
            <td><?= $page->name ?></td>
            <td><?= $page->title ?></td>
            <td class="text-right">
                <?php
                    $editUrl   = $this->url->urlToRoute('admin', 'editor', 'update', ['id' => $page->id]);
                    $deleteUrl = $this->url->urlToRoute('admin', 'editor', 'delete', ['id' => $page->id]);
                ?>
                <a href="<?= $editUrl ?>" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-pencil"></i></a>
                <a href="<?= $deleteUrl ?>" data-confirm class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></a>
            </td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>
