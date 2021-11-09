<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "propuestas".
 *
 * @property int $id
 * @property string $titulo
 * @property string $descripcion
 * @property string $created_at
 * @property int $usuario_id
 *
 * @property Usuarios $usuario
 */
class Propuestas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'propuestas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['titulo', 'descripcion', 'usuario_id'], 'required'],
            [['created_at'], 'safe'],
            [['created_at'], 'date', 'format' =>'php:Y-m-d H:i:s'],
            [['usuario_id'], 'default', 'value' => null],
            [['usuario_id'], 'integer'],
            [['titulo', 'descripcion'], 'string', 'max' => 255],
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
            'titulo' => 'Titulo',
            'descripcion' => 'Descripcion',
            'created_at' => 'Publicado',
            'usuario_id' => 'Usuario ID',
        ];
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'usuario_id'])->inverseOf('propuestas');
    }

    /**
     * Gets query for [[Votos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTotalVotos()
    {
        $total = $this->hasMany(Votos::class, ['propuesta_id' => 'id']);

        return $total->count();        
        
    }
}
