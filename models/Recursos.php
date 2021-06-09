<?php

namespace app\models;

use app\components\Utilidad;
use Yii;

/**
 * This is the model class for table "recursos".
 *
 * @property int $id
 * @property string $titulo
 * @property string $descripcion
 * @property string $contenido
 * @property string $created_at
 * @property string $imagen
 * @property string $pdfPdf
 * @property int $usuario_id
 * @property int $categoria_id
 *
 * @property Categorias $categoria
 * @property Usuarios $usuario
 */
class Recursos extends \yii\db\ActiveRecord
{

    public $img;
    public $pdf;
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
            [['imagen'], 'string'],
            [['pdf_pdf'], 'string'],
            [['titulo', 'descripcion', 'contenido'], 'string', 'max' => 255],
            [['categoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categorias::class, 'targetAttribute' => ['categoria_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::class, 'targetAttribute' => ['usuario_id' => 'id']],
            [['img'], 'image', 'extensions' => 'png, jpg, jpeg'],
            [['pdf'], 'file', 'extensions' => 'pdf'],
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
            'img' => 'Selecciona una imagen:',
            'pdf' => 'Selecciona un pdf:',
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

    /**
    * Carga las imagenes del formulario y las prepara para subir a AWS
    */
    public function upload()
    {
        if ($this->img !== null) {
            $titulo = \str_replace(' ', '', $this->titulo) . '_' . Yii::$app->user->id;
            $rutaImg = Yii::getAlias('@uploads/img' . $titulo . '_' . $this->img->extension);
            $this->img->saveAs($rutaImg);
            $this->imagen =  Utilidad::subirImgS3($this->img, $titulo, $rutaImg);
            $this->img = null;
        }
    }


    /**
    * Devuelve la url donde está alojadla imagen
    *
    * @return string $imagen
    */
    public function getImagen()
    {
        $img = $this->imagen ?? 'images_1.jpg';
        return Utilidad::getImg($img);
    }

    /**
    * Carga el pdf del formulario y lo prepara para subir a AWS
    */
    public function uploadPdf()
    {
        if ($this->pdf !== null) {
            $titulo = \str_replace(' ', '', $this->titulo) . '_' . Yii::$app->user->id;
            $rutaPdf = Yii::getAlias('@uploads/pdf' . $titulo . '.pdf');
            $this->pdf->saveAs($rutaPdf);
            $this->pdf_pdf =  Utilidad::subirPdfS3($this->pdf, $titulo, $rutaPdf);
            $this->pdf = null;
        }
    }

    /**
    * Devuelve la url donde está alojado el pdf
    *
    * @return string $pdfPdf
    */
    public function getPdf()
    {
        $pdf = $this->pdf_pdf;
        return Utilidad::getPdf($pdf);
    }
}
