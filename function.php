<?php

add_action('admin_menu', 'extra_post_info_menus');

ob_start();

function extra_post_info_menus()
{
	$page_title = 'image4io';
	$menu_title = 'image4io';
	$capability = 'manage_options';
	$menu_slug  = 'image4io';
	$function   = 'image4io';
	$icon_url   = '';
	$position   = 33;

	add_menu_page(
		$page_title,
		$menu_title,
		$capability,
		$menu_slug,
		$function,
		$icon_url,
		$position
	);
}



function myload_plugin_textdomain()
{

	$domain = plugin_dir_path(__FILE__);

	load_plugin_textdomain('image4io', false, $domain . 'language/');

	return load_textdomain('image4io', $domain . 'language/tr_TR.mo');
}

add_action('init', 'myload_plugin_textdomain');



function image4io()
{

	$apiKey = get_option('image4io_apiKey');

	$apiSecret = get_option('image4io_apiSecret');

	$path = get_option('image4io_path');

	$plugin_dir = plugin_dir_url(__FILE__);

	if ($apiKey != '' && $apiSecret != '') {

		$image = new Image4IO($apiKey, $apiSecret);

		$connect = $image->connect();

		$connect = json_decode($connect['content']);

		if ($connect->Message == '') {

			switch (@$_GET['get']) {

				case '';
					include('admin/template/settings.php');
					break;

				case 'allUpdate';
					if ($_POST) {
						$id = $_POST['id'];
						$query_images_args = array(
							'post_type'      => 'attachment',
							'post_mime_type' => 'image',
							'post_status'    => 'inherit',
							'posts_per_page' => -1,
						);

						$query_images = new WP_Query($query_images_args);
						//print_r($query_images->posts[$id]->ID);
						$toplam = count($query_images->posts);
						$data = wp_get_attachment_metadata($query_images->posts[$id]->ID);
						$url = wp_get_attachment_url($query_images->posts[$id]->ID);
						$content = $image->fetch($url, '/');
						$id = $id++;
						$data = array('progres' => $id, 'content' => $content['content'], 'imageName' => $data['file'], 'return_id' => $id, 'count' => $toplam);
						wp_send_json($data);
					}
					break;
			}
		} else {
			echo '
				<style type="text/css">
					.alert {
					  padding: 20px;
					  background-color: #f44336; /* Red */
					  color: white;
					  margin-bottom: 15px;
					}
				</style>

				<div class="alert" style="display:block;"> 
				  Bağlantı başarısız.
				</div>
			';
		}
	} else {
		switch (@$_GET['get']) {
			case '';
				if ($_POST) {
					add_option('image4io_apiKey', $_POST['image4io_apiKey']);
					add_option('image4io_apiSecret', $_POST['image4io_apiSecret']);
					add_option('image4io_path', $_POST['image4io_path']);
					echo '
						<style type="text/css">
							.alert {
							  padding: 20px;
							  background-color: #f44336; /* Red */
							  color: white;
							  margin-bottom: 15px;
							}
						</style>
						<div class="alert" style="display:block;"> 
						  Api bilgileriniz tanımlandı. Doğruluğu kontrol ediliyor.
						</div>
					';
					echo '<meta http-equiv="refresh" content="1;">';
				}

				include('admin/template/api_key.php');
				break;
		}
	}
}



add_action('after_setup_theme', 'layout2job_func', 99);
