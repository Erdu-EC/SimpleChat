<?php

	namespace HS\app\controller\core;

	use Error;
	use Exception;
	use HS\libs\core\http\HttpResponse;
	use HS\libs\core\Logger;
	use HS\libs\helper\MimeType;
	use HS\libs\io\Path;
	use HS\libs\io\Url;
	use ScssPhp\ScssPhp\Compiler;
	use ScssPhp\ScssPhp\OutputStyle;
	use ScssPhp\Server;
	use const HS\APP_DEBUG;
	use const HS\APP_FILE_MODE;
	use const HS\APP_PATH;
	use const HS\config\SCSS_COMPRESS;
	use const HS\config\SCSS_LOG_FILE;
	use const HS\config\SCSS_PATH_CACHE;
	use const HS\config\SCSS_PATH_ROOT;
	use const HS\config\SCSS_PATH_SOURCE;

	require APP_PATH . '/vendor/SCSSPHP/scss.inc.php';

	class SCSSController
	{
		public function Get(string $filename) {
			$filename_map = "$filename.css.map";
			$filename = "$filename.scss";

			//Ruta del fichero .scss
			$path_scss = Path::Combine(SCSS_PATH_ROOT, $filename);

			if (file_exists($path_scss)) {
				//Obteniendo el path del fichero SourceMap y su directorio contenedor.
				$path_map = Path::Combine(SCSS_PATH_CACHE, $filename_map);
				$path_map_dir = Path::GetDirName($path_map);

				//Si no existe el directorio que contendra el fichero SourceMap...
				if (!($hasSourceMap = is_dir($path_map_dir))) $hasSourceMap = mkdir($path_map_dir, APP_FILE_MODE, true);

				//Configurando el compilador SCSS.
				$scss = new Compiler();
				$scss->setOutputStyle(SCSS_COMPRESS ? OutputStyle::COMPRESSED : OutputStyle::EXPANDED);
				$scss->setSourceMap($hasSourceMap ? Compiler::SOURCE_MAP_FILE : Compiler::SOURCE_MAP_NONE);
				$scss->setSourceMapOptions([
					'sourceMapWriteTo' => $path_map, //Path temporal
					'sourceMapURL' => $filename_map, //Url accesible
					'sourceMapBasepath' => Url::Fix(SCSS_PATH_ROOT), //Remover del path real.
					'sourceMapRootpath' => SCSS_PATH_SOURCE,
				]);

				//Iniciando el servidor.
				try {
					@(new Server(SCSS_PATH_ROOT, SCSS_PATH_CACHE, $scss))->serve($filename);
				} catch (Exception $ex) { //ServerException y otras...
					$this->ErrorInternal($ex, $path_scss);
				} catch (Error $ex) {
					$this->ErrorInternal($ex, $path_scss);
				}
			} else
				$this->ErrorNotFound($path_scss);
		}

		public function GetMap(string $filename) {
			$filename = Path::Combine(SCSS_PATH_CACHE, "$filename.css.map");
			$this->PrintFileIfDebugAndExist($filename, MimeType::Json);
		}

		public function GetSCSS(string $filename) {
			$filename = Path::Combine(SCSS_PATH_ROOT, "$filename.scss");
			$this->PrintFileIfExist($filename, MimeType::CSS);
		}

		private function PrintFileIfExist($filename, $mimetype) {
			if (file_exists($filename)) {
				try {
					HttpResponse::SetContentType($mimetype);

					die(file_get_contents($filename));
				} catch (Error $ex) {
					$this->ErrorInternal($ex, $filename);
				}
			} else
				$this->ErrorNotFound($filename);
		}

		private function PrintFileIfDebugAndExist($filename, $mimetype) {
			if (APP_DEBUG)
				$this->PrintFileIfExist($filename, $mimetype);
			else
				HttpResponse::Set(HttpResponse::_404_NOTFOUND);
		}

		private function ErrorInternal($ex, $path) {
			//Respuesta: Internal Server Error
			HttpResponse::Set(HttpResponse::_500_INTERNAL_SERVER_ERROR);

			//Log.
			Logger::Log(SCSS_LOG_FILE, "SCSS_PARSE_ERROR | $path", $ex->getMessage());
		}

		private function ErrorNotFound($path) {
			//Respuesta: Fichero no encontrado.
			HttpResponse::Set(HttpResponse::_404_NOTFOUND);

			//Log.
			Logger::Log(SCSS_LOG_FILE, "SCSS_FILE_NO_EXIST", $path);
		}
	}