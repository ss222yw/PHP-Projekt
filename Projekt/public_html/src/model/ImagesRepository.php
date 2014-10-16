// <?php
	

// 	//TODO:: Should i really save the image name in the databse ??? When it is just the Admin who can upload image!
// 	class ImagesRepository extends Database {


// 		private static $imgId  = "imgId";
// 		private static $imgName = "imgName";
// 		private static $uniqueKey = "uniqueKey";

// 		public function __construct() {
// 			$this->tabel = "pictures";
// 		}


// 		public function AddPics(Images $img) {

// 			try {	
// 					//$f = new ImagesRepository();
// 					$db = $this->connectionToDataBase();
// 					$sql = "INSERT INTO $this->tabel (".self::$imgName.", " .self::$uniqueKey. ")VALUES(?,?)";
// 					$params = array($img->getImgName(),$img->getImgUniqueKey());
// 					$query = $db->prepare($sql);
// 					$query->execute($params);
						
// 			} catch (PDOException $ex) {

// 				echo $ex;
// 				//die('An unknown error hase happened');
// 			}
// 		}


// 		public function get() {
// 			try {	
// 					// $f = new ImagesRepository();
// 					$db = $this->connectionToDataBase();
// 					$sql = "SELECT * FROM $this->tabel" ;
// 					$query = $db->prepare($sql);
// 					$query->execute();
// 					$result = $query->fetch();
// 					var_dump($result);
// 					if ($result) {
// 						return $Images =  new Images($result[self::$imgName], $result[self::$uniqueKey]);
// 					}
// 					return null;
				
// 			} catch (Exception $e) {
// 				echo $e;
// 			//	die('An unknown error hase happened');
// 			}

// 		}


// 		public function delete($img) {
// 			var_dump($img);
 
// 			try {
// 					//$f = new ImagesRepository();
// 					$db = $this->connectionToDataBase();
// 					$sql = "DELETE FROM $this->tabel WHERE".self::$imgName. "=?";
// 					$query = $db->prepare($sql);
// 					$params = array($img);
// 					$query->execute($params);
				
// 			} catch (Exception $e) {
// 				echo $e;
// 			//	die('An unknown error hase happened');
				
// 			}
// 		}

// 	}