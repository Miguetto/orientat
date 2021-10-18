<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "votos".
 *
 * @property int $id
 * @property int|null $puntuacion
 * @property int $usuario_id
 * @property int $propuesta_id
 *
 * @property Propuestas $propuesta
 * @property Usuarios $usuario
 */
class Votos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'votos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['puntuacion', 'usuario_id', 'propuesta_id'], 'default', 'value' => null],
            [['puntuacion', 'usuario_id', 'propuesta_id'], 'integer'],
            [['usuario_id', 'propuesta_id'], 'required'],
            [['propuesta_id'], 'exist', 'skipOnError' => true, 'targetClass' => Propuestas::className(), 'targetAttribute' => ['propuesta_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'puntuacion' => 'Puntuacion',
            'usuario_id' => 'Usuario ID',
            'propuesta_id' => 'Propuesta ID',
        ];
    }

    /**
     * Gets query for [[Propuesta]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPropuesta()
    {
        return $this->hasOne(Propuestas::class, ['id' => 'propuesta_id']);
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
