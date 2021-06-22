<?php
namespace HS\app\controller\core;

use HS\config\APP_DIR;
use HS\libs\core\http\HttpResponse;
use HS\libs\graphic\Image;
use HS\libs\graphic\ImageException;
use HS\libs\helper\MimeType;
use HS\libs\io\Path;

class ImageController
{
    public static function Get(string $type, string $filename)
    {
        /*TODO Limitar quien puede acceder a las fotos de perfil, con permisos de BD.*/

        //Obteniendo parámetros proporcionados por GET.
        $THUMB_WIDTH = isset($_GET['w']) ? intval($_GET['w']) : 0;
        $THUMB_HEIGHT = isset($_GET['h']) ? intval($_GET['h']) : 0;

        //Si no es un tipo de imagen valido...
        if (!isset(APP_DIR::IMAGE[$type])) {
            HttpResponse::Set(HttpResponse::_404_NOTFOUND);
            die;
        }

        //Localizando el tipo de imagen y obteniendo ruta.
        $path = Path::ToAbsolute(Path::Combine(APP_DIR::IMAGE[$type], $filename));

        //Abriendo imagen original
        try {
            $image = Image::FromFile($path);
        } catch (ImageException $ex) {
            if ($ex->getCode() == ImageException::NOTFOUND)
                HttpResponse::Set(HttpResponse::_404_NOTFOUND);
            else
                HttpResponse::Set(HttpResponse::_500_INTERNAL_SERVER_ERROR);
            die;
        }

        //Convertiendo archivo php en imagen.
        HttpResponse::SetContentType(MimeType::OfFile($path));

        //Obteniendo miniatura e imprimiendola
        try {
            $thumb = $image->GetThumbnail($THUMB_WIDTH, $THUMB_HEIGHT, Path::Combine(APP_DIR::IMAGE_CACHE, $type));
            $thumb->Print();
        } catch (ImageException $ex) {
            $image->Print(); //Sino, devolver imagen original
            unset($image);
            exit;
        }

        //Cerrando recursos
        unset($image);
        unset($thumb);
    }

    public static function GetOriginal(string $type, string $filename){

    }
}