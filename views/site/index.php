<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Главная страница';
?>
<div class="site-index">

    <div class="body-content">
        <div class="row">
            <div class="col-lg-5">
                <?php
                if(Yii::$app->user->isGuest) {
                    $form = ActiveForm::begin(['id' => 'login-form','action'=>'login']);
                    ?>

                    <?= $form->field($model, 'email')->input('email'); ?>
                    <?= $form->field($model, 'password', ['inputOptions' => ['autocomplete' => 'new-password']])->passwordInput() ?>

                    <div class="form-group">
                        <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                    </div>

                    <?php
                    ActiveForm::end();
                }
                ?>
            </div>
        </div>
    </div>
</div>
