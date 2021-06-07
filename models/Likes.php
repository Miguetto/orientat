<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "likes".
 *
 * @property int $id
 * @property int $usuario_id
 * @property int $recurso_id
 *
 * @property Recursos $recurso
 * @property Usuarios $usuario
 */
class Likes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'likes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_id', 'recurso_id'], 'required'],
            [['usuario_id', 'recurso_id'], 'default', 'value' => null],
            [['usuario_id', 'recurso_id'], 'integer'],
            [['recurso_id'], 'exist', 'skipOnError' => true, 'targetClass' => Recursos::class, 'targetAttribute' => ['recurso_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::class, 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'usuario_id' => 'Usuario',
            'recurso_id' => 'Recurso',
        ];
    }

    /**
     * Gets query for [[Recurso]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRecurso()
    {
        return $this->hasOne(Recursos::class, ['id' => 'recurso_id']);
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'usuario_id']);
    }
}
