<?php
	

 	//TODO:: Should i really save the image name in the databse ??? When it is just the Admin who can upload image!
 	class ImagesRepository extends Database {


 		private static $imgId  = "imgId";
 		private static $imgName = "imgName";
 		private static $uniqueKey = "uniqueKey";

 		public function __construct() {
 			$this->tabel = "pictures";
 		}


 		public function AddPics(Images $img) {
 			try {	
 					//$f = new ImagesRepository();
 					$db = $this->connectionToDataBase();
 					$sql = "INSERT INTO $this->tabel (".self::$imgName. ")VALUES(?)";
 					$params = array($img->getImgName());
 					$query = $db->prepare($sql);
 					$query->execute($params);
						
 			} catch (PDOException $ex) {

 				echo $ex;
 				//die('An unknown error hase happened');
 			}
 		}


 		public function delete($img) {
 
 			try {
 					$db = $this->connectionToDataBase();
 					$sql = "DELETE FROM $this->tabel WHERE imgName = ?";
 					$params = array($img);
 					$query = $db->prepare($sql);
					$query->execute($params);
				
 			} catch (Exception $e) {
 				echo $e;
 			//	die('An unknown error hase happened');
				
 			}
 		}

 	}