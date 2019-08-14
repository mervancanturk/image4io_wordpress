<?php 

	include('class/image4io.class.php');

	

	header('Content-type: application/json');

	$apiKey = $_POST['apiKey'];

	$apiSecret = $_POST['apiSecret'];

	$path = $_POST['path'];



	global $image;

	$image = new Image4IO($apiKey,$apiSecret);

	

	switch($_GET['get']) {

		case 'createFolder';

			$folder = $_POST['folder'];

			$folderName = $_POST['folderName'];

			$folders = $image->createfolder($folder.'/'.$folderName);

			echo $folders['content'];

		break;

		

		case 'fetch';

			$folder = $_POST['folder'];

			$url = $_POST['url'];

			$fetch = $image->fetch($url,$folder);

			echo $fetch['content'];

		break;

		

		case 'imageUpload';

			if($_POST) {

				$content = $image->upload($_FILES['file'],$_POST['folder']);

				echo $content['content'];

			}

		break;

		

		case 'deleteFiles';

			if($_POST) {

				if($_POST['type'] == 'folder') {

					$content = $image->deletefolder($_POST['filesName']);

				}else {

					$content = $image->delete($_POST['filesName']);

				}

				

				echo $content['content'];

			}

		break;

		

		case 'imageDetail';

			if($_POST) {

				$content = $image->get($_POST['filesName']);

				

				echo $content['content'];

			}

		break;

		

		case 'allUpdate';

			for($i = 0; $i <= 10; $i++) {

				//echo $i;

				$data = array('progres' => $i,'content' => array(''),'imageName' => 'mal');

				//sleep(1);

			}

			echo json_encode($data);

			/*if($_POST) {

				$query_images_args = array(

					'post_type'      => 'attachment',

					'post_mime_type' => 'image',

					'post_status'    => 'inherit',

					'posts_per_page' => - 1,

				);



				$query_images = new WP_Query( $query_images_args );

				print_r($query_images);

				//$last = end($query_images->posts);

				//$image_id = $last->ID;

			}*/

		break;

	}