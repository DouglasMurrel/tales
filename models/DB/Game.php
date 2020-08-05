<?php

namespace app\models\DB;

use Yii;

/**
 * This is the model class for table "game".
 *
 * @property int $id
 * @property int|null $id_idea
 * @property int $multiplayer
 *
 * @property Idea $idea
 * @property GameUserRel[] $gameUserRels
 * @property User[] $users
 * @property Personage[] $personages
 */
class Game extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'game';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_idea', 'multiplayer'], 'integer'],
            [['id_idea'], 'exist', 'skipOnError' => true, 'targetClass' => Idea::className(), 'targetAttribute' => ['id_idea' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_idea' => 'Id Idea',
            'multiplayer' => 'Multiplayer',
        ];
    }

    /**
     * Gets query for [[Idea]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdea()
    {
        return $this->hasOne(Idea::className(), ['id' => 'id_idea']);
    }

    /**
     * Gets query for [[GameUserRels]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGameUserRels()
    {
        return $this->hasMany(GameUserRel::className(), ['id_game' => 'id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'id_user'])->viaTable('game_user_rel', ['id_game' => 'id']);
    }

    /**
     * Gets query for [[Personages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPersonages()
    {
        return $this->hasMany(Personage::className(), ['id_game' => 'id']);
    }
}
