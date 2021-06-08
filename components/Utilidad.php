<?php

namespace app\components;

use Aws\S3\S3Client;

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
     * Sube el fichero a AWS S3
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
     * Devuelve la url del fichero almacenado en el bucket
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
     * Borra el fichero alojado en el bucket de aws
     * @param string $img
     */
    public static function borrarImgS3($imagen)
    {
        $s3Cliente = static::inicializar();
        return $s3Cliente->deleteObject([
            'Bucket' => 'orecursos',
            'Key' => $imagen
        ]);
    }
}