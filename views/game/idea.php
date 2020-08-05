<?php

use app\components\MultipleInput;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\jui\AutoComplete;
use yii\web\JsExpression; ?>

<div class="value-form box box-primary">
    <?php $form = ActiveForm::begin(); ?>

    <div class="box-body table-responsive">

        <?= $form->field($idea, 'id_user')->hiddenInput(['value'=>$id_user])->label(false) ?>

        <?= $form->field($idea, 'text')->textarea(['rows' => 6]) ?>

        <?= $form->field($idea, 'adult')->checkbox()->hint("Текст идеи содержит материалы, которые не разрешается показывать детям") ?>

        <?= $form->field($idea, 'multiplayer')->checkbox() ?>

        <div id="boxTags">
            <input type="hidden" id="hiddenTags"/>
            <ul id="ulTags" style="clear:both;">
                <li id="newTagInput">
            <?= $form->field($idea, 'tagList')->widget(AutoComplete::classname(), [
            'clientOptions' => [
                'source' => Url::to(['game/gettags']),
                'select' => new JsExpression("function( event, ui ) {
   			        console.log(ui.item.label);
			        console.log(ui.item.id);
			     }")
            ]
        ])->label('Теги') ?>
                </li>
            </ul>
        </div>
        <script>
            var arrayTags = [""];	// Массив, который содержит метки
            var index = 0;

            // Удаление элемента из массива
            function removeByValue(arr, val) {
                for(var i=0; i<arr.length; i++) {
                    if(arr[i] == val) {
                        arr.splice(i, 1);
                        break;
                    }
                }
                index--;
            }

            // Удаление метки из списка
            function removeTag(el) {
                tag = $(el).prev().html();
                $("#tag-"+tag).remove();
                removeByValue(arrayTags, tag);
                $("#inputTag").focus();
            }

            $(document).ready(function() {
                var inputWidth = 16;

                // Вставка метки в список
                function insertTag(tag) {
                    var liEl = '<li id="tag-'+tag+'" class="li_tags">'+
                        '<span href="javascript://" class="a_tag">'+tag+'</span>&nbsp;'+
                        '<a href="" onclick="removeTag(this); return false;"'+
                        ' class="del" id="del_'+tag+'">&times;</strong></a>'+
                        '</li>';
                    return liEl;
                }

                $("#idea-taglist").focus().val("");
                $("#hiddenTags").val("");

                // Проверяем нажатие клавиши
                $("#idea-taglist").keydown(function(event) {
                    var textVal = jQuery.trim($(this).val()).toLowerCase();
                    var keyCode = event.which;

                    // Перемещаемся влево (нажата клавиша влево)

                    if ((47 < keyCode && keyCode < 106) || (keyCode == 32)) {

                        if (keyCode == 32 && (textVal != '')) {
                            // Пользователь создает новую метку
                            var isExist = jQuery.inArray(textVal, arrayTags);

                            if (isExist == -1) {
                                // Вставляем новую метку (видимый элемент)
                                $(insertTag(textVal)).insertBefore("#newTagInput");

                                // Вставляем новую метку в массив JavaScript
                                arrayTags[index] = textVal;
                                index++;
                            }

                            $("#idea-taglist").val("");
                        }
                    }
                });
            });
        </script>

    </div>
    <div class="box-footer">
        <?= Html::submitButton('Создать!', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>