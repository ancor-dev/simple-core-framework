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
<!--        <th>#</th>-->
        <th>Name</th>
        <th>Title</th>
        <th>Description</th>
        <th>Key words</th>
        <th>&nbsp;</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($pages as $page) : ?>
        <tr>
<!--            <td><?= $page->id ?></td>-->
            <td><?= $page->name ?></td>
            <td style="min-width: 200px;"><?= $page->title ?></td>
            <td><?= $page->description ?></td>
            <td><?= $page->keywords ?></td>
            <td class="text-right">
                <?php
                    $editUrl   = $this->url->urlToRoute('admin', 'editor', 'update', ['id' => $page->id]);
                    $copyUrl   = $this->url->urlToRoute('admin', 'editor', 'copy', ['id' => $page->id]);
                    $deleteUrl = $this->url->urlToRoute('admin', 'editor', 'delete', ['id' => $page->id]);
                ?>
                <a href="<?= $editUrl ?>" class="btn btn-block btn-sm btn-default" title="Edit the page"><i class="glyphicon glyphicon-pencil"></i></a>
                <a href="<?= $copyUrl ?>" class="btn btn-block btn-sm btn-default" title="Make copy of the page"><i class="glyphicon glyphicon-copy"></i></a>
                <a href="<?= $deleteUrl ?>" class="btn btn-block btn-sm btn-danger" data-confirm title="Delete the page"><i class="glyphicon glyphicon-remove"></i></a>
            </td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>
