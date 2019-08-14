<?php 
	include('class/image4io.class.php');
	header('Content-type: application/json');

	$files = array();
	$apiKey = $_POST['apiKey'];
	$apiSecret = $_POST['apiSecret'];
	$path = $_POST['path'];
	$dirs = @$_POST['dir'];

	//echo $dirs;
	global $image;
	$image = new Image4IO($apiKey,$apiSecret);
	

	function files($dir){
		global $image;
		$file = array();
		$files = $image->listfolder($dir);
		$files = json_decode($files['content']);

		foreach($files->folders as $val) {
			if($val->parent == '/') {
				$parent = $val->parent.$val->name;
			}else {
				$parent = $dir.'/'.$val->name;
			}
			if($val->name == @$dirs || @$dirs == '') {

				$file[] = array(
					"name" => $val->name,
					"type" => "folder",
					"path" => $parent
				);
			}
		}

		foreach($files->files as $val) {
			if(@$dir.@$files->folder == $dir) {
				$file[] = array(
					"name" => $val->name,
					"original_name" => $val->orginal_name,
					"type" => "file",
					"path" => @$dir.@$files->folder,
					"format" => $val->format,
					"createdAt" => $val->createdAt,
					"width" => $val->width,
					"height" => $val->height,
					"size" => $val->size
				);
			}
		}

		return $file;
	}

	

	echo json_encode(files(@$dirs));