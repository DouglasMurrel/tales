<?php

namespace app\models\DB;

use Yii;

/**
 * This is the model class for table "personage".
 *
 * @property int $id
 * @property string $name
 * @property int $id_game
 *
 * @property Game $game
 */
class Personage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'personage';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'id_game'], 'required'],
            [['id_game'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['id_game'], 'exist', 'skipOnError' => true, 'targetClass' => Game::className(), 'targetAttribute' => ['id_game' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'id_game' => 'Id Game',
        ];
    }

    /**
     * Gets query for [[Game]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGame()
    {
        return $this->hasOne(Game::className(), ['id' => 'id_game']);
    }
}
