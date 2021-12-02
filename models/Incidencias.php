<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "incidencias".
 *
 * @property int $id
 * @property int $usuario_id
 * @property int $receptor_id
 * @property bool $visto
 * @property string $cuerpo
 *
 * @property Usuarios $usuario
 */
class Incidencias extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'incidencias';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_id', 'receptor_id', 'cuerpo'], 'required'],
            [['usuario_id', 'receptor_id'], 'default', 'value' => null],
            [['usuario_id', 'receptor_id'], 'integer'],
            [['visto'], 'boolean'],
            [['cuerpo'], 'string', 'max' => 255],
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
            'usuario_id' => 'Usuario ID',
            'receptor_id' => 'Receptor ID',
            'visto' => 'Visto',
            'cuerpo' => 'Cuerpo',
        ];
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'usuario_id'])->inverseOf('incidencias');
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReceptor()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'receptor_id'])->inverseOf('incidencias');
    }
}
