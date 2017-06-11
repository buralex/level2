<?php

/**
 * Created by PhpStorm.
 * User: alex
 * Date: 06.05.2017
 * Time: 14:25
 */


abstract class AbstractModel //implements //IModel
{
	protected static $table;

	protected $data=[]; // for fields from table title, path, id

	public function __set($name, $value)
	{
		$this->data[$name] = $value;
	}
	public function __get($name)
	{
		if (array_key_exists($name, $this->data)) {
			return $this->data[$name];
		}
	}
	public function __isset($name)
	{
		return isset($this->data[$name]);
	}

	public static function getAll()
	{

		$class = get_called_class();
		$db = new DB();
		$sql = 'SELECT * FROM ' . static::$table;

		$res = $db->query($sql);

		$db = null;
		return $res;
	}
	public static function getOne($id)
	{
		$db = new DB();
		$sql = 'SELECT * FROM ' . static::$table . ' WHERE id = :id';

		$row = $db->query($sql,[':id'=> $id])[0];

		$db = null;
		return $row;
	}

	public static function getOneByColumn($column, $value)
	{
		$db = new DB();
		$sql = 'SELECT * FROM ' . static::$table . ' WHERE ' . $column . '= :value';


		$row = $db->query($sql,[':value' => $value]);
		$db = null;
		if (empty($row)) {
			throw new CustomException('can not be found');
		}
		if (!empty($row)){
			return $row[0];
		}
	}

	public static function file_upload($name)
	{
		if (empty($_FILES) ) {
			return false;
		}
		if ($_FILES[$name]['error'] != 0) {
			return false;
		}
		if (is_uploaded_file($_FILES[$name]['tmp_name'])) {
			$res = move_uploaded_file($_FILES[$name]['tmp_name'], ROOT . "/img/" . $_FILES[$name]['name'] );
		}
		if (!$res) {
			return false;
		} else {
			return $_FILES[$name]['name'];
		}
		return false;
	}

	private function insert_one()
	{
		//$cols = array_keys($this->data);
		$dataIns = [];
//		foreach ($cols as $col){
//			$inserts[] = ':' . $col;  // for prepared statements title and path
//		}
		foreach ($this->data as $key => $val) {
			$dataIns[':' . $key] = $val;  // for prepared statements title and path
		}
//		var_dump($dataIns);
//		die();
		//var_dump($this->data);

		$sql = 'INSERT INTO ' . static::$table
			. ' ('	. implode(', ', array_keys($this->data)) . ')'
			. ' VALUES' . ' ('	. implode(', ', array_keys($dataIns)) . ')';
//		echo $sql;
//		var_dump($dataIns);
//		die;

		$db = new DB();

		$db->execute($sql, $dataIns);

//		foreach ($cols as $col) {
//			$db->bind( ':'. $col, $this->data[$col]);  // binding params
//		}

		$this->id = $db->lastInsertId();

		$db = null;
	}

	private function update()
	{
		$cols = [];
		$dataIns = [];
		foreach ($this->data as $key => $val) {
			$dataIns[':' . $key] = $val;
			if ( $key == 'id') {
				continue;
			}
			$cols[] = $key . '=:' . $key;  // title = :title, ...
		}

		$sql = 'UPDATE ' . static::$table . ' SET ' . implode(', ', $cols) . ' WHERE id = :id';
		//var_dump($sql);
		//var_dump($dataIns);
		$db = new DB();
		$db->query($sql, $dataIns);

//		foreach ($dataIns as $ins => $val) {
//			$db->bind( $ins, $val);  // binding params
//		}
//		$db->execute($dataIns);
		//$this->id = $db->lastInsertId();
		$db = null;
	}

	public function save()
	{
		if (!isset($this->id)) {
			$this->insert_one();
		} else {
			$this->update();
		}
	}
}