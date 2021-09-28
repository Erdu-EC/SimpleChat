<?php

	namespace HS\app\controller\core;

	use HS\app\model\UserModel;
	use HS\config\APP_DIR;
	use HS\config\APP_URL;
	use HS\config\DBAccount;
	use HS\libs\core\http\HttpResponse;
	use HS\libs\core\Logger;
	use HS\libs\core\Session;
	use HS\libs\graphic\Image;
	use HS\libs\graphic\ImageException;
	use HS\libs\helper\IOUtil;
	use HS\libs\helper\MimeType;
	use HS\libs\helper\Text;
	use HS\libs\io\Path;
	use HS\libs\io\Url;
	use const HS\APP_URL;

	class ImageController
	{
		public static function Get(string $type, string $filename): void {
			/*TODO Limitar quien puede acceder a las fotos de perfil, con permisos de BD.*/

			//Logger::Log('img', $type, $filename);

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
			//TODO: INGRESAR EN BASE DE DATOS RUTA DE LA IMAGEN.
			HttpResponse::SetContentType(MimeType::Json);

			$type = !empty($type) ? $type : die(json_encode([false, 0]));
			$file = $_FILES['img'];

			if ($file['error'] !== 0)
				die(json_encode([false, 1]));
			else if (array_search(strtolower(Path::GetExtension($file['name'])), Image::SUPPORTED_FORMATS) === false)
				die(json_encode([false, 2]));
			else if (array_search(exif_imagetype($file['tmp_name']), [IMAGETYPE_BMP, IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_JPEG2000, IMAGETYPE_PNG]) === false)
				die(json_encode([false, 3]));
			else if (!isset(APP_DIR::IMAGE[$type]))
				die(json_encode([false, 4]));
			else {
				//Nombre de usuario.
				$session = new Session();
				$user_id = $session->user_id;
				$user_name = $session->user_name;

				//Obteniendo ruta en donde se guardara la imagen.
				$img_name = $type === 'profile' ? $user_name . Path::GetExtension($file['name']) : $file['name'];

				//Actualizando base de datos.
				if ($type === 'profile') {
					if (($user = new UserModel(DBAccount::Root))->UpdateProfileImage($user_id, $img_name, fn() => move_uploaded_file($file['tmp_name'], self::GetPathOfType($type, $img_name)) !== false)){
						//Desconectando base de datos.
						unset($user);

						//Eliminando anterior foto de perfil.
						$new_profile_img = APP_URL::OfImageProfile($img_name);

						if ($new_profile_img != $session->user_profile_img) {
							$current_profile_img = Path::GetFileName($session->user_profile_img);

							//Eliminando imagen de perfil anterior.
							unlink(self::GetPathOfType($type, $current_profile_img));

							//Actualizando datos de sesion.
							$session->user_profile_img = $new_profile_img;
						}

						//Cerrando datos de sesión.
						unset($current_profile_img);
						unset($new_profile_img);
						unset($session);

						//Limpiar cache de foto de perfil.
						IOUtil::DeleteFileBeginWithName(Path::Combine(APP_DIR::IMAGE_CACHE, 'profile'), "$user_name (");

						//Devolviendo respuesta.
						die(json_encode([true]));
					}

					//Devolviendo respuesta negativa.
					die(json_encode([false, 5]));
				} elseif ($type === 'chat') {
					//Obteniendo contacto y nombre con que se guardara el fichero.
					$contact_id = !empty($_POST['contact']) ? $_POST['contact'] : die(json_encode([false, 6]));
					$img_name = dechex($user_id) . md5(uniqid('', true)) . Path::GetExtension($img_name);

					//Insertando en base de datos el mensaje que contendra el fichero.
					if (($user = new UserModel(DBAccount::Root))->SendMessageImg($user_id, $contact_id, $img_name, fn() => move_uploaded_file($file['tmp_name'], self::GetPathOfType($type, $img_name)) !== false)) {
						//Desconectando base de datos.
						unset($user);

						//Devolviendo respuesta.
						die(json_encode([true]));
					}else{
						//Devolviendo respuesta negativa.
						die(json_encode([false, 7]));
					}
				}

				//Cerrando datos de sesión.
				unset($session);

				//Moviendo imagen subida a directorio correcto.
				if (move_uploaded_file($file['tmp_name'], self::GetPathOfType($type, $img_name)) !== false) {
					die(json_encode([true]));
				} else
					die(json_encode([false, 8]));
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