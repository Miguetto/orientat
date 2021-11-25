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
            [['usuario_id', 'votos'], 'default', 'value' => null],
            [['usuario_id', 'votos'], 'integer'],
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
            'votos' => 'Votos',
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
        $total = $this->votos;

        return $total;   
        
    }

    public function existeVoto($propuesta_id)
    {
        $usuario_id = Yii::$app->user->id;
        $existeVoto = Votos::find()->where(['propuesta_id' => $propuesta_id, 'usuario_id' => $usuario_id])->one();
        
        if($existeVoto == true){
            return true;
        }else {
            return false;
        }
    }
}
