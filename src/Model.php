<?php 
	/**
	 * 
	 */
	class Model
	{
		static $connections = array();
		public $conf  = 'default';
		public $table = false;
		public $db;

		public function __construct()
		{
			//Je me connecte à la base de données
			$conf = Conf::$databases[$this->conf];
			if (isset(Model::$connections[$this->conf])) {
				$this->db = Model::$connections[$this->conf];
				return true;
			}
			try{
				$pdo = new PDO(
					'mysql:host='.$conf['host'].';dbname='.$conf['database'].';',
					$conf['login'],
					$conf['password'],
					array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')
				); 
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
				Model::$connections[$this->conf] = $pdo;
				$this->db = $pdo;
			} catch(PDOException $e){
				if (Conf::$debug >= 1) {
					die($e->getMessage());
				}else{
					die('Impossible de se connecter à la base de données');
				}
				
			}

			//J'initialise quelques variables
			if ($this->table === false) {
				$this->table = strtolower(get_class($this)).'s';
			}
		}

		public function find($req){			
			$sql = 'SELECT * FROM '.$this->table.' as '.get_class($this).' ';
			
			//Je construis les conditions
			if (isset($req['conditions'])) {
				$sql .= 'WHERE ';
				if (!is_array($req['conditions'])) {
					$sql .= $req['conditions'];
				} else{
					$cond = array();
					foreach ($req['conditions'] as $key => $value) {
						if (!is_numeric($value)) {
							//$value = mysqli_real_escape_string($value);
							$value = '"'.$value.'"';
						}
						
						$cond[] = "$key=$value";
					}
					$sql .= implode(' AND ', $cond);
				}
			}


			$pre = $this->db->prepare($sql);
			$pre->execute();
			return $pre->fetchAll(PDO::FETCH_OBJ);
		}

		public function findFirst($req){
			return current($this->find($req));
		}
	}
?>