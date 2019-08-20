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
	$function_settings   = 'image4io_settings_page';
	$icon_url   = '';
	$position   = 33;

    add_media_page(
		$page_title,
		$menu_title,
		$capability,
		$menu_slug,
		$function,
		$icon_url,
		$position
	);

    add_options_page(
        $page_title,
        $menu_title,
        $capability,
        $menu_slug,
        $function_settings,
        $icon_url,
        $position);
}


//
//function myload_plugin_textdomain()
//{
//
//	$domain = plugin_dir_path(__FILE__);
//
//	load_plugin_textdomain('image4io', false, $domain . 'language/');
//
//	return load_textdomain('image4io', $domain . 'language/tr_TR.mo');
//}
//
//add_action('init', 'myload_plugin_textdomain');
//


function image4io()
{

    $image4io_settings = json_decode(get_option('image4io_settings'));

	$apiKey = $image4io_settings->apikey;

	$apiSecret = $image4io_settings->api_secret;

	$path = $image4io_settings->path;

	$cloudname = $image4io_settings->cloudname;

    var_dump($apiKey,$apiSecret,$path,$cloudname);

	$plugin_dir = plugin_dir_url(__FILE__);

	if ($apiKey && $apiSecret) {


		$image = new Image4IO($apiKey, $apiSecret);

        var_dump($image);

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


	}
}


function image4io_no_valid_api_set() {

    $image4io_settings = json_decode(get_option('image4io_settings'));

    $apiKey = $image4io_settings->apikey;
    $apiSecret = $image4io_settings->api_secret;

    if ($apiKey != null) {

    $image = new Image4IO($apiKey, $apiSecret);
    $connect = $image->connect();

    $resultcode = $connect['headers'][0];

    //var_dump($resultcode);

    if ($resultcode != 'HTTP/2 200 ') {

        $class = 'notice notice-error';
        $message = __( 'image4io API bilgileri doğru değil.', 'sample-text-domain' );
        printf( '<div class="%1$s"><p>%2$s <a href="options-general.php?page=image4io">Düzelt</a></p></div>', esc_attr( $class ), esc_html( $message ) );
    }
    }

}
function image4io_no_api_set() {

    $image4io_settings = json_decode(get_option('image4io_settings'));

    $apiKey = $image4io_settings->apikey;

    if ($apiKey == null) {

        $class = 'notice notice-warning';
        $message = __( 'image4io API bilgileri henüz girilmemiş.', 'sample-text-domain' );
        printf( '<div class="%1$s"><p>%2$s <a href="options-general.php?page=image4io">Düzelt</a></p></div>', esc_attr( $class ), esc_html( $message ) );
    }

}
add_action( 'admin_notices', 'image4io_no_api_set' );
add_action( 'admin_notices', 'image4io_no_valid_api_set' );


$valid_api = false;
function image4io_settings_page()
{

    $image4io_settings = json_decode(get_option('image4io_settings'));

    $apiKey = $image4io_settings->apikey;

    $apiSecret = $image4io_settings->api_secret;

    $path = $image4io_settings->path;

    $cloudname = $image4io_settings->cloudname;

    var_dump($apiKey,$apiSecret,$path,$cloudname);

    $plugin_dir = plugin_dir_url(__FILE__);

    if ($apiKey && $apiSecret) {

        $image = new Image4IO($apiKey, $apiSecret);

        $connect = $image->connect();

        $resultcode = $connect['headers'][0];

        $connect = json_decode($connect['content']);

        var_dump($connect);
        var_dump($resultcode);

        if ($resultcode == 'HTTP/2 200 ') {

            $valid_api = true;

        }
    }
        switch (@$_GET['get']) {
            case '';
                if ($_POST['image4io_formcontrol']) {

                    $tmpsettings = image4io_settings($_POST['image4io_apiKey'],$_POST['image4io_apiSecret'],$_POST['image4io_Cloudname'],$_POST['image4io_Path']);

                    var_dump($tmpsettings);

                    update_option("image4io_settings",$tmpsettings);

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
                    header("refresh: 0;");
                }

                break;

    }
    include('admin/template/api_key.php');
}



add_action('after_setup_theme', 'layout2job_func', 99);

