<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "respuestas".
 *
 * @property int $id
 * @property string $cuerpo
 * @property string $created_at
 * @property int $comentario_id
 * @property int $usuario_id
 *
 * @property Comentarios $comentario
 * @property Usuarios $usuario
 */
class Respuestas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'respuestas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cuerpo', 'comentario_id', 'usuario_id'], 'required'],
            [['created_at'], 'safe'],
            [['comentario_id', 'usuario_id'], 'default', 'value' => null],
            [['comentario_id', 'usuario_id'], 'integer'],
            [['cuerpo'], 'string', 'max' => 255],
            [['comentario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Comentarios::class, 'targetAttribute' => ['comentario_id' => 'id']],
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
            'cuerpo' => 'Cuerpo',
            'created_at' => 'Created At',
            'comentario_id' => 'Comentario ID',
            'usuario_id' => 'Usuario ID',
        ];
    }

    /**
     * Gets query for [[Comentario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComentario()
    {
        return $this->hasOne(Comentarios::class, ['id' => 'comentario_id'])->inverseOf('respuestas');
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'usuario_id'])->inverseOf('respuestas');
    }
}