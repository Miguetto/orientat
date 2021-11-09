<?php

namespace app\components;

use app\models\Comentarios;
use app\models\Respuestas;
use Aws\S3\S3Client;
use DateTime;
use DateTimeZone;

class Utilidad
{

    /**
     * Inicia el cliente de AWS
     * @return \Aws\S3\S3Client
     */
    private static function inicializar()
    {
        $s3Cliente = new S3Client([
            'version' => 'latest',
            'region' => 'eu-west-3',
            'credentials' => [
                'key' => \getenv('S3_PASS'),
                'secret' =>  \getenv('S3S_PASS')
            ],
            
        ]);
        return $s3Cliente;
    }

    /**
     * Sube la imagen a AWS S3
     * @param file $archivo
     * @param string $titulo
     * @param mixed $rutaImg
     *
     * @return string $titulo
     */
    public static function subirImgS3($archivo, $titulo, $rutaImg)
    {
        $s3Cliente = static::inicializar();
        $titulo .= '.' . $archivo->extension;

        $s3Cliente->putObject([
            'Bucket' => 'orecursos',
            'Key' =>    "img/$titulo",
            'SourceFile' => $rutaImg,
            'ACL' => 'public-read'
        ]);
        
        \unlink($rutaImg);
        return $titulo;
    }
    
    /**
     * Devuelve la url de la imagen almacenada en el bucket
     * @param string $img
     * @return string $imagen
     */
    public static function getImg($img)
    {
        $s3Cliente = static::inicializar();
        $key = 'img/' . $img;
        return $s3Cliente->getObjectUrl('orecursos', $key);
    }

    /**
     * Borra la imagen alojada en el bucket de aws
     * @param string $img
     */
    public static function borrarImgS3($imagen)
    {
        $s3Cliente = static::inicializar();
        return $s3Cliente->deleteObject([
            'Bucket' => 'orecursos',
            'Key' => "img/$imagen",
        ]);
    }

    /**
     * Sube el fichero pdf a AWS S3
     * @param file $archivo
     * @param string $titulo
     * @param mixed $rutaPdf
     *
     * @return string $titulo
     */
    public static function subirPdfS3($archivo, $titulo, $rutaPdf)
    {
        $s3Cliente = static::inicializar();
        $titulo .= '.' . $archivo->extension;

        $s3Cliente->putObject([
            'Bucket' => 'orecursos',
            'Key' =>    "pdf/$titulo",
            'SourceFile' => $rutaPdf,
            'ACL' => 'public-read'
        ]);
        
        \unlink($rutaPdf);
        return $titulo;
    }

    /**
     * Elimina un recurso de Amazon S3
     *
     * @param [type] $key
     * @param [type] $bucketName
     * @return void
     */
    public static function s3Eliminar($key, $bucketName)
    {
        $s3 = static::inicializar();
        $s3->deleteObject([
            'Bucket' => $bucketName,
            'Key' => $key,
        ]);
    }

    /**
     * Devuelve la url del pdf almacenado en el bucket
     * @param string $pdf
     * @return string $pdfPdf
     */
    public static function getPdf($pdf)
    {
        $s3Cliente = static::inicializar();
        $key = 'pdf/' . $pdf;
        return $s3Cliente->getObjectUrl('orecursos', $key);
    }

     /**
     * Borra el fichero alojado en el bucket de aws
     * @param string $pdf
     */
    public static function borrarPdfS3($pdf_pdf)
    {
        $s3Cliente = static::inicializar();
        return $s3Cliente->deleteObject([
            'Bucket' => 'orecursos',
            'Key' => "pdf/$pdf_pdf",
        ]);
    }

    public static function formatoFecha($dt)
    {
        $date_created = date($dt);
        $dt = new DateTime($date_created);
        $dt->setTimezone(new DateTimeZone('Europe/Madrid'));
        $dt = $dt->format('d-m-Y H:i:s');

        return $dt;
    }

    /**
     * Función para comprobar si el usuario ya ha comentado un recurso
     */
    public static function existeComentario($id, $usuarioId)
    {
        $existe = false;
        $comentarios = Comentarios::find()->where(['recurso_id' => $id])->all();

        foreach($comentarios as $comentario){
            if($comentario->usuario_id == $usuarioId){
                $existe = true;
            }
        }
        return $existe;
    }

    /**
     * Función para mostrar la respuesta a un comentario
     */
    public static function mostrarRespuesta($comentario_id)
    {
        $existe = false;
        $respuestas = Respuestas::find()->where(['receptor' => $comentario_id])->one();

        foreach($respuestas as $respuesta){
            if($respuesta->receptor == $comentario_id){
                $existe = true;
            }
        }
        return $existe;
    }

    public static function botonResponder($receptor, $emisor, $recurso_id)
    {
        
    }
}