<script type="text/javascript">

	var i = 0;

	var data = [];

	var plugin_option = {'plugin_dir':'<?php echo $plugin_dir; ?>','apiKey':'<?php echo $apiKey; ?>','apiSecret':'<?php echo $apiSecret; ?>','path':'<?php echo $path; ?>'};

</script>

<style type="text/css" id="stylecss">

	

</style>

<script id="sidebar-template" type="text/html">

    <a href="javascript:;" class="media-menu-item" onclick="folderOpen('#main-template')"><?php echo _e('medias','image4io'); ?></a>

    <a href="javascript:;" class="media-menu-item" onclick="folderOpen('#upload-template')"><?php echo _e('image_upload','image4io'); ?></a>

</script>

<script id="main-template" type="text/html">

    <div class="media-frame-contents" data-columns="8">

		<div class="attachments-browser hide-sidebar sidebar-for-errors">

			<div class="hatalar">

				<div class="alert alert-danger"> 

					<span></span>

				</div>

				<div class="alert alert-success success"> 

					<span></span>

				</div>

			</div>

		</div>

		<div style="clear:both; width:100%; display:block; overflow: auto;">

			<ul class="bread">

															

			</ul>

		</div>

		<div style="display:block; width:100%; clear:both;">

			<ul tabindex="" data-block="0" class="attachments ui-sortable ui-sortable-disabled fileOkey image4ioList" id="fileList">

															

			</ul>

		</div>

		<p class="no-media"><?php echo _e('no_media','image4io'); ?></p>

	</div>

</script>



<!--<script id="folder-template" type="text/html">

    <div class="media-frame-contents" data-columns="8">

		<div class="alert alert-danger"> 

			<span></span>

		</div>

		<div class="alert alert-success success"> 

			<span></span>

		</div>

        <form action="" id="createFolder" method="post" onsubmit="return false;">

			<label for="folderName" style="font-size:15px; font-weight:bold;"><?php echo _e('folder_name','image4io'); ?></label>

			<div style="clear:both"></div>

			<br />

			<input type="text" name="folderName" id="folderName" class="form-control"/>

		</form>

		<br />

		<button type="button" class="btn btn-primary form-control" onclick="createFolder()"><?php echo _e('create_folder','image4io'); ?></button>

	</div>

</script>-->



<script type="text/html" id="upload-template">

	<div class="uploader-mxlayer">

		<div class="uploader-mxlayer-content no-upload-mxlayer-message">

			<div class="upload-ui-mxlayer">

				<h2 class="upload-mxlayer-instructions drop-mxlayer-instructions"><?php echo _e('upload_title','image4io'); ?></h2>

				<p class="upload-mxlayer-instructions drop-mxlayer-instructions"><?php echo _e('upload_or','image4io'); ?></p>

				<form action="<?php echo $plugin_dir; ?>query.php?get=imageUpload" id="uploadForm" name="frmupload" method="post" enctype="multipart/form-data">

					<input type="hidden" name="api" value="<?php echo $apiKey; ?>" />

					<input type="hidden" name="apiKey" value="<?php echo $apiSecret; ?>" />

					<input type="hidden" name="path" value="<?php echo $path; ?>" />

					<input type="hidden" name="folder" value="/" />

					<input type="file" id="file_upload" name="file" />

					<input id="submitButton" type="submit" name='btnSubmit' style="display:none;" value="Resimi Yükle" />

				</form>

				<button type="button" class="button button-hero-mxlayer" id="upload_button" style="display: inline-block; position: relative; z-index: 1;"><?php echo _e('file_select','image4io'); ?></button>

				<span class="createFolderImage" data-id=""></span>

			</div>

			<div class="upload-mxlayer-status" style="margin:20px auto; width: 393px;">

				<div class='progress' id="progressDivId">

					<div class='progress-bar' id='progressBar'></div>

					<div class='percent' id='percent'>0%</div>

				</div>

				<div style="height: 10px;"></div>

				<div id='outputImage'></div>

			</div>

			<div class="post-mxlayer-upload-ui">

				<p class="max-mxlayer-upload-size">

					<?php echo _e('file_all_size','image4io'); ?>			

				</p>

			</div>

		</div>

	</div>

</script>