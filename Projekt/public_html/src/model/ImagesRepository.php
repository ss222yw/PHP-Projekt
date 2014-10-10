<?php
	

	//TODO:: Should i really save the image name in the databse ??? When it is just the Admin who can upload image!
	class ImagesRepository extends Database {


		private static $imgId  = "imgId";
		private static $imgName = "imgName";


		public function __construct() {
			$this->tabel = "pictures";
		}


		public function AddPics(Images $img) {

			try {
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


		public function get($imageName) {

			try {

					$db = $this->connectionToDataBase();
					$sql = "SELECT * FROM $this->tabel WHERE".self::$imgId. "=?";
					$params = array($imageName);
					$query = $db->prepare($sql);
					$query->execute($params);
					$result = $query->fetch();
					var_dump($result);
					return $result;
					
				
			} catch (Exception $e) {

			//	die('An unknown error hase happened');
			}

		}


		public function delete(Images $imgName) {

			try {

					$db = $this->connectionToDataBase();
					$sql = "DELETE FROM $this->tabel WHERE".self::$imgId. "=?";
					$params = array($imgName->getImgName());
					$query = $db->prepare($sql);
					$query->execute($params);
				
			} catch (Exception $e) {

			//	die('An unknown error hase happened');
				
			}
		}

	}