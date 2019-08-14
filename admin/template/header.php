<script src="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>

<script type="text/javascript">

	var i = 0;
	var data = [];
	var plugin_option = {'plugin_dir':'<?php echo $plugin_dir; ?>','apiKey':'<?php echo $apiKey; ?>','apiSecret':'<?php echo $apiSecret; ?>','path':'<?php echo $path; ?>'};
	var message = {

			'success' : {
				'upload' : '<?php echo _e('upload_success','image4io'); ?>',
				'deleteSuccess' : '<?php echo _e('deleteSuccess','image4io'); ?>',
				'createFolder' : '<?php echo _e('createFolderSuccess','image4io'); ?>',
				'fetchedFileSucces' : '<?php echo _e('fetchedFileSuccess','image4io'); ?>',
				'allupload' : '<?php echo _e('allupload','image4io'); ?>'
			},

			'error' : {
				'deleteError' : '<?php echo _e('deleteError','image4io'); ?>',
				'createFolder' : '<?php echo _e('createFolderError','image4io'); ?>',
				'fetchedFileError' : '<?php echo _e('fetchedFileError','image4io'); ?>'
			},
		
			'detail' : {
				'mxlayerTitle' : '<?php echo _e('mxlayerTitle','image4io'); ?>'
			}
	}
	

	//var ajaxurl = <?php admin_url('admin-ajax.php'); ?>;
</script>