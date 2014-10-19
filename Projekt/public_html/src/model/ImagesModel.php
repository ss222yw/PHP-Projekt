<?php
	
 	class ImagesModel {

 		private $imagesRepository;

 		public function __construct() {

 			$this->imagesRepository = new ImagesRepository();
 		}

 		public function removeImages($img) {

 			$this->imagesRepository->delete($img);
						 
 		}

 		public function addImages(Images $img) {
 			 $this->imagesRepository->AddPics($img);
 		}
 	}