<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
        html {
            height:100%;
        }
        body {
            height:100%;
            background-color: #BFC9CC;
        }
        .container-lg{
            background-color: white;
            height: 100%;
        }
        #top{
            height:50px;
        }
        @media (min-width: 960px) {
            .collapse.dont-collapse-lg {
                display: block;
                height: auto !important;
                visibility: visible;
            }
        }
        @media (min-width: 960px) {
            .dont-show-lg {
                display: none;
            }
        }
        .gamb-line {
            width: 36px;
            height: 5px;
            background-color: #000;
            margin: 5px 0;
            transition: 0.3s;
        }
        ul {
           padding: 0;
        }
    </style>
    <script src="/js/jquery-3.4.1.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="//stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>
<body>
<?php $this->beginBody() ?>
<div class="container-lg">
    <div class="row">
        <div class="col" id="top">
            <button class="btn btn-white mt-1 dont-show-lg has_tooltip" type="button" data-toggle="collapse" data-target="#left-panel" aria-expanded="false"
                    aria-controls="left-panel" title="Меню" data-placement="right">
                <div class="gamb-line"></div>
                <div class="gamb-line"></div>
                <div class="gamb-line"></div>
            </button>
            <? if(isset($this->blocks['char_button'])){ ?>
                <?=$this->blocks['char_button']?>
            <? } ?>
        </div>
    </div>
    <div class="row" id="main_container">
        <div class="col-2 collapse dont-collapse-lg" id="left-panel">
            <div class="d-flex flex-column align-items-center pt-3">
            <a href="/">Главная</a><br>
            <? if(!Yii::$app->user->isGuest){ ?>
            <a href="/logout">Выйти</a>
            <? } ?>
            </div>
        </div>
        <div class="col-10" id="main-panel">
            <?=$content?>
        </div>
        <? if(isset($this->blocks['char_panel'])){ ?>
            <?=$this->blocks['char_panel']?>
        <? } ?>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>