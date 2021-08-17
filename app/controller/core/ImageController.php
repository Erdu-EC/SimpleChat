<?php

	namespace HS\app\controller\core;

	use HS\config\APP_DIR;
	use HS\libs\collection\ArrayUtils;
	use HS\libs\core\http\HttpResponse;
	use HS\libs\core\Session;
	use HS\libs\graphic\Image;
	use HS\libs\graphic\ImageException;
	use HS\libs\helper\IOUtil;
	use HS\libs\helper\MimeType;
	use HS\libs\helper\Regex;
	use HS\libs\helper\Text;
	use HS\libs\io\Path;

	class ImageController
	{
		public static function Get(string $type, string $filename): void {
			/*TODO Limitar quien puede acceder a las fotos de perfil, con permisos de BD.*/

			//Obteniendo parámetros proporcionados por GET.
			$THUMB_WIDTH = isset($_GET['w']) ? intval($_GET['w']) : 0;
			$THUMB_HEIGHT = isset($_GET['h']) ? intval($_GET['h']) : 0;

			//Localizando el tipo de imagen y obteniendo ruta.
			$path = self::GetPathOfType($type, $filename);

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

		public static function GetOriginal(string $type, string $filename): void {
			//Localizando el tipo de imagen y obteniendo ruta.
			$path = self::GetPathOfType($type, $filename);

			//Estableciendo tipo de imagen.
			HttpResponse::SetContentType(Text::EndsWith($path, '.svg', true) ? MimeType::SVG : MimeType::OfFile($path));

			//Escribiendo en buffer de salida.
			die(file_get_contents($path, false));
		}

		public static function Upload(string $type) {
			HttpResponse::SetContentType(MimeType::Json);

			$type = !empty($type) ? $type : die(json_encode([false, 0]));
			$file = $_FILES['img'];

			if ($file['error'] !== 0)
				die(json_encode([false, 1]));
			else if (array_search(Path::GetExtension($file['name']), Image::SUPPORTED_FORMATS) === false)
				die(json_encode([false, 2]));
			else if (array_search(exif_imagetype($file['tmp_name']), [IMAGETYPE_BMP, IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_JPEG2000, IMAGETYPE_PNG]) === false)
				die(json_encode([false, 3]));
			else if (!isset(APP_DIR::IMAGE[$type]))
				die(json_encode([false, 4]));
			else {
				//Nombre de usuario.
				$user_name = (new Session())->user_name;

				//Obteniendo ruta en donde se guardara la imagen.
				$img_name = $type === 'profile' ? $user_name . Path::GetExtension($file['name']) : $file['name'];

				//Moviendo imagen subida a directorio correcto.
				if (move_uploaded_file($file['tmp_name'], self::GetPathOfType($type, $img_name)) !== false) {
					//Limpiar cache de foto de perfil.
					if ($type === 'profile')
						IOUtil::DeleteFileBeginWithName(Path::Combine(APP_DIR::IMAGE_CACHE, 'profile'), "$user_name (");

					//Devolviendo respuesta.
					die(json_encode([true]));
				} else
					die(json_encode([false, 5]));
			}
		}

		private static function GetPathOfType(string $type, string $filename): ?string {
			//Si no es un tipo de imagen valido...
			if (!isset(APP_DIR::IMAGE[$type])) {
				HttpResponse::Set(HttpResponse::_404_NOTFOUND);
				die;
			}

			//Localizando el tipo de imagen y obteniendo ruta.
			return Path::ToAbsolute(Path::Combine(APP_DIR::IMAGE[$type], $filename));
		}
	}