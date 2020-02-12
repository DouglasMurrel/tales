<?php

namespace app\components;

use app\models\UserService;
use app\models\User;
use Yii;
use yii\authclient\ClientInterface;
use yii\helpers\ArrayHelper;

/**
 * AuthHandler handles successful authentication via Yii auth component
 */
class AuthHandler
{
    /**
     * @var ClientInterface
     */
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function handle()
    {
        $attributes = $this->client->getUserAttributes();
//        Yii::debug(print_r($attributes,1));
        $clientName = $this->client->name;
        $userService = UserService::findOne([
            'id_service_user'=>$attributes['id'],
            'service'=>$clientName
        ]);
        if($userService){
            $idUser = $userService->id_user;
            $user = User::findOne($idUser);
            if(!$user){
                $userService->delete();
            }else{
                Yii::$app->user->login($user, 3600*24*30);
            }
        }else{
            $userService = new UserService();
            $userService->id_service_user = $attributes['id'];
            $userService->service = $clientName;
            if(isset($attributes['email'])){
                $this->_register($userService,$attributes['email']);
            }elseif(isset($attributes['emails'][0])) {
                $this->_register($userService,$attributes['emails'][0]);
            }else{
                $this->_register($userService);
            }
        }
    }

    private function _register($userService,$email=null){
        if($email)$user = User::findByUsername($email);
        else $email = $userService->id_service_user.'@'.$userService->service;
        if(!$user){
            $user = new User();
            $user->email = $email;
            $user->password = Yii::$app->security->generatePasswordHash(microtime(true));
            $user->roles = 'user';
            $user->save();
        }
        $userService->id_user = $user->id;
        $userService->save();
        Yii::$app->user->login($user, 3600*24*30);
    }
}