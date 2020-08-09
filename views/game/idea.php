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

        <div id="app">
            <autocomplete></autocomplete>
        </div>
        <template id="tag">
            <li :id="'tag-'+tag.id" class="li_tags">
                <span class="a_tag">{{ tag.value }}</span>
                <a href="" @click.prevent='onTagClick' class="del" :id="'del_'+tag.id"><strong>&times;</strong></a>
                <input type="hidden" :name="'tag['+tag.value+']'" :value="tag.id">
            </li>
        </template>
        <template id="autocomplete">
            <div id="boxTags">
                <ul id="ulTags" style="clear:both;">
                    <div class="form-group field-idea-text">
                        <label for="idea-tags">Теги</label>
                        <div>
                            <tag v-for="(tag, i) in arrayTags" :key="i" :tag="tag" @remove-tag="onRemoveTag"></tag>
                        </div>
                        <input type="text" id="idea-tags" class="form-control" autocomplete="off"
                               @input="onChange" v-model="search" @keyup.down="onArrowDown"
                               @keyup.up="onArrowUp" @keyup.enter="onEnter" @keydown.enter="preventSubmit"
                               @keyup.space="onSpace">
                        <li id="newTagInput">
                            <div class="autocomplete">
                                <ul id="autocomplete-results" v-show="isOpen" class="autocomplete-results">
                                    <li class="loading" v-if="isLoading">
                                        Loading results...
                                    </li>
                                    <li v-else v-for="(result, i) in results" :key="i" @click="setResult(result)"
                                        class="autocomplete-result" :class="{ 'is-active': i === arrowCounter }">
                                        {{ result.value }}
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <small class="form-text text-muted">Введите теги через пробел (после каждого тега вводите пробел или выбирайте из выпадающего списка)</small>
                    </div>
                </ul>
            </div>
        </template>
        <script>
Vue.component('tag',{
    template: "#tag",
    props: ['tag'],
    methods:{
        onTagClick(){
            this.$emit("remove-tag",this.tag.id);
        }
    }
});
Vue.component('autocomplete',{
    template: "#autocomplete",
    data() {
        return {
            isOpen: false,
            results: [],
            search: "",
            isLoading: false,
            arrowCounter: -1,
            arrayTags: [],
            maxId: -1,
        };
    },
    methods: {
        onRemoveTag: function(id) {
            i=0;
            while (i<this.arrayTags.length && this.arrayTags[i].id!==id)i++;
            if(i<this.arrayTags.length && this.arrayTags[i].id===id){
                this.arrayTags.splice(i, 1);
            }
        },
        onChange(e){
            if(e.data === ' '){
                search = this.search.trim();
                tag = {'id': this.maxId, 'value': search};
                this.maxId = this.maxId - 1;
                this.addTag(tag);
                return;
            }
            if((e.data === null || e.data.trim() !== '') && this.search.trim() !== '') {
                var vm = this;
                vm.isLoading = true;
                axios.get('<?=Url::to(['game/gettags'])?>?term=' + vm.search.trim())
                    .then(function (response) {
                        vm.results = [];
                        answers = response.data;
                        for (var i = 0; i < answers.length; i++) {
                            vm.results.push({'id': answers[i].id, 'value': answers[i].value});
                        }
                        if (answers.length > 0) vm.isOpen = true;
                    })
                    .catch(function (error) {
                        console.log('Ошибка! ' + error);
                    })
                    .then(function () {
                        vm.isLoading = false;
                    })
            }else{
                this.isLoading = false;
                this.isOpen = false;
            }
        },
        addTag(tag){
            if(tag.value.trim()!=='') {
                i = 0;
                addFlag = true;
                while (i < this.arrayTags.length && this.arrayTags[i].value !== tag.value) i++;
                if (i < this.arrayTags.length && this.arrayTags[i].value === tag.value) addFlag = false;
                if (addFlag) {
                    i = 0;
                    while (i < this.results.length && this.results[i].value !== tag.value){
                        i++;
                    }
                    if (i < this.results.length && this.results[i].value === tag.value){
                        tag.id=this.results[i].id;
                    }
                    this.arrayTags.push(tag);
                }
                this.isOpen = false;
                this.arrowCounter = -1;
                this.search = '';
                this.results = [];
            }
        },
        setResult(result) {
            this.addTag(result);
        },
        onArrowDown(evt) {
            if (this.arrowCounter < this.results.length-1) {
                this.arrowCounter = this.arrowCounter + 1;
            }
        },
        onArrowUp() {
            if (this.arrowCounter > 0) {
                this.arrowCounter = this.arrowCounter - 1;
            }
        },
        onEnter() {
            if(this.results.length>0) {
                if(this.arrowCounter===-1)this.arrowCounter=0;
                this.setResult(this.results[this.arrowCounter]);
            }
        },
        handleClickOutside(e) {
            if (!this.$el.contains(e.target)) {
                this.isOpen = false;
                this.arrowCounter = -1;
                this.results = [];
            }
        },
        preventSubmit: function(e){
            e.preventDefault();
        }
    },
    mounted() {
        document.addEventListener("click", this.handleClickOutside);
    },
    destroyed() {
        document.removeEventListener("click", this.handleClickOutside);
    }
});

new Vue({
    el: "#app",
    name: "app",
});
        </script>

    </div>
    <div class="box-footer">
        <?= Html::submitButton('Создать!', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>