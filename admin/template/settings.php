<?php include('header.php'); ?>

<style type="text/css">

	.mxlayer-main-body {

		padding:0;

	}

</style>

<div id="wpbody-content" class="image4io">

	<div class="wrap" id="wp-media-grid">

		<div class="media-frame wp-core-ui mode-grid mode-edit hide-menu">

			<h3><span class="icon-image2vector"></span> image4io <button type="button" class="button media-button image_upload"><?php echo _e('image_upload','image4io'); ?></button></h3>

			<div class="media-frame-router"></div>

			<div class="media-frame-content" data-columns="8">

				<div class="attachments-browser hide-sidebar sidebar-for-errors">

					<div class="uploader-inline">

						<button class="close dashicons dashicons-no">

							<span class="screen-reader-text"><?php echo _e('upload_close','image4io'); ?></span>

						</button>

						<div class="uploader-inline-content no-upload-message uploader-mxlayer">

							<div class="alert alert-danger"> 

								<span></span>

							</div>

							<div class="alert alert-success success"> 

								<span></span>

							</div>

							<div class="upload-ui" style="padding-top: 21px;">

								<h2 class="upload-instructions drop-instructions"><?php echo _e('upload_title','image4io'); ?></h2>

								<p class="upload-instructions drop-instructions"><?php echo _e('upload_or','image4io'); ?></p>

								<form action="<?php echo $plugin_dir; ?>query.php?get=imageUpload" id="uploadForms" onsubmit="return false;" name="frmupload" method="post" enctype="multipart/form-data">

									<input type="hidden" name="apiKey" value="<?php echo $apiKey; ?>" />

									<input type="hidden" name="apiSecret" value="<?php echo $apiSecret; ?>" />

									<input type="hidden" name="path" value="<?php echo $path; ?>" />

									<input type="hidden" name="folder" value="/" />

									<input type="file" id="file_upload" name="file" />

									<input id="submitButton" type="submit" name='btnSubmit' style="display:none;" value="Resimi Yükle" />

								</form>

								<button type="button" class="browser button button-hero" id="upload_button" style="display: inline-block; position: relative; z-index: 1;"><?php echo _e('file_select','image4io'); ?></button>

							</div>

							<div class="upload-inline-status uploadForms" style="margin:20px auto; width: 393px;">

								<div class='progress' id="progressDivId">

									<div class='progress-bar' id='progressBar'></div>

									<div class='percent' id='percent'>0%</div>

								</div>

								<div style="height: 10px;"></div>

								<div id='outputImage'></div>

							</div>

							<div class="post-upload-ui">

								<p class="max-upload-size">

									<?php echo _e('file_all_size','image4io'); ?>			

								</p>

							</div>

						</div>

					</div>

					<div class="uploader-inline allUpdateImage">

						<button class="close dashicons dashicons-no">

							<span class="screen-reader-text"><?php echo _e('upload_close','image4io'); ?></span>

						</button>

						<div class="upload-ui" style="padding-top: 21px;">

							<h2 class="upload-instructions drop-instructions"><?php echo _e('all_update_title','image4io'); ?></h2>

						</div>

						<div class="uploader-inline-content no-upload-message uploader-mxlayer">

							<div class="upload-inline-status" style="margin:20px auto; width: 393px;">

								<div class="progress">

									<div class="bar"></div >

									<div class="percent">0%</div >

								</div>

								

								<div id="status"><?php echo _e('upload_load','image4io'); ?></div>

							</div>

						</div>

					</div>

					</div>

					<div class="media-toolbar wp-filter">

						<div class="media-toolbar-secondary">

							<div class="view-switch media-grid-view-switch">

								<a href="admin.php?page=image4io&listType=tableList" class="view-list">

									<span class="screen-reader-text"><?php echo _e('list_view','image4io'); ?></span>

								</a>

								<a href="admin.php?page=image4io&listType=fileList" class="view-grid current">

									<span class="screen-reader-text"><?php echo _e('grid_view','image4io'); ?></span>

								</a>

							</div>

							<button type="button" class="button media-button createFolderImage  select-mode-toggle-button" data-id=""><?php echo _e('create_folder','image4io'); ?></button>

							<button type="button" class="button media-button urlUploads  select-mode-toggle-button" data-id="" data-toggle="modal" data-target="#urlUpload"><?php echo _e('url_save','image4io'); ?></button>

							<button type="button" class="button media-button allSelect  select-mode-toggle-button"><?php echo _e('all_select','image4io'); ?></button>

							<button type="button" class="button media-button allUpdate  select-mode-toggle-button"><?php echo _e('all_update','image4io'); ?></button>

						</div>

						<div class="media-toolbar-two" style="display:none;">

							<button type="button" class="button media-button notDelete  select-mode-toggle-button"><?php echo _e('cancel','image4io'); ?></button>

							<button type="button" class="button media-button button-primary button-large  delete-selected-button deleteItems" data-type="<?php if(@$_GET['listType'] == 'fileList' || $_GET['listType'] == '') { echo 'fileList';?> <?php }else { echo 'tableList'; } ?>"><?php echo _e('delete','image4io'); ?></button>

						</div>

					</div>

					<div class="hatalar">

						<div class="alert alert-danger"> 

							<span></span>

						</div>

						<div class="alert alert-success success"> 

							<span></span>

						</div>

					</div>

					<div style="clear:both; width:100%; display:block;">

						<ul class="bread">

							

						</ul>

					</div>

					</div>

					<div class="display:block; width:100%; clear:both;">

						<?php if(@$_GET['listType'] == 'fileList' || $_GET['listType'] == '') { ?>

							<ul tabindex="" data-block="0" class="attachments ui-sortable ui-sortable-disabled image4ioList fileList" id="fileList">

								

							</ul>

						<?php }else { ?>

							<table data-block="0" class="wp-list-table widefat fixed striped media image4ioList" id="tableList">

								<thead>

									<tr>

										<td id="cb" class="manage-column column-cb check-column">

											<label class="screen-reader-text" for="cb-select-all-1">Tümünü seç</label>

											<input class="cb-select-all checkboxs" onclick="CheckUncheckAll()" type="checkbox">

										</td>

										<th scope="col" id="title" class="manage-column column-title column-primary sortable desc">

											<span>Dosya</span>

										</th>

										<th scope="col" id="date" class="manage-column column-date sortable asc">

											<span>Tarih</span>

										</th>	

									</tr>

								</thead>

								<tbody id="the-list">

									

								</tbody>

								<tfoot>

									<tr>

										<td class="manage-column column-cb check-column">

											<label class="screen-reader-text" for="cb-select-all-2">Tümünü seç</label>

											<input class="cb-select-all checkboxs" onclick="CheckUncheckAll()" type="checkbox">,

										</td>

										<th scope="col" class="manage-column column-title column-primary sortable desc">

											<span>Dosya</span>

										</th>

										<th scope="col" class="manage-column column-date sortable asc">

											<span>Tarih</span>

										</th>	

									</tr>

								</tfoot>

							</table>

						<?php } ?>

					</div>

					<p class="no-media"><?php echo _e('no_media','image4io'); ?></p>

				</div>

			</div>

			<div class="media-frame-toolbar"></div>

			<div class="media-frame-uploader"></div>

		</div>

	</div>

