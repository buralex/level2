<?php

/**
 * Created by PhpStorm.
 * User: alex
 * Date: 09.05.2017
 * Time: 14:25
 */
class View implements Iterator
{
	protected $data=[];  // for overloading properties images(items), error

	public function __set($name, $value)
	{
		$this->data[$name] = $value;
	}

	public function __get($name)
	{
		return $this->data[$name];
	}


	public function render($template)
	{
		foreach ($this->data as $key => $val) {
			$$key = $val;  // creates variable named like $key, and assigns $val to it
		}
		ob_start();
		include_once ROOT . "/views/" . $template;
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}

	public function display($template)
	{
		echo $this->render($template);
	}

	public function current()
	{

	}


	public function next()
	{

	}

	public function key()
	{

	}

	public function valid()
	{

	}


	public function rewind()
	{

	}
}