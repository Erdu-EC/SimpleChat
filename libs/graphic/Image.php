<?php

	namespace HS\libs\graphic;

	use HS\libs\io\Path;
	use const HS\APP_FILE_MODE;

	class Image
	{
		private $Handle;
		private $FileName;

		const SUPPORTED_FORMATS = ['.bmp', '.gif', '.jpg', '.jpeg', '.png'];

		public function __construct($resource, string $path) {
			$this->Handle = $resource;
			$this->FileName = $path;

			if (Path::GetExtension($path) === '.png')
				$this->SetTransparency();
		}

		public function __destruct() {
			imagedestroy($this->Handle);
			unset($this->Handle);
		}

		/**
		 * @throws ImageException
		 */
		public static function FromFile(string $path): Image {
			//Verificando que la imagen exista.
			if (!file_exists($path) || empty(Path::GetFileName($path) || empty(Path::GetExtension($path))))
				throw new ImageException($path, ImageException::NOTFOUND);

			//Obteniendo instancia de la imagen
			switch (exif_imagetype($path)) {
				case IMAGETYPE_BMP:
					$img = imagecreatefrombmp($path);
					break;
				case IMAGETYPE_GIF:
					$img = imagecreatefromgif($path);
					break;
				case IMAGETYPE_JPEG:
				case IMAGETYPE_JPEG2000:
					$img = imagecreatefromjpeg($path);
					break;
				case IMAGETYPE_PNG:
					$img = imagecreatefrompng($path);
					break;
				default:
					$img = false;
			}

			//Verificando si la imagen se abrio correctamente
			if ($img === false) throw new ImageException($path, ImageException::UNSOPPORTED);

			//Devolviendo imagen.
			return new Image($img, $path);
		}

		public function GetWidth(): int {
			if (($width = imagesx($this->Handle)) === false) return 0;
			return $width;
		}

		public function GetHeight(): int {
			if (($height = imagesy($this->Handle)) === false) return 0;
			return $height;
		}

		/**
		 * @throws ImageException
		 */
		public function GetThumbnail(int $width, int $height, ?string $cacheDir): Image {
			//Verificando si se necesita miniatura.
			if ($width <= 0 && $height <= 0)
				throw new ImageException($this->FileName, ImageException::THUMB_NOTNEEDED);

			//Obteniendo ancho y alto original.
			$source_width = $this->GetWidth();
			$source_height = $this->GetHeight();

			//Si se establecio un ancho y un alto sugerido.
			if ($width > 0 && $height > 0) {
				if ($source_width > $width)
					$height = self::CalcProportionalHeight($source_height, $source_width, $width);

				if ($source_height > $height)
					$width = self::CalcProportionalWidth($source_height, $source_width, $height);
			} //Si no se establecio un ancho o un alto.
			else {
				//Calculando ancho de la miniatura
				if ($width <= 0)
					$width = self::CalcProportionalWidth($source_height, $source_width, $height);

				//Calculando alto de la miniatura
				if ($height <= 0)
					$height = self::CalcProportionalHeight($source_height, $source_width, $width);
			}

			//Si la miniatura es mas grande que la original, no es necesario miniatura.
			if ($width >= $source_width && $height >= $source_height)
				throw new ImageException($this->FileName, ImageException::THUMB_NOTNEEDED);

			//Construyendo ruta.
			if (empty($cacheDir)) $cacheDir = Path::GetDirName($this->FileName);
			$extension = Path::GetExtension($this->FileName);
			$cacheName = Path::Combine($cacheDir, Path::GetFileNameWithoutExtension($this->FileName));
			$cacheName .= " ($width x $height)$extension";

			//Si existe la miniatura en el directorio
			try {
				return Image::FromFile($cacheName); //Devolverla
			} catch (ImageException $ex) {
			}

			//Creando contenedor para la miniatura
			$thumb = imagecreatetruecolor($width, $height);

			//Si es una imagen png, arreglar transparencia.
			if ($extension == '.png') $this->SetTransparency($thumb);

			//Generando miniatura
			imagecopyresampled($thumb, $this->Handle, 0, 0, 0, 0, $width, $height, $source_width, $source_height);

			//Creando imagen de la miniatura.
			$image = new Image($thumb, $cacheName);

			//Guardando miniatura si no existe.
			if (!empty($cacheDir) && !file_exists($cacheName)) $image->SaveTo($cacheDir, true);

			//Regresando la miniatura.
			return $image;
		}

		/**
		 * @throws ImageException
		 */
		private function SaveTo(string $dest_dir, bool $overwrite) {
			//Creando directorio temporal si no existiera.
			if (!is_dir($dest_dir) && !file_exists($dest_dir)) {
				if (!mkdir($dest_dir, APP_FILE_MODE, true))
					throw new ImageException($dest_dir, ImageException::DIR_NOTCREATED);
			}

			//Construyendo ruta.
			$path = Path::Combine($dest_dir, Path::GetFileName($this->FileName));

			//Guardando imagen si no existe.
			if ($overwrite || !file_exists($path))
				$this->Save($path);
		}


		public function Print() {
			$this->Save(null);
		}

		public static function CalcProportionalWidth(int $sourceHeight, int $sourceWidth, int $height) {
			//Calculando ancho de la miniatura
			$ratio = round(($height * 100) / $sourceHeight, 2, PHP_ROUND_HALF_DOWN);
			return round(($sourceWidth * $ratio) / 100, 2, PHP_ROUND_HALF_DOWN);
		}

		public static function CalcProportionalHeight(int $sourceHeight, int $sourceWidth, int $width) {
			//Calculando ancho de la miniatura
			$ratio = round(($width * 100) / $sourceWidth, 2, PHP_ROUND_HALF_DOWN);
			return round(($sourceHeight * $ratio) / 100, 2, PHP_ROUND_HALF_DOWN);
		}

		public function Save($filename) {
			switch (Path::GetExtension(!is_null($filename) ? $filename : $this->FileName)) {
				case ".bmp":
					imagebmp($this->Handle, $filename, true);
					break;
				case ".gif":
					imagegif($this->Handle, $filename);
					break;
				case ".jpg":
				case ".jpeg":
					imagejpeg($this->Handle, $filename, 80);
					break;
				case ".png":
					imagepng($this->Handle, $filename, 9);
					break;
			}
		}

		private function SetTransparency($resource = null) {
			if ($resource == null) $resource = $this->Handle;

			imagealphablending($resource, false);
			imagesavealpha($resource, true);
			$alpha = imagecolorallocatealpha($resource, 0, 0, 0, 127);
			imagefill($resource, 0, 0, $alpha);
		}
	}

