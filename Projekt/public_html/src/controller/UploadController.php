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

		private static $UPLOADEDSUCCESSED = "Bilden har laddats upp!";
		private static $ErrorUPLOAD_ERR_TYPE = "Bilden måste vara av typen gif,jepg,jpg eller png!";	


		public function __construct() {

			$this->validation = new validation();
			$this->imgRoot = getcwd()."/src/view/Images/";
			$this->uploadPage = new upload();
			$this->imagesRepository = new ImagesRepository();
			$this->available = new available();
			$this->fileName = $this->getFileName();

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


		public function imgUpload() {

		$this->uploadPage->RenderUploadForm();

			$counter = 1;
			$this->validation->getFileName($this->fileName);

			// $Images = glob("src/view/Images/*.*");
			// if ($this->hasSubmitToDelImg() == true) {
			// 	# code... 
			// 	foreach ($Images as $value) {
			// 			unlink($value);
			// 	}
			// }
			// else{}	

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
						if ($_FILES[$this->fileName]['size'] < 2000000) {
							# code...
							 	if (move_uploaded_file($_FILES[$this->fileName]['tmp_name'], $this->imgRoot.$_FILES[$this->fileName]['name']) == true) {
							 		# code...
							 			$this->images = new Images($_FILES[$this->fileName]['name']);
							 			
							 			$this->imagesRepository->AddPics($this->images);
							 			
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