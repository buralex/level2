<?php

use Application\Models\Images;
//require_once __DIR__ . '/../models/Images.php';

class ImagesController
{
	public function actionAll()
	{

//		$im = ImagesModel::getOneByColumn('id', '59');
//		$im->save();


		//var_dump($im);
		//$im = new ImagesModel();

//		$im->title = 'new title 11111';
//		$im->path = '6546546fsdfsdf';

//
//		$im->insert_one();
//
//		var_dump($im->id);

		$images = Images::getAll();
		$view = new View();
		$view->items = $images;
		//var_dump($images);

		$view->display('images/all.php');
		//var_dump($view->items);
	}
	public function actionOne($id)
	{
		//$id = $_GET['id'];
		$image = Images::getOne($id);

		$view = new View();
		$view->item = $image;
		$view->display('images/one.php');
	}

	public static function actionAddOne()
	{
		if (!empty($_POST)) {
			$data = []; // for title and path of the image

			if (!empty($_POST['title'])) {
				$data['title'] = $_POST['title'];
			}
			if (!empty($_FILES)) {
				$res = Images::file_upload('path');

				if ($res !== false) {
					$data['path'] = $res;
				}
			}

			if (isset($data['title']) && isset($data['path'])) {

				$img_obj = new Images();

				$img_obj->title = $data['title'];  // it will go to $img_obj->((private)data array)
				$img_obj->path = $data['path'];
				$img_obj->save();

				header("Location: /" );
			}
		}
	}
}