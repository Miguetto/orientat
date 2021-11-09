<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comentarios".
 *
 * @property int $id
 * @property string $cuerpo
 * @property string $created_at
 * @property int $recurso_id
 * @property int $usuario_id
 * @property int|null $respuesta_id
 *
 * @property Recursos $recurso
 * @property Usuarios $usuario
 * @property Respuestas[] $respuestas
 */
class Comentarios extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comentarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cuerpo', 'recurso_id', 'usuario_id'], 'required'],
            [['created_at'], 'safe'],
            [['recurso_id', 'usuario_id', 'respuesta_id'], 'default', 'value' => null],
            [['recurso_id', 'usuario_id', 'respuesta_id'], 'integer'],
            [['cuerpo'], 'string', 'max' => 255],
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
            'cuerpo' => 'Cuerpo',
            'created_at' => 'Created At',
            'recurso_id' => 'Recurso ID',
            'usuario_id' => 'Usuario ID',
            'respuesta_id' => 'Respuesta ID',
        ];
    }

    /**
     * Gets query for [[Recurso]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRecurso()
    {
        return $this->hasOne(Recursos::class, ['id' => 'recurso_id'])->inverseOf('comentarios');
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'usuario_id'])->inverseOf('comentarios');
    }

    /**
     * Gets query for [[Respuestas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRespuestas()
    {
        return $this->hasMany(Respuestas::class, ['comentario_id' => 'id'])->inverseOf('comentario');
    }
}