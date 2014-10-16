<?php
	

	//TODO:: Remove the class or continue....
	class Images {

		private $imgName;
	    private $uniqueKey;

		public function __construct($imgName,$uniqueKey = NULL) {
	
			$this->imgName = $imgName;
			if (empty($uniqueKey)) {
				# code...
				$this->uniqueKey = $this->uniqid();
			}
			else {

				 $this->uniqueKey = $uniqueKey;
				}

		} 

		public function uniqid() {
			return $this->uniqueKey = uniqid();
		}


		public function getImgName() {
			return $this->imgName;
		}


		public function getImgUniqueKey() {
			return $this->uniqueKey;
		}

	}