<?php

namespace app\controllers;

use app\models\DB\Idea;
use app\models\DB\Tag;
use Yii;
use yii\db\Expression;
use yii\helpers\Url;

class GameController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCreate(){
        $idea = new Idea();

        if($idea->load(Yii::$app->request->post()) && $idea->validate()){
            $idea->dt = new Expression('NOW()');
            $idea->save(false);
            return $this->redirect(Url::to(['/']));
        }

        return $this->render('idea',[
            'idea' => $idea,
            'id_user' => Yii::$app->user->id,
            'tags' => $idea->tags,
            'tagList' => Tag::find()->select(['name as value', 'name as label','id as id'])->asArray()->all(),
        ]);
    }

    /**
     * @return false|string
     */
    public function actionGettags(){
        $tagList = [];
        if(Yii::$app->request->isAjax && Yii::$app->request->get('term')){
            $term = Yii::$app->request->get('term');
            $tagList = Tag::find()
                ->where(['like','name',$term])
                ->select(['name as value', 'name as label','id as id'])
                ->asArray()
                ->all();
        }
        return json_encode($tagList);
    }

}
