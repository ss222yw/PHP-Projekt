<?php
	
	//the require once here just to show the coupling between classes.
	require_once(ModelPath.DS.'validation.php');
	require_once(ViewPath.DS.'upload.php');
	require_once(ViewPath.DS.'available.php');
	require_once(ModelPath.DS.'ImagesModel.php');
	require_once(ViewPath.DS.'CookieStorage.php');

	class UploadController {

		private $validation;
	    private $imgRoot;
	    private $uploadPage;
	    private $fileName;
	    private $imagesModel;
	    private $cookieStorage;

		private static $UPLOADEDSUCCESSED = "<p class='bg-success col-sm-4'>Bilden har laddats upp!</p><br><br>";
		private static $ErrorUPLOAD_ERR_TYPE = "<p class='bg-warning col-sm-4'>Bilden måste vara av typen gif,jepg,jpg eller png!</p><br><br>";	


		public function __construct() {

			$this->validation = new validation();
			$this->imgRoot = getcwd()."/src/view/Images/";
			$this->uploadPage = new upload();
			$this->available = new available();
			$this->fileName = $this->getFileName();
			$this->imagesModel = new ImagesModel();
			$this->cookieStorage = new CookieStorage();

		}

		//Get input and other stuff from upload view class.
		public function DidHasSubmit() {
			return $this->uploadPage->hasSubmitToUpload();
		}

		public function getFileName() {
			 return $this->uploadPage->GetImgName();
		}

		public function GetComment() {
			return $this->uploadPage->getComments();
		}



		//Send image path to validation class.
		public function getImgPath() {
			$this->validation->getImgRoot($this->imgRoot);
		}

		// Get input and other stuff from available view class.
		public function hasSubmitToDelImg() {
			return $this->available->hasSubmitToDel();
		}

		public function hasSubmitToEdits() {
			return $this->available->hasSubmitToEdit();
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

		public function GetImageComments() {
			return $this->available->GetImageComment();
		}

		//Delete Images from folder.
		public function removeImageFromFolder() {
			$this->EditImagesInfo();
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
						$PicName =basename($value);
						$this->imagesModel->removeImages($PicName);
						unlink($value);
						echo "<p class='bg-success col-sm-4'><strong> $PicName togs bort.</strong></p><br><br>";
					}
				}
			}

			else if ($this->getConforimNo()) {
				header('Location: ?page=Avaliable');	
			}		
		}

		public function GetSaveds() {
			return $this->available->GetSaved();
		}

		public function getHiddenImgEdit() {
			return $this->available->getSessionHiddenEdit();
		}

		//Edit comments
		public function EditImagesInfo() {
			if ($this->hasSubmitToEdits()) {
				$this->available->renderEditUploadedInformation();
			}
				$Images = glob("src/view/Images/*.*");
				foreach ($Images as $value) {
					if (basename($value) == $this->getHiddenImgEdit()) {
						if($this->GetSaveds()) {
								$images = new Images($this->getHiddenImgEdit(),$this->GetImageComments());
							  	$this->imagesModel->EditImagesInformation($images);
							  	echo "<p class='bg-success col-sm-4'><strong>Uppdatering av ".$this->getHiddenImgEdit(). "  har sparat!</p></strong><br><br>";
						}
					}
				}
		}
		

		//Render upload funcation.
		public function imgUpload() {
			$this->uploadPage->RenderUploadForm();
			$this->removeImageFromFolder();

			$counter = 1;
			$this->validation->getFileName($this->fileName);
	
			if ($this->DidHasSubmit() == true) {	

				// check if has file and make sure that the file have a right type.
				if (is_uploaded_file($_FILES[$this->fileName]['tmp_name'])) {
					if (exif_imagetype($_FILES[$this->fileName]['tmp_name']) == IMAGETYPE_GIF ||
						 exif_imagetype($_FILES[$this->fileName]['tmp_name']) == IMAGETYPE_JPEG ||
						 	 exif_imagetype($_FILES[$this->fileName]['tmp_name']) == IMAGETYPE_PNG) {

						if (file_exists($this->imgRoot.$_FILES[$this->fileName]['name'])) {

							$FileNameInfo = new SplFileInfo($_FILES[$this->fileName]['name']);
							$extension = $FileNameInfo->getExtension();
							$pointEx = substr(strrchr($_FILES[$this->fileName]['name'],"."), -4);
							$FileNameWithOutEx = $FileNameInfo->getBasename($pointEx);

							// While file is existes , add a counter to the name of the file .
							while (file_exists($this->imgRoot.$_FILES[$this->fileName]['name'])) {
								$_FILES[$this->fileName]['name'] = $FileNameWithOutEx."(".$counter++.")." . $extension;
							}
				
						}
						
						
						if ($_FILES[$this->fileName]['size'] < 5000000) {
							//Resize images before uploaded to folder.
							$imgCreateFromJ = imagecreatefromjpeg($_FILES[$this->fileName]['tmp_name']);
							$imgWidth =	getimagesize($_FILES[$this->fileName]['tmp_name'])[0];
							$imgHeigth = getimagesize($_FILES[$this->fileName]['tmp_name'])[1];
							$newImgWidth = 400;
							$newImgHeight = ($imgHeigth/$imgWidth) * $newImgWidth;
							$ImgCreateColor = imagecreatetruecolor($newImgWidth, $newImgHeight);
							imagecopyresampled($ImgCreateColor, $imgCreateFromJ, 0, 0, 0, 0, $newImgWidth, $newImgHeight, $imgWidth, $imgHeigth);
							$imgToUpload = imagejpeg($ImgCreateColor,$this->imgRoot.$_FILES[$this->fileName]['name'],100);

							 if ($imgToUpload) {
								$images = new Images($_FILES[$this->fileName]['name'],$this->GetComment());
							 	$this->imagesModel->addImages($images);
							 	//change filem mode, 0755 read and execute.
							 	chmod($this->imgRoot.$_FILES[$this->fileName]['name'], 0755);
							  	imagedestroy($imgCreateFromJ);
						      	imagedestroy($ImgCreateColor);
						      	$this->cookieStorage->SaveMessageCookie(self::$UPLOADEDSUCCESSED);
						      	header('Location: ?page=Avaliable');
					 			//$this->available->renderAllPicsForUsers();
							 	//return $this->available->DisplayAllImages(self::$UPLOADEDSUCCESSED);
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