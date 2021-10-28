<?php

	namespace HS\app\controller\core;

	use HS\config\APP_DIR;
	use HS\config\APP_URL;
	use HS\libs\core\Controller;
	use HS\libs\core\http\HttpResponse;
	use HS\libs\helper\MimeType;
	use HS\libs\helper\Text;
	use HS\libs\io\Path;
	use const HS\APP_PATH;

	class FileAccessController extends Controller
	{
		public function GetAudio(string $filename) {
			//Obteniendo ruta.
			$path = Path::CombineALL(APP_PATH, APP_DIR::AUDIO, $filename);

			//Estableciendo mime type
			HttpResponse::SetContentType(MimeType::OfFile($path));

			//Escribiendo en buffer de salida.
			if (file_exists($path))
				die(file_get_contents($path, false));
			else
				HttpResponse::Set(HttpResponse::_404_NOTFOUND);
		}
	}