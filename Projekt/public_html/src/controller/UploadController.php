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

		private static $UPLOADEDSUCCESSED = '<div class="alert alert-success alert-dismissible" role="alert">
  							 				 <button type="button" class="close" data-dismiss="alert">
  											 <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  										     <strong>Bilden har laddats upp!</strong></div>';

		private static $ErrorUPLOAD_ERR_TYPE = '<div class="alert alert-danger alert-dismissible" role="alert">
  							 				    <button type="button" class="close" data-dismiss="alert">
  											    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  										        <strong>Bilden måste vara av typen gif,jepg,jpg eller png!</strong></div>';



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
		private function DidHasSubmit() {
			return $this->uploadPage->hasSubmitToUpload();
		}

		private function getFileName() {
			 return $this->uploadPage->GetImgName();
		}

		private function GetComment() {
			return $this->uploadPage->getComments();
		}



		//Send image path to validation class.
		private function getImgPath() {
			$this->validation->getImgRoot($this->imgRoot);
		}

		// Get input and other stuff from available view class.
		private function hasSubmitToDelImg() {
			return $this->available->hasSubmitToDel();
		}

		private function hasSubmitToEdits() {
			return $this->available->hasSubmitToEdit();
		}

		private function getHiddenID() {
			return $this->available->getHiddenId();
		}

		private function getHiddenImg() {
			return $this->available->getSessionHidden();
		}

		private function getConforimYes() {
			return $this->available->getYesDel();
		}

		private function getConforimNo() {
			return $this->available->getNoDel();
		}

		private function GetImageComments() {
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
						echo '<div class="alert alert-success alert-dismissible" role="alert">
  							 				    <button type="button" class="close" data-dismiss="alert">
  											    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  										        <strong> '.$PicName.' togs bort.</strong></div>';

					}
				}
			}

			else if ($this->getConforimNo()) {
				header('Location: ?page=Avaliable');	
			}		
		}

		private function GetSaveds() {
			return $this->available->GetSaved();
		}

		private function getHiddenImgEdit() {
			return $this->available->getSessionHiddenEdit();
		}

		//Edit comments
		private function EditImagesInfo() {
			if ($this->hasSubmitToEdits()) {
				$this->available->renderEditUploadedInformation();
			}
				$Images = glob("src/view/Images/*.*");
				foreach ($Images as $value) {
					if (basename($value) == $this->getHiddenImgEdit()) {
						if($this->GetSaveds()) {
								$images = new Images($this->getHiddenImgEdit(),$this->GetImageComments());
							  	$this->imagesModel->EditImagesInformation($images);
							  	echo '<div class="alert alert-success alert-dismissible" role="alert">
  							 				    <button type="button" class="close" data-dismiss="alert">
  											    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  										        <strong> Uppdatering av '.$this->getHiddenImgEdit(). '  har sparat!</strong></div>';

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

							//Get image name and image extension to add a counter to the exists image.
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

							// Create a new image from file or URL.
							$imgCreateFromJ = imagecreatefromjpeg($_FILES[$this->fileName]['tmp_name']);
							// Get image width and height.
							$imgWidth =	getimagesize($_FILES[$this->fileName]['tmp_name'])[0];
							$imgHeigth = getimagesize($_FILES[$this->fileName]['tmp_name'])[1];

							$newImgWidth = 400;
							$newImgHeight = ($imgHeigth/$imgWidth) * $newImgWidth;
							//Create a new true color image
							$ImgCreateColor = imagecreatetruecolor($newImgWidth, $newImgHeight);
							//Copy and resize part of an image with new image size.
							imagecopyresampled($ImgCreateColor, $imgCreateFromJ, 0, 0, 0, 0, $newImgWidth, $newImgHeight, $imgWidth, $imgHeigth);
							// creates a JPEG from uploaded image.
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