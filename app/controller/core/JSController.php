<?php

	namespace HS\app\controller\core;

	use HS\config\APP_DIR;
	use HS\libs\core\Controller;
	use HS\libs\core\http\HttpResponse;
	use HS\libs\helper\MimeType;
	use HS\libs\io\Path;
	use const HS\APP_PATH;

	class JSController extends Controller
	{
		public function Get($filename){
			//Obteniendo ruta completa.
			$filename = Path::CombineAll(APP_PATH, APP_DIR::F_PREPROCESSED_JS, "$filename.js.php");

			//Si existe archivo.
			if (file_exists($filename)){
				//Establecer tipo en respuesta.
				HttpResponse::SetContentType(MimeType::JS);

				//Incluirlo.
				require_once $filename;
			}
			else
				HttpResponse::Set(HttpResponse::_404_NOTFOUND);
		}
	}