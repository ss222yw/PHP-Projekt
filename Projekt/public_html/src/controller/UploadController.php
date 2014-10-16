<?php

	class UploadController {

		private $validation;
		private $imagestypes;
	    private $imgRoot;
	    private $uploadPage;
	    private $fileName;
	    private $delImage;
	    private $imagesRepository;
	    private $images;
	    private $imgName;
	    private $uniqueKey;
	    private $imagesModel;

		private static $UPLOADEDSUCCESSED = "Bilden har laddats upp!";
		private static $ErrorUPLOAD_ERR_TYPE = "Bilden måste vara av typen gif,jepg,jpg eller png!";	


		public function __construct() {

			$this->validation = new validation();
			$this->imgRoot = getcwd()."/src/view/Images/";
			$this->uploadPage = new upload();
			// $this->imagesRepository = new ImagesRepository();
			$this->available = new available();
			$this->fileName = $this->getFileName();
		// 	$this->uniqueKey = uniqid();
		// //	$this->images = new Images($this->getImgName());
		// 	$this->imagesModel = new IMagesModel();

		}


		public function DidHasSubmit() {
			return $this->uploadPage->hasSubmitToUpload();
		}

		public function getFileName() {
			 return $this->uploadPage->GetImgName();
		}

		public function getImgPath() {
			$this->validation->getImgRoot($this->imgRoot);
		}

		public function hasSubmitToDelImg() {
			return $this->available->hasSubmitToDel();
		}

		// public function addImageToDb() {

		// 	$this->images = new Images($this->imgName,$this->uniqueKey);
		// 	$this->imagesModel->addImages($this->images);				 			
		// }

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

		public function removeImageFromFolder() {
			
			if ($this->hasSubmitToDelImg()) {
				# code...
				$Images = glob("src/view/Images/*.*");
			foreach ($Images as $value) {
				if (basename($value) == $this->getHiddenID()) {
				  $this->available->renderAreYouSure();
				}
			}

		
			}

				if ($this->getConforimYes()) {
				# 	code...

					$Images = glob("src/view/Images/*.*");
			foreach ($Images as $value) {
				if (basename($value) == $this->getHiddenImg()) {
				unlink($value);
				$PicName =basename($value);
				echo "$PicName togs bort.";
				}
			}
				//$this->removeImageFromDb();
			}
			else if ($this->getConforimNo()) {
				# code...
				header('Location: ?page=upload');	
			}

			
					
		}

		// public function getImgNameFromDb() {
		// 	$this->images = new Images($this->imgName,$this->uniqueKey);
		// 	$unique = $this->images->getImgUniqueKey();
		// 	//var_dump($unique);
		// 	//$imgID = $this->imagesRepository->get();
		// 	//var_dump($imgID);
		// 	//$this->imagesModel->getImgFromDb();
		// 	//$this->available->deleteImg($imgID);
		// } 
	
	

		public function imgUpload() {
			$this->uploadPage->RenderUploadForm();
			$this->removeImageFromFolder();
			//$this->available->renderAllPics();
			// $heja =
			// $hejaId = $heja[0];
			// $this->available->deleteImg($heja);
			// var_dump($hejaId);
			$counter = 1;
			$this->validation->getFileName($this->fileName);
	
			
			// else{echo "gick ej att ta bort bilden. :(";}	

			if ($this->DidHasSubmit() == true) {
				# code...
				if (is_uploaded_file($_FILES[$this->fileName]['tmp_name'])) {
					# code...
					if (exif_imagetype($_FILES[$this->fileName]['tmp_name']) == IMAGETYPE_GIF ||
						 exif_imagetype($_FILES[$this->fileName]['tmp_name']) == IMAGETYPE_JPEG ||
						 	 exif_imagetype($_FILES[$this->fileName]['tmp_name']) == IMAGETYPE_PNG) {
						# code...
						if (file_exists($this->imgRoot.$_FILES[$this->fileName]['name'])) {
							# code...
							$FileNameInfo = new SplFileInfo($_FILES[$this->fileName]['name']);
							$extension = $FileNameInfo->getExtension();
							$pointEx = substr(strrchr($_FILES[$this->fileName]['name'],"."), -4);
							$FileNameWithOutEx = $FileNameInfo->getBasename($pointEx);

							while (file_exists($this->imgRoot.$_FILES[$this->fileName]['name'])) {
								# code...
								$_FILES[$this->fileName]['name'] = $FileNameWithOutEx."(".$counter++.")." . $extension;
							}
						}
						if ($_FILES[$this->fileName]['size'] < 5000000) {
							# code...
							 	if (move_uploaded_file($_FILES[$this->fileName]['tmp_name'], $this->imgRoot.$_FILES[$this->fileName]['name']) == true) {
							 		# code...
							 			// $this->imgName = $_FILES[$this->fileName]['name'];
							 			
							 			// $this->addImageToDb();	

							 			$this->available->renderAllPics();

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