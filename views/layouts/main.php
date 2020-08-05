<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\assets\AppAsset;
use yii\helpers\Url;

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
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="container-lg mb-5">
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
            <div class="d-flex flex-column align-items-center">
            <? if(Yii::$app->user->isGuest){ ?>
            <a href="/">Главная</a><br>
            <? }else{ ?>
            <a href="/">Лента</a><br>
            <a href="<?=Url::to(['game/create'])?>">Создать</a><br>
            <a href="<?=Url::to(['site/logout'])?>">Выйти</a>
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