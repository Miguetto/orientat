<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "recursos".
 *
 * @property int $id
 * @property string $titulo
 * @property string $descripcion
 * @property string $contenido
 * @property string $created_at
 * @property int $usuario_id
 * @property int $categoria_id
 *
 * @property Categorias $categoria
 * @property Usuarios $usuario
 */
class Recursos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'recursos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['titulo', 'descripcion', 'contenido', 'usuario_id', 'categoria_id'], 'required'],
            [['created_at'], 'safe'],
            [['usuario_id', 'categoria_id'], 'default', 'value' => null],
            [['usuario_id', 'categoria_id'], 'integer'],
            [['titulo', 'descripcion', 'contenido'], 'string', 'max' => 255],
            [['categoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categorias::class, 'targetAttribute' => ['categoria_id' => 'id']],
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
            'contenido' => 'Contenido',
            'created_at' => 'Publicado',
            'usuario_id' => 'Usuario',
            'categoria_id' => 'Categoria',
        ];
    }

    /**
     * Gets query for [[Categoria]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria()
    {
        return $this->hasOne(Categorias::class, ['id' => 'categoria_id'])->inverseOf('recursos');
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'usuario_id'])->inverseOf('recursos');
    }

    /**
     * Devuelve el usuario que dió like
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioLike($id)
    {
        return Usuarios::find()->where(['id' => $id])->one();
    }

    /**
     * Todos los recursos del usuario con like
     *
     * @return \yii\db\ActiveQuery
     */
    public static function recursoLike($id) {
        return Recursos::find()->where(['usuario_id' => $id])->all(); 
    }

        /**
     * Gets query for [[Likes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTotalLikes()
    {
        $total = $this->hasMany(Likes::class, ['recurso_id' => 'id']);

        return $total->count();
    }

     /**
     * Gets query for [[Likes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLikes()
    {
        if ($this->getTotalLikes() > 2) {
            return Likes::find()->where(['recurso_id' => $this->id])->orderBy(['id' => SORT_DESC])->limit(3);
        } else if ($this->getTotalLikes() > 0){
            return Likes::find()->where(['recurso_id' => $this->id])->orderBy(['id' => SORT_DESC])->all();
        } else {
            return Likes::find()->where(['recurso_id' => $this->id])->all();
        }
    }
}
