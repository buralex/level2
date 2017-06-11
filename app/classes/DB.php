<?php

class DB
{
	private $dbh;
	private $class_name = 'stdClass';

	public function __construct()
	{
		try	{
			$paramsPath = ROOT .'/config_db.php';
			$params = include($paramsPath);
			$this->dbh = new PDO("mysql:host={$params['servername']};dbname={$params['dbname']}", $params['username'], $params['password']);
		}

		catch(PDOException $e)
		{
			echo "Error: " . $e->getMessage();
		}

	}

	public function set_class_name($class_name)
	{
		$this->class_name = $class_name;
	}

	public function query($sql, $params=[])
	{
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute($params);
		return $stmt->fetchAll(PDO::FETCH_CLASS, $this->class_name);
	}

	public function queryAssoc($sql, $params=[])
	{
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute($params);
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function execute($sql, $params=[])
	{
		$stmt = $this->dbh->prepare($sql);
		$stmt->execute($params);
	}

	public function lastInsertId() {
		return $this->dbh->lastInsertId();
	}
}

//var_dump($username);
//class DB{
//	private $host = DB_HOST;
//	private $dbName = DB_NAME;
//	private $user = DB_USER;
//	private $pass = DB_PASS;
//
//	private $dbh;
//	private $error;
//	private $qError;
//
//	private $stmt;
//
//	public function __construct(){
//		//dsn for mysql
//		$dsn = "mysql:host=".$this->host.";dbname=".$this->dbName;
//		$options = array(
//			PDO::ATTR_PERSISTENT    => true,
//			PDO::ATTR_ERRMODE       => PDO::ERRMODE_EXCEPTION
//		);
//
//		try{
//			$this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
//		}
//			//catch any errors
//		catch (PDOException $e){
//			$this->error = $e->getMessage();
//		}
//	}
//
//	public function query($query){
//		$this->stmt = $this->dbh->prepare($query);
//	}
//
//	public function bind($param, $value, $type = null){
//		if(is_null($type)){
//			switch (true){
//				case is_int($value):
//					$type = PDO::PARAM_INT;
//					break;
//				case is_bool($value):
//					$type = PDO::PARAM_BOOL;
//					break;
//				case is_null($value):
//					$type = PDO::PARAM_NULL;
//					break;
//				default:
//					$type = PDO::PARAM_STR;
//			}
//		}
//		$this->stmt->bindValue($param, $value, $type);
//	}
//
//	public function execute($params = null){
//		$this->qError = $this->dbh->errorInfo();
//		if(!is_null($this->qError[2])){
//			echo $this->qError[2];
//		}
//		//echo 'done with query';
//		return $this->stmt->execute($params);
//	}
//
//	public function resultset($className='stdClass'){
//		$this->execute();
//		//return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
//		return $this->stmt->fetchAll(PDO::FETCH_CLASS, $className);
//	}
//
////	public function single($className='stdClass'){
////		$this->execute();
////		//return $this->stmt->fetch(PDO::FETCH_ASSOC);
////		return $this->stmt->fetchAll(PDO::FETCH_CLASS, $className)[0];
////	}
//
//	public function rowCount(){
//		return $this->stmt->rowCount();
//	}
//
//	public function lastInsertId(){
//		return $this->dbh->lastInsertId();
//	}
//
//	public function beginTransaction(){
//		return $this->dbh->beginTransaction();
//	}
//
//	public function endTransaction(){
//		return $this->dbh->commit();
//	}
//
//	public function cancelTransaction(){
//		return $this->dbh->rollBack();
//	}
//
//	public function debugDumpParams(){
//		return $this->stmt->debugDumpParams();
//	}
//
//	public function queryError(){
//		$this->qError = $this->dbh->errorInfo();
//		if(!is_null($this->qError[2])){
//			echo $this->qError[2];
//		}
//	}
//
//}//end class db