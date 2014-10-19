<?php

	class UploadController {

		private $validation;
	    private $imgRoot;
	    private $uploadPage;
	    private $fileName;

		private static $UPLOADEDSUCCESSED = "Bilden har laddats upp!";
		private static $ErrorUPLOAD_ERR_TYPE = "Bilden måste vara av typen gif,jepg,jpg eller png!";	


		public function __construct() {

			$this->validation = new validation();
			$this->imgRoot = getcwd()."/src/view/Images/";
			$this->uploadPage = new upload();
			$this->available = new available();
			$this->fileName = $this->getFileName();

		}

		//Get input and other stuff from upload view class.
		public function DidHasSubmit() {
			return $this->uploadPage->hasSubmitToUpload();
		}

		public function getFileName() {
			 return $this->uploadPage->GetImgName();
		}

		//Send image path to validation class.
		public function getImgPath() {
			$this->validation->getImgRoot($this->imgRoot);
		}

		// Get input and other stuff from available view class.
		public function hasSubmitToDelImg() {
			return $this->available->hasSubmitToDel();
		}

		public function getHiddenID() {
			return $this->available->getHiddenId();
		}

		public function getHiddenImg() {
			return $this->available->getSessionHidden();
		}

		public function getConforimYes() {
			return $this->available->getYesDel();
		}

		public function getConforimNo() {
			return $this->available->getNoDel();
		}

		//Delete Images from folder.
		public function removeImageFromFolder() {
			if ($this->hasSubmitToDelImg()) {
				$Images = glob("src/view/Images/*.*");
				foreach ($Images as $value) {
					if (basename($value) == $this->getHiddenID()) {
					  $this->available->renderAreYouSure();
					}
				}
			}

			if ($this->getConforimYes()) {
				$Images = glob("src/view/Images/*.*");
				foreach ($Images as $value) {
					if (basename($value) == $this->getHiddenImg()) {
						unlink($value);
						$PicName =basename($value);
						echo "$PicName togs bort.";
					}
				}
			}

			else if ($this->getConforimNo()) {
				header('Location: ?page=Avaliable');	
			}		
		}

		//Render upload funcation.
		public function imgUpload() {
			$this->uploadPage->RenderUploadForm();
			$this->removeImageFromFolder();
			$counter = 1;
			$this->validation->getFileName($this->fileName);
	
			if ($this->DidHasSubmit() == true) {
			
				if (is_uploaded_file($_FILES[$this->fileName]['tmp_name'])) {
					if (exif_imagetype($_FILES[$this->fileName]['tmp_name']) == IMAGETYPE_GIF ||
						 exif_imagetype($_FILES[$this->fileName]['tmp_name']) == IMAGETYPE_JPEG ||
						 	 exif_imagetype($_FILES[$this->fileName]['tmp_name']) == IMAGETYPE_PNG) {

						if (file_exists($this->imgRoot.$_FILES[$this->fileName]['name'])) {

							$FileNameInfo = new SplFileInfo($_FILES[$this->fileName]['name']);
							$extension = $FileNameInfo->getExtension();
							$pointEx = substr(strrchr($_FILES[$this->fileName]['name'],"."), -4);
							$FileNameWithOutEx = $FileNameInfo->getBasename($pointEx);

							while (file_exists($this->imgRoot.$_FILES[$this->fileName]['name'])) {
								$_FILES[$this->fileName]['name'] = $FileNameWithOutEx."(".$counter++.")." . $extension;
							}
				
						}
						//Resize images before uploaded to folder.
						if ($_FILES[$this->fileName]['size'] < 5000000) {
							$imgCreateFromJ = imagecreatefromjpeg($_FILES[$this->fileName]['tmp_name']);
							$imgWidth =	getimagesize($_FILES[$this->fileName]['tmp_name'])[0];
							$imgHeigth = getimagesize($_FILES[$this->fileName]['tmp_name'])[1];
							$newImgWidth = 400;
							$newImgHeight = ($imgHeigth/$imgWidth) * $newImgWidth;
							$ImgCreateColor = imagecreatetruecolor($newImgWidth, $newImgHeight);
							imagecopyresampled($ImgCreateColor, $imgCreateFromJ, 0, 0, 0, 0, $newImgWidth, $newImgHeight, $imgWidth, $imgHeigth);
							$imgToUpload = imagejpeg($ImgCreateColor,$this->imgRoot.$_FILES[$this->fileName]['name'],100);

							 if ($imgToUpload) {
							 	//change filem mode, 0755 read and execute.
							 	chmod($this->imgRoot.$_FILES[$this->fileName]['name'], 0755);
							  	imagedestroy($imgCreateFromJ);
						      	imagedestroy($ImgCreateColor);
					 			$this->available->renderAllPicsForUsers();
							 	return $this->available->DisplayAllImages(self::$UPLOADEDSUCCESSED);
							 	}	
						}
					}

					else {
							return $this->uploadPage->imageUpload(self::$ErrorUPLOAD_ERR_TYPE);
						 }
				}
				else {
						return $this->uploadPage->imageUpload($this->validation->errorToMessage());
					 }
			}
		}	

	}