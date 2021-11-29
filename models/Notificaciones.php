<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "notificaciones".
 *
 * @property int $id
 * @property int $usuario_id
 * @property int $recurso_id
 * @property bool $visto
 * @property string $cuerpo
 *
 * @property Recursos $recurso
 * @property Usuarios $usuario
 */
class Notificaciones extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notificaciones';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_id', 'recurso_id', 'cuerpo'], 'required'],
            [['usuario_id', 'recurso_id'], 'default', 'value' => null],
            [['usuario_id', 'recurso_id'], 'integer'],
            [['cuerpo'], 'string', 'max' => 255],
            [['visto'], 'boolean'],
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
            'usuario_id' => 'Usuario ID',
            'recurso_id' => 'Recurso ID',
            'cuerpo' => 'Notificación',
        ];
    }

    /**
     * Gets query for [[Recurso]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRecurso()
    {
        return $this->hasOne(Recursos::class, ['id' => 'recurso_id'])->inverseOf('notificaciones');
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'usuario_id'])->inverseOf('notificaciones');
    }
}
