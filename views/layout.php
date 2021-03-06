<?php
/**
 * Main layout
 * Created by Anton Korniychuk <ancor.dev@gmail.com>.
 */
use core\Core;

/* @var $this    \core\Core */
/* @var $content string  main page content */
/* @var $title   string  page title */
/* @var $brand   string  menu brand label */
/* @var $menu    array[] menu items */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?= $title ?></title>

    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <!-- Optional theme -->
<!--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- CMS Styles -->
    <link rel="stylesheet" href="/admin/styles.css">
</head>
<body>

<nav class="navbar navbar-fixed-top navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?= $this->url->url('admin') ?>"><?= $brand ?></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <?php foreach ($menu['left'] as $item) : ?>
                    <li class="<?= isset($item['active']) && $item['active'] ? 'active' : '' ?>">
                        <a href="<?= $item['url'] ?>"><?= $item['name'] ?></a>
                    </li>
                <?php endforeach ?>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <?php foreach ($menu['right'] as $item) : ?>
                    <li class="<?= isset($item['active']) && $item['active'] ? 'active' : '' ?>">
                        <a href="<?= $item['url'] ?>"><?= $item['name'] ?></a>
                    </li>
                <?php endforeach ?>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

<div class="container main-content">

    <div class="">
        <?php foreach (Core::$app->session->flash->getAll() as $msg) : ?>
            <div class="alert alert-<?= $msg->type ?> alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong><?= ucfirst($msg->type) ?>!</strong> <?= $msg->text ?>
            </div>
        <?php endforeach ?>
    </div>

    <?= $content ?>
</div>

<nav class="navbar navbar-default navbar-fixed-bottom footer">
    <div class="container">
        <span>Copyright &copy; <?= date('Y') ?></span>
        <span class="text-muted pull-right">Author: <a href="//www.facebook.com/ancor.root">Anton Korniychuk</a></span>
    </div>
</nav>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<!-- my scripts -->
<script src="/admin/main.js"></script>
</body>
</html>
