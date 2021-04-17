<?php

namespace HS\libs\graphic;

use Throwable;

class ImageException extends \Exception
{
    //Constants
    const ERROR_UNKNOWN = 0;
    const NOTFOUND = 1;
    const UNSOPPORTED = 2;
    const THUMB_NOTNEEDED = 3;
    const DIR_NOTCREATED = 4;

    //public
    public function __construct(string $path, $code = 0, Throwable $previous = NULL)
    {
        switch ($code) {
            case self::NOTFOUND:
                $message = "La imagen no existe o la ruta no es valida.";
                break;
            case self::UNSOPPORTED:
                $message = 'La imagen no pudo ser abierta, probablemente esta no posea una extension soportada por la aplicacion.';
                break;
            case self::THUMB_NOTNEEDED:
                $message = 'La miniatura de la imagen no fue creada, ya que no era necesario.';
                break;
            case self::DIR_NOTCREATED:
                $message = 'El directorio en donde se guardaria la imagen no existe y no pudo ser creado.';
                break;
            default:
                $message = 'Ha ocurrido un error al trabajar con la imagen, aunque se desconoce cual sea.';
        }

        $message .= " $path";

        parent::__construct($message, $code, $previous);
    }
}