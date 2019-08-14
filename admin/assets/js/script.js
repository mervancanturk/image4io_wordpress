$(document).ready(function () {

	$('#toplevel_page_image4io .dashicons-admin-generic').addClass('icon-image2vector');

	document_parse('/', this);

	$("#file_upload").change(function () {
		$(".uploadForms #progressBar").attr('style', 'width:0%');
		$('.uploadForms #percent').html('0%');

		var formData = new FormData($('#uploadForms')[0]);

		$.ajax({
			url: window.plugin_option.plugin_dir + 'query.php?get=imageUpload',
			type: 'POST',
			data: formData,

			xhr: function () {
				var xhr = new window.XMLHttpRequest();
				xhr.upload.addEventListener("progress", function (evt) {
					if (evt.lengthComputable) {
						var percentComplete = Math.round((evt.loaded / evt.total) * 100);
						$('.uploadForms #percent').html(percentComplete + '%');
						$(".uploadForms #progressBar").clearQueue().stop();
						$(".uploadForms #progressBar").animate({
							width: '' + percentComplete + '%'
						});
					}
				}, false);

				return xhr;
			},
			complete: function (data) {
				console.log(data);
				$("#status").html('Yükleme işleminiz başarı ile tamamlandı.');
				document_parse('/', this);
			},

			cache: false,
			contentType: false,
			processData: false
		});

		return false;
	});


	$(document).on('click', '.image_upload', function (e) {
		e.preventDefault();
		$('.uploader-inline').show();
		$('.allUpdateImage').hide();
	});

	$(document).on('click', '#upload_button', function (e) {
		e.preventDefault();
		$('#file_upload').trigger('click');
	});

	$(document).on('click', '.uploader-inline .close', function (e) {
		e.preventDefault();
		$('.uploader-inline').hide();
	});

	$(document).on('click', '.allSelect', function (e) {
		e.preventDefault();
		$('.media-toolbar-secondary').hide();
		$('.media-toolbar-two').show();
		$('.attachment .thumbnail').attr('style', 'opacity:.65');
		$("ul.attachments").data('block', 1);
	});

	$(document).on('click', '.notDelete', function (e) {
		e.preventDefault();
		$('.media-toolbar-secondary').show();
		$('.media-toolbar-two').hide();
		$('.attachment .thumbnail').attr('style', 'opacity:1');
		$("ul.attachments").data('block', 0);
	});

	$(document).on('click', '.deleteItems', function (e) {
		e.preventDefault();
		var variable = '';
		console.log($(this).attr('data-type'));
		if ($(this).attr('data-type') === 'fileList ') {
			variable = 'ul.attachments li';
		}
		else {
			variable = '.checkboxs';
		}

		var sayi = 0;

		$(variable).each(function (index) {
			if ($(variable).eq(index).attr('data-check') == 'checked') {
				sayi = index;
			}
		});

		$(variable).each(function (index) {
			if ($(variable).eq(index).attr('data-check') == 'checked') {
				$.ajax({
					url: window.plugin_option.plugin_dir + 'query.php?get=deleteFiles',
					type: 'POST',
					data: { 'apiKey': window.plugin_option.apiKey, 'apiSecret': window.plugin_option.apiSecret, 'path': window.plugin_option.path, 'type': $(variable).eq(index).attr('data-type'), 'filesName': $(variable).eq(index).attr('data-id') },
					dataType: 'json',
					success: function (result) {
						var deleteValue = [];
						if (typeof result['deletedFile'] !== 'undefined') {
							deleteValue = result['deletedFile'];
						}
						else {
							deleteValue = result['deletedFolder'];
						}

						if (deleteValue.status != 'Deleted') {
							$('.hatalar .alert-danger span').html(message.error.deleteError);
							$('.hatalar .alert').show();
							$('.hatalar .success').hide();
							hideErrorSuccess();
						}
						else {
							$('.hatalar .success span').html(message.success.deleteSuccess);
							$('.hatalar .alert').hide();
							$('.hatalar .success').show();
							hideErrorSuccess();

							$('.media-toolbar-two').hide();
							$('.media-toolbar-secondary').show();
							$('.attachment .thumbnail').attr('style', 'opacity:1');
							$('ul.attachments').data('block', 0);

							if (sayi == index) {
								document_parse($('.createFolderImage').attr('data-id'), this);
							}
						}
					}
				});
			}
		});
	});

	$(document).on('click', '.delete-attachment', function (e) {
		e.preventDefault();
		var dataId = $(this).attr('data-id');
		var dataType = $(this).attr('data-type');

		console.log(dataId + ' -> ' + dataType);

		$.ajax({
			url: window.plugin_option.plugin_dir + 'query.php?get=deleteFiles',
			type: 'POST',
			data: { 'apiKey': window.plugin_option.apiKey, 'apiSecret': window.plugin_option.apiSecret, 'path': window.plugin_option.path, 'type': dataType, 'filesName': dataId },
			dataType: 'json',

			success: function (result) {
				var deleteValue = [];
				if (error_return(result['deletedFile'])) {
					deleteValue = error_return(result['deletedFile']);
				} else {
					deleteValue = error_return(result['deletedFolder']);
				}

				console.log(deleteValue);

				if (deleteValue != 'Deleted') {
					$('.hatalar .alert span').html(deleteValue);
					$('.hatalar .alert').show();
					$('.hatalar .success').hide();
					hideErrorSuccess();
				}
				else {
					$('.hatalar .success span').html(message.success.deleteSuccess);
					$('.hatalar .alert').hide();
					$('.hatalar .success').show();
					hideErrorSuccess();

					$(".mxlayer-close").trigger("click");
					document_parse($('.createFolderImage').attr('data-id'), this);
				}
			}
		});

	});



	$(document).on('click', '.urlUploads', function (e) {
		$('#urlUpload .alert').hide();
		$('#url').val('');
		$('#urlUpload').modal('show');
	});



	$(document).on('click', '.createFolderImage', function (e) {
		$('.modal-body .alert').hide();
		$('#folderName').val('');
		$('#exampleModal').modal('show');
	});



	$(document).on('click', '.checkboxs', function (e) {
		if ($('.checkboxs:checked').length > 0) {
			$('.checkboxs:checked').attr('data-check', 'checked');
			$('.media-toolbar-secondary').hide();
			$('.media-toolbar-two').show();
		}
		else {
			$('.checkboxs').attr('data-check', '');
			$('.media-toolbar-secondary').show();
			$('.media-toolbar-two').hide();
		}
	});



	$(document).on('click', '.allUpdate', function (e) {
		$('.allUpdateImage').show();
		allUpload();
	});
});



