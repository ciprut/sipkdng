<?
	class Mssql {
	
		private $host = "e-Budgeting";
		private $user = "sa";
		private $pass = "12345678";
		private $db_name = "V@LID49V6_"; //prefix db name
/*SERVER
*/
		//SERVER LOKAL : LAPTOP-JDHRKNQP
/*
		private $host = "e-Budgeting";
		private $user = "sa";
		private $pass = "12345678";
		private $db_name = "simda";
/**/

		private $dbh;
		private $stmt;

		public function __construct() {
			$dsn = 'sqlsrv:Server=' . $this->host . ';Database='.$this->db_name.session()->tahun;
			//$dsn = 'sqlsrv:Server=' . $this->host . ';Database=batu'.session()->tahun;
			$options = array(
				PDO::ATTR_ERRMODE       => PDO::ERRMODE_EXCEPTION
			);
			try {
				$this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
			} 
			catch(PDOException $e) {
				echo $e;
				die($e->getMessage());
			}
		}

		public function prepare($query) {
			$this->stmt = $this->dbh->prepare($query);
		}

		public function bind($param, $value, $type=null) {    
			if(is_null($type)) {         
				switch (true) {              
					case is_int($value):                  
					$type = PDO::PARAM_INT;                  
					break;              
					case is_bool($value):                  
					$type = PDO::PARAM_BOOL;                  
					break;              
					case is_null($value):                 
					$type = PDO::PARAM_NULL;                 
					break;             
					default:                 
					$type = PDO::PARAM_STR;                 
					break;           
				}     
			}     
			$this->stmt->bindValue($param, $value, $type);
		}

		public function rowCount($q){
			$this->stmt = $this->dbh->prepare($q);
			$this->stmt->execute();
			$count = $this->stmt->rowCount();
			return $count;
		}

		public function query($q){
			try{
				$this->stmt = $this->dbh->prepare($q);
				$this->stmt->execute();
				return true;
			}catch(PDOException $e){
				echo $e->getMessage();
				return false;
			}
		}
		
		public function view($q){
			$this->stmt = $this->dbh->prepare($q);
  			$this->stmt->execute();
			$resulset = $this->stmt->fetchAll(PDO::FETCH_BOTH);
			return $resulset;
		}

		public function exec($q){
			$this->stmt = $this->dbh->prepare($q);
  			$this->stmt->execute();
			$resulset = $this->stmt->fetchAll(PDO::FETCH_ASSOC);
			return $resulset;
		}
		
		public function viewSingle($q){
			$this->stmt = $this->dbh->prepare($q);
  			$this->stmt->execute();
			$resulset = $this->stmt->fetch(PDO::FETCH_BOTH);
			return $resulset;
		}
	}

