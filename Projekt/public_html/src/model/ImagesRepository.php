<?php
	

 	//TODO:: Should i really save the image name in the databse ??? When it is just the Admin who can upload image!
 	class ImagesRepository extends Database {


 		private static $imgId  = "imgId";
 		private static $imgName = "imgName";
 		private static $Comment = "Comment";



 		public function __construct() {
 			$this->tabel = "pictures";
 		}


 		public function AddPics(Images $img) {
 			try {	
 					$db = $this->connectionToDataBase();
 					$sql = "INSERT INTO $this->tabel (".self::$imgName. ", " .self::$Comment. ")VALUES(?,?)";
 					$params = array($img->getImgName(),$img->GetMSG());
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


 		public function saveEdit(Images $img) {
			try {
				$db = $this->connectionToDataBase();
				$sql = "UPDATE $this->tabel SET " . self::$Comment . " = ? WHERE imgName = ?";
				$params = array($img->GetMSG(),$img->getImgName());
				$query = $db->prepare($sql);
				$query->execute($params);
			}
			catch (Exception $e) {
				echo $e;
			}
		}

		public function getImagesInformation($name) {
			try {
				$f = new ImagesRepository();
				$db = $f->connectionToDataBase();
				$sql = "SELECT * FROM  $this->tabel WHERE imgName = ?";
				$params = array($name);
				$query = $db->prepare($sql);
				$query->execute($params);
				$results = $query->fetchAll();
				if($results) {
					foreach($results as $result) {
						return new Images($result[self::$imgName], $result[self::$Comment]);
					}
				}
				return NULL;
			}
			catch (Exception $e) {
				echo $e;
			}
		}
	
 }