function hideErrorSuccess() {
	setInterval('hideErrorSuccessHide()', 5000);
}

function hideErrorSuccessHide() {
	$('.alert').hide();
}



var value = 0;

function allUpload(count = 0) {
	$.post(ajaxurl, { 'folder': $('.createFolderImage').attr('data-id'), 'repost_id': value, 'action': 'mycustom_action' }, function (response) {
		response = maybe_parse_json('' + response + '');
		console.log(response);
		var progres = Math.ceil((100 / response.count) * response.progres);

		if (response.count != value) {
			var percentVal = progres + '%';
			$('.allUpdateImage .bar').width(percentVal)
			$('.allUpdateImage .percent').html(percentVal);
			$('.allUpdateImage #status').html(response.imageName);

			value++;

			allUpload(response.count);
		}
		else {
			var percentVal = '100%';
			$('.allUpdateImage .bar').width(percentVal)
			$('.allUpdateImage .percent').html(percentVal);
			$('.allUpdateImage #status').html('Tebrikleri bütün resimleriniz sunucuya aktarıldı.');
			document_parse($('.createFolderImage').attr('data-id'), this);
		}
	});
}



function maybe_parse_json(string) {

	var json_object;

	try {
		json_object = $.parseJSON(string);
	}
	catch (exception) {
		var second_try = string.replace(/((.|\n)+?){"/gm, "{\"");
		try {
			json_object = $.parseJSON(second_try);
		}
		catch (exception) {
			console.log('*** \n*** \n*** Error-causing response:\n***\n***\n', string);
			json_object = {
				message: 'JSON failed: another plugin caused a conflict with completing this request. Check your browser\'s Javascript console to view the invalid content.'
			};
		}
	}

	return json_object;
}



function CheckUncheckAll() {

	var selectAllCheckbox = document.getElementsByClassName("cb-select-all");
	if (selectAllCheckbox.checked == true) {
		var checkboxes = document.getElementsByName("media");
		for (var i = 0, n = checkboxes.length; i < n; i++) {
			checkboxes[i].checked = true;
			checkboxes[i].attr('data-check', 'checked');
		}
	}
	else {
		var checkboxes = document.getElementsByName("media");
		for (var i = 0, n = checkboxes.length; i < n; i++) {
			checkboxes[i].checked = false;
			checkboxes[i].attr('data-check', '');
		}
	}
}



function replaceAll(str, from, to) {

	var idx = str.indexOf(from);
	while (idx > -1) {
		str = str.replace(from, to);
		idx = str.indexOf(from);
	}

	return str;
}



function createFolder() {

	$('ul.attachments').html('');

	var folder = $('.createFolderImage').attr('data-id');

	var folderName = $('#folderName').val();

	$.ajax({
		url: window.plugin_option.plugin_dir + 'query.php?get=createFolder',
		type: 'POST',
		data: { 'apiKey': window.plugin_option.apiKey, 'apiSecret': window.plugin_option.apiSecret, 'path': window.plugin_option.path, 'folder': folder, 'folderName': folderName },
		dataType: 'json',
		success: function (result) {
			if (result['createdFolder'].status == 'AlreadyExist') {
				$('.modal-body .alert-danger span').html(message.error.createFolder);
				$('.modal-body .alert').show();
				$('.modal-body .success').hide();
				hideErrorSuccess();
			} else {
				$('.modal-body .success span').html(replaceAll(result['createdFolder'].name, '/', '') + ' ' + message.success.createFolder);
				$('.modal-body .alert').hide();
				$('.modal-body .success').show();
				hideErrorSuccess();
			}

			document_parse($('.createFolderImage').attr('data-id'), this);
		}
	});
}



function urlSave() {

	$('ul.attachments').html('');
	var folder = $('.createFolderImage').attr('data-id');
	var url = $('#url').val();
	$.ajax({
		url: window.plugin_option.plugin_dir + 'query.php?get=fetch',
		type: 'POST',
		data: { 'apiKey': window.plugin_option.apiKey, 'apiSecret': window.plugin_option.apiSecret, 'path': window.plugin_option.path, 'folder': folder, 'url': url },
		dataType: 'json',
		success: function (result) {
			var deleteValue = [];
			if (error_return(result['fetchedFile'])) {
				deleteValue = error_return(result['fetchedFile']);
			} else {
				deleteValue = error_return(result['fetchedFile']);
			}

			if (deleteValue == false) {
				$('#urlUpload .alert-danger span').html(message.error.fetchedFileError);
				$('#urlUpload .alert').show();
				$('#urlUpload .success').hide();
				hideErrorSuccess();
			} else {
				$('#urlUpload .success span').html(result['fetchedFile'].name + ' ' + message.success.fetchedFileSucces);
				console.log(result['fetchedFile'].name + ' ' + message.success.fetchedFileSucces);
				$('#urlUpload .alert').hide();
				$('#urlUpload .success').show();
				hideErrorSuccess();
			}

			document_parse($('.createFolderImage').attr('data-id'), this);
		}
	});
}

var clicks = 0;

function folderOpen(html) {

	clicks++;
	if (clicks == 1) {

		$('.createFolderImage').attr('data-id', '/');

		$(".mxlayer-close").trigger("click");

		$.mxlayer({
			title: 'image4io',
			sidebar: $('#sidebar-template').html(),
			main: $(html).html(),
			button: false,
			cancel: function (that) {
			},
			confirm: function (that) {
				//that.fireEvent();
			}
		});

		document_parse('/', this);
	}
}


var i = 0;

function document_parse(dir, thiss) {
	if ($('.image4ioList').data('block') == 0) {
		if (typeof $(thiss).attr('data-type') == 'undefined') {
			$(thiss).attr('data-type', 'folder');
		}
		
		if ($(thiss).attr('data-type') == 'folder') {
			bread(dir, $(thiss).attr('data-id'));
			if ($('.image4ioList').attr('id') == 'fileList') {
				$('.image4ioList').html('');
			} else {
				$('#the-list').html('');
			}

			$('.createFolderImage').attr('data-id', dir);

			$.ajax({
				url: window.plugin_option.plugin_dir + 'scan.php',
				type: 'POST',
				data: { 'apiKey': window.plugin_option.apiKey, 'apiSecret': window.plugin_option.apiSecret, 'path': window.plugin_option.path, 'dir': dir },
				dataType: 'json',
				success: function (result) {
					if (result.length > 0) {
						$('.no-media').hide();

						if ($('.image4ioList').attr('id') == 'fileList') {
							result.forEach(function (element) {
								if (element.type == 'file') {
									$('.attachments').append('<li tabindex="' + i + '" data-check="0" data-type="file" id="file_' + i + '" data-name="' + element.original_name + '" data-format="' + element.format + '" data-create="' + element.createdAt + '" data-widthh="' + element.width + ' x ' + element.height + '" data-size="' + element.size + '" data-id="' + element.name + '" onclick="document_parse(\'' + element.path + '\',this)" class="attachment"><div class="attachment-preview js--select-attachment type-image subtype-jpeg landscape"><div class="thumbnail"><div class="centered"><img src="https://cdn.image4.io/' + window.plugin_option.path + '' + element.name + '?w=120&f=auto" draggable="false" alt=""></div></div></div></li>');
									$('#stylecss').append('#file_' + i + ' .attachment-preview:before {display: block; content:attr(data-before)}');
									var name = element.original_name.substr(0, 17);
									$('#file_' + i + ' .attachment-preview').attr('data-before', name);
									i++;
								} else {
									$('.attachments').append('<li data-id="' + element.name + '" data-type="folder" data-check="0" class="attachment folder" id="folder_' + element.name + '" onclick="document_parse(\'' + element.path + '\',this)"><div class="attachment-preview js--select-attachment type-image subtype-jpeg landscape"><div class="thumbnail"><div class="centered"><img src="' + window.plugin_option.plugin_dir + 'admin/assets/images/folder.svg" draggable="false" alt=""></div></div></div></li>');
									$('#stylecss').append('#folder_' + element.name + ' .attachment-preview:before {display: block; content:attr(data-before)}');
									var name = element.name.substr(0, 17);
									$('#folder_' + element.name + ' .attachment-preview').attr('data-before', name);
								}
							});
						} else {
							result.forEach(function (element) {
								if (element.type == 'file') {
									$('#the-list').append('<tr class="author-self status-inherit"><th scope="row" class="check-column"><label class="screen-reader-text">' + element.original_name + '</label><input type="checkbox" class="checkboxs" name="media" value="' + element.name + '" data-type="' + element.type + '" data-id="' + element.name + '"></th><td class="title column-title has-row-actions column-primary" data-colname="Dosya"><strong class="has-media-icon"><a href="javascript:;" data-name="' + element.original_name + '" data-format="' + element.format + '" data-create="' + element.createdAt + '" data-widthh="' + element.width + ' x ' + element.height + '" data-type="' + element.type + '" data-size="' + element.size + '" data-id="' + element.name + '" onclick="document_parse(\'' + element.path + '\',this)" rel="bookmark"><img width="60" height="60" src="https://cdn.image4.io/' + window.plugin_option.path + '' + element.name + '?w=120&f=auto" class="attachment-60x60 size-60x60" alt=""></a></strong><p class="filename"><span class="screen-reader-text">Dosya adı: </span>' + element.original_name + '</p><div class="row-actions"><span class="delete"><a href="javascript:;" class="delete-attachment" data-id="' + element.name + '" data-type="' + element.type + '" role="button">Kalıcı olarak sil</a> | </span><span class="view"><a href="javascript:;" data-name="' + element.original_name + '" data-format="' + element.format + '" data-create="' + element.createdAt + '" data-widthh="' + element.width + ' x ' + element.height + '" data-type="' + element.type + '" data-size="' + element.size + '" data-id="' + element.name + '" onclick="document_parse(\'' + element.path + '\',this)" rel="bookmark">Görüntüle</a></span></div></td><td class="date column-date" data-colname="Tarih">' + element.createdAt + '</td></tr>');
								} else {
									$('#the-list').append('<tr class="author-self status-inherit"><th scope="row" class="check-column"><label class="screen-reader-text">' + element.name + '</label><input type="checkbox" class="checkboxs" name="media" value="' + element.name + '" data-type="' + element.type + '" data-id="' + element.name + '"></th><td class="title column-title has-row-actions column-primary" data-colname="Dosya"><strong class="has-media-icon"><a href="javascript:;" data-id="' + element.name + '" onclick="document_parse(\'' + element.path + '\',this)" rel="bookmark"><img width="60" height="60" src="' + window.plugin_option.plugin_dir + 'admin/assets/images/folder.svg" class="attachment-60x60 size-60x60" alt=""></a></strong><p class="filename"><span class="screen-reader-text">Dosya adı: </span>' + element.name + '</p><div class="row-actions"><span class="delete"><a href="javascript:;" class="delete-attachment" data-id="' + element.name + '" data-type="' + element.type + '" role="button">Kalıcı olarak sil</a> | </span><span class="view"><a href="javascript:;" data-id="' + element.name + '" onclick="document_parse(\'' + element.path + '\',this)" rel="bookmark">Görüntüle</a></span></div></td><td class="date column-date" data-colname="Tarih"></td></tr>');
								}
							});
						}
					} else {
						$('.no-media').show();
					}
					clicks = 0;
				}
			});
		}
		else {
			if ($(thiss).parent().attr('class') == 'attachments ui-sortable ui-sortable-disabled fileOkey image4ioList') {
				var images = '<img src="https://cdn.image4.io/' + window.plugin_option.path + '' + $(thiss).attr('data-id') + '" />';
				if (!$('#wp-content-editor-container #mceu_24').hasClass('mce-tinymce')) {
					var value = $('.wp-editor-area').val();
					$('.wp-editor-area').val(value + ' ' + images);
				} else {
					console.log($('.mce-tinymce').attr('style') + ' -> visibility: hidden; border-width: 1px; width: 100%; display: none;');
					if ($('.mce-tinymce').attr('style') == 'visibility: hidden; border-width: 1px; width: 100%; display: none;') {
						var value = $('.wp-editor-area').val();
						$('.wp-editor-area').val(value + ' ' + images);
					} else {
						var value = $('.mce-tinymce #content_ifr').contents().find("body").html();
						$('.mce-tinymce #content_ifr').contents().find("body").append(images);
					}
				}
				$(".mxlayer-close").trigger("click");
			}
			else {
				$.ajax({
					url: window.plugin_option.plugin_dir + 'query.php?get=imageDetail',
					type: 'POST',
					data: { 'apiKey': window.plugin_option.apiKey, 'apiSecret': window.plugin_option.apiSecret, 'path': window.plugin_option.path, 'filesName': $(thiss).attr('data-id') },
					dataType: 'json',
					success: function (result) {
						$('.details-image').attr('src', 'https://cdn.image4.io/' + window.plugin_option.path + '' + result.name);
						$('.delete-attachment').attr('data-id', result.name);
						$('.delete-attachment').attr('data-type', $(thiss).attr('data-type'));
						$('.filename span').html(result.userGivenName);
						$('.filetype span').html(result.format);
						$('.uploaded span').html(result.createdAtUTC);
						$('.file-size span').html(result.size + ' KB');
						$('.dimensions span').html(result.width + ' x ' + result.height + ' px');
					}
				});

				$(".mxlayer-close").trigger("click");
				$.mxlayer({
					title: '',
					main: $('#main-template').html(),
					button: false,
					cancel: function (that) {

					},
					confirm: function (that) {
						//that.fireEvent();
					}
				});
			}
		}
	}
	else {

		if ($(thiss).attr('data-check') == 'checked') {
			$(thiss).attr('data-check', '0');
			$(thiss).removeClass('details');
		}
		else {
			$(thiss).attr('data-check', 'checked');
			$(thiss).addClass('details');
		}
	}
}



function bread(dir, name) {
	if (dir == '/') {
		$('.bread').html('');
		$('.bread').append('<li><a href="javascript:;" data-type="folder" onclick="document_parse(\'/\',this)">Ana Klasör</a></li>');
	}
	else {
		$('.bread').append('<li> <span>></span> <a href="javascript:;" data-type="folder" onclick="document_parse(\'' + dir + '\',this)">' + name + '</a></li>');
	}
}



function error_return(deleteResult) {
	var deleteValue = [];
	if (typeof deleteResult !== 'undefined') {
		if (typeof deleteResult.status !== 'undefined') {
			deleteValue = deleteResult.status;
		}
		else {
			deleteValue = deleteResult.message;
		}

		return deleteValue;
	} else {
		deleteValue = false;
		return deleteValue;
	}
}