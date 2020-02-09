<?php

namespace app\controllers;

use app\models\User;
use Composer\Util\Url;
use Yii;
use yii\bootstrap\ActiveForm;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\RegisterForm;
use app\models\RecoverForm;
use app\models\ResetForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            /*
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
            */
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $modelLogin = new LoginForm();
        $modelRegister = new RegisterForm();
        $modelRecover = new RecoverForm();
        return $this->render('index',['modelLogin' => $modelLogin,'modelRegister' => $modelRegister,'modelRecover' => $modelRecover,'active' => 'login']);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $modelLogin = new LoginForm();
        $modelRegister = new RegisterForm();
        $modelRecover = new RecoverForm();
        if ($modelLogin->load(Yii::$app->request->post()) && $modelLogin->login()) {
            return $this->goBack();
        }

        $modelLogin->password = '';
        return $this->render('index', [
            'modelLogin' => $modelLogin,
            'modelRegister' => $modelRegister,
            'modelRecover' => $modelRecover,
            'active' => 'login'
        ]);
    }

    /**
     * Register action.
     *
     * @return Response|string
     */
    public function actionRegister()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $modelLogin = new LoginForm();
        $modelRegister = new RegisterForm();
        $modelRecover = new RecoverForm();
        if ($modelRegister->load(Yii::$app->request->post()) && $modelRegister->register()) {
            return $this->goBack();
        }

        $modelRegister->password = '';
        $modelRegister->password2 = '';
        return $this->render('index', [
            'modelLogin' => $modelLogin,
            'modelRegister' => $modelRegister,
            'modelRecover' => $modelRecover,
            'active' => 'register'
        ]);
    }

    /**
     * Recover action.
     *
     * @return Response|array|string
     */
    public function actionRecover()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $modelLogin = new LoginForm();
        $modelRegister = new RegisterForm();
        $modelRecover = new RecoverForm();
        if (Yii::$app->request->isAjax && $modelRecover->load(Yii::$app->request->post()) && Yii::$app->request->post('ajax')=='recover-form') {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($modelRecover);
        }
        if ($modelRecover->load(Yii::$app->request->post())){
            if ($modelRecover->sendmail()) {
                return $modelRecover->confirmation(true);
            }else{
                return $modelRecover->confirmation(false);
            }
        }

        $modelLogin->password = '';
        return $this->render('index', [
            'modelLogin' => $modelLogin,
            'modelRegister' => $modelRegister,
            'modelRecover' => $modelRecover,
            'active' => 'recover'
        ]);
    }

    /**
     * Reset password action.
     *
     * @return Response|string
     */
    public function actionReset()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new ResetForm();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()) && Yii::$app->request->post('ajax')=='reset-form') {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        $hash = Yii::$app->request->get('hash');
        $email = Yii::$app->request->get('email');
        $hash1 = md5($hash.Yii::$app->params['salt']);
        $user = User::findByUsername($email);
        $hash2 = $user->passwordHash;
        if($hash1==$hash2){
            if ($model->load(Yii::$app->request->post())) {
                $model->email = $email;
                return $model->reset();
            }

            $model->password = '';
            return $this->render('reset', [
                'model' => $model,
                'email' => $email,
            ]);
        }

        return $this->goHome();
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