</div>



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

		<div class="rows">

			<div class="col-sm-8" style="padding: 0;">

				<div class="thumbnail thumbnail-image popup_image" style="width: 95%; margin: 0 auto; overflow:hidden;">

					<img class="details-image" src="" draggable="false" alt="">

				</div>

			</div>

			<div class="col-sm-4" style="height:100%; padding:0;">

				<div class="attachment-info popup_detail">

					<div class="details">

						<div class="filename"><strong><?php echo _e('file_name','image4io'); ?>:</strong> <span></span></div>

						<div class="filetype"><strong><?php echo _e('file_type','image4io'); ?>:</strong> <span></span></div>

						<div class="uploaded"><strong><?php echo _e('upload_date','image4io'); ?>:</strong> <span></span></div>

						<div class="file-size"><strong><?php echo _e('file_size','image4io'); ?>:</strong> <span></span></div>

						<div class="dimensions"><strong><?php echo _e('sizes','image4io'); ?>:</strong> <span></span></div>

						<div class="compat-meta">

										

						</div>

					</div>

					<p>&nbsp;</p>

					<p>&nbsp;</p>

					<p>&nbsp;</p>

					<p>&nbsp;</p>

					<p>&nbsp;</p>

					<p>&nbsp;</p>

					<p>&nbsp;</p>

					<p>&nbsp;</p>

					<p>&nbsp;</p>

					<p>&nbsp;</p>

					<p>&nbsp;</p>

					<p>&nbsp;</p>

					<p>&nbsp;</p>

					<p>&nbsp;</p>

					<div class="actions">

						<button type="button" class="button-link delete-attachment" data-id="" data-type=""><?php echo _e('delete','image4io'); ?></button>			

					</div>

				</div>

			</div>

		</div>

	</div>

</script>



<div class="modal" id="exampleModal" tabindex="-1" role="dialog">

  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title"><?php echo _e('create_folder','image4io'); ?></h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <div class="modal-body">

		<div class="alert alert-danger"> 

			<span></span>

		</div>

		<div class="alert alert-success success"> 

			<span></span>

		</div>

        <form action="" id="createFolder" method="post" onsubmit="return false;">

			<label for="folderName"><?php echo _e('folder_name','image4io'); ?></label>

			<input type="text" name="folderName" id="folderName" class="form-control"/>

		</form>

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-primary" onclick="createFolder()"><?php echo _e('create_folder','image4io'); ?></button>

        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo _e('close','image4io'); ?></button>

      </div>

    </div>

  </div>

</div>



<div class="modal" id="urlUpload" tabindex="-1" role="dialog">

  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title"><?php echo _e('url_upload','image4io'); ?></h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <div class="modal-body">

		<div class="alert alert-danger"> 

			<span></span>

		</div>

		<div class="alert alert-success success"> 

			<span></span>

		</div>

        <form action="" id="createFolder" method="post" onsubmit="return false;">

			<label for="url"><?php echo _e('url','image4io'); ?></label>

			<input type="text" name="url" id="url" class="form-control"/>

		</form>

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-primary" onclick="urlSave()"><?php echo _e('url_save','image4io'); ?></button>

        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo _e('close','image4io'); ?></button>

      </div>

    </div>

  </div>

</div>