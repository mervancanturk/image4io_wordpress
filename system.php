<?php

ini_set( 'upload_max_size' , '10M' );
ini_set( 'post_max_size', '10M');
ini_set( 'max_execution_time', '300' );

function layout2job_func()
{
	remove_action('init', 'my_deregister_heartbeat', 100);
}



function admin_script()
{

	wp_deregister_script('jquery');

	wp_register_script('jquery', '//code.jquery.com/jquery-1.11.3.min.js', array(), '1.11.3');

	wp_enqueue_script('jquery-mxlayer', plugin_dir_url(__FILE__) . 'admin/assets/js/jquery.mxlayer.js');

	wp_enqueue_style('jquery-mxlayer', plugin_dir_url(__FILE__) . 'admin/assets/css/jquery.mxlayer.css');

	wp_enqueue_style('styles', plugin_dir_url(__FILE__) . 'admin/assets/css/styles.min.css');

	wp_enqueue_script('jquery-form', plugin_dir_url(__FILE__) . 'admin/assets/js/jquery.form.min.js', array('jquery'), '', true);

	wp_enqueue_script('jquery-script', plugin_dir_url(__FILE__) . 'admin/assets/js/script.min.js', array('jquery'), '', true);
}



add_action('admin_enqueue_scripts', 'admin_script');



function add_media_button()
{

	printf('<a href="%s" onclick="folderOpen(\'#main-template\')" class="button my-button my-custom-button" id="my-custom-button">' . '<span class="icon-image2vector"></span> %s' . '</a>', 'javascript:;', __('image4io', 'textdomain'));
}

add_action('media_buttons', 'add_media_button');



add_action('admin_footer', 'my_deregister_heartbeat');

function my_deregister_heartbeat()
{

	global $pagenow;

	if ('post.php' == $pagenow || 'post-new.php' == $pagenow)

		echo '';

	$apiKey = get_option('image4io_apiKey');

	$apiSecret = get_option('image4io_apiSecret');

	$path = get_option('image4io_path');

	$plugin_dir = plugin_dir_url(__FILE__);

	include(plugin_dir_path(__FILE__) . 'admin/template/modal.php');
}


function add_main_menu($admin_bar)
{

	$args = array(

		'id'        => 'image4io_menu', // Must be a unique name

		'title'     => '<span class="icon-image2vector"></span> image4io', // Label for this item

		'href'      => 'admin.php?page=image4io'

	);

	$admin_bar->add_menu($args);
}

add_action('admin_bar_menu', 'add_main_menu', 33);



add_action('wp_ajax_mycustom_action', 'mycustom_action');

add_action('wp_ajax_nopriv_mycustom_action', 'mycustom_action');





$apiKey = get_option('image4io_apiKey');

$apiSecret = get_option('image4io_apiSecet');

$path = get_option('image4io_path');

global $image;

$image = new Image4IO($apiKey, $apiSecret);



function mycustom_action()
{

	global $image;

	$id = $_POST['repost_id'];



	$query_images_args = array(

		'post_type'      => 'attachment',

		'post_mime_type' => 'image',

		'post_status'    => 'inherit',

		'posts_per_page' => -1,

	);



	$query_images = new WP_Query($query_images_args);

	$toplam = count($query_images->posts);

	$data = wp_get_attachment_metadata($query_images->posts[$id]->ID);

	$url = wp_get_attachment_url($query_images->posts[$id]->ID);

	$content = $image->fetch($url, '/');



	$data = array('progres' => $id, 'content' => $content['content'], 'imageName' => $data['file'], 'return_id' => $id, 'count' => $toplam, 'success' => true);



	echo json_encode($data);

	die();
}
?>