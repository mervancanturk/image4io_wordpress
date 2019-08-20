<?php include('header.php');

$apiKey = $image4io_settings->apikey;

$apiSecret = $image4io_settings->api_secret;

$path = $image4io_settings->path;

$cloudname = $image4io_settings->cloudname;

?>

<div class="image4io" style="min-height: 10000px;">
	<div class="container">
		<div class="col-sm-8">
			<h3>Api Bilgileri <button style="<?php echo ($valid_api) ? "" : "display:none;";?>" onclick='$("#form").toggle();'>Ayarları Göster</button></h3>

			<form action="" method="post" id="form" style="<?php echo ($valid_api) ? "display:none;" : "";  ?>">
				<label for="image4io_apiKey">Api Key</label>
				<input required type="text" name="image4io_apiKey" id="image4io_apiKey" value="<?php echo ($apiKey) ? $apiKey : "";  ?>" class="form-control" />

				<label for="image4io_apiKey">Api Secret</label>
				<input required type="text" name="image4io_apiSecret" class="form-control"  value="<?php echo ($apiSecret) ? $apiSecret : "";  ?>" />

				<label for="image4io_path">Cloudname</label>
				<input required type="text" name="image4io_Cloudname" class="form-control"   value="<?php echo ($cloudname) ? $cloudname : "";  ?>"/>

                <label for="image4io_path">Custom Path</label>
                <input type="text" name="image4io_Path" class="form-control"  value="<?php echo ($path) ? $path : "";  ?>" />

                <input type="hidden" name="image4io_formcontrol" value="true" id="image4io_formcontrol">

<!--				<button class="button">--><?php //echo ($apiKey) ? "Güncelle" : "Kaydet";  ?><!--</button>-->
                <?php submit_button();?>
			</form>
		</div>

		<div class="col-sm-4">
			<h3>Premium Üyelik</h3>
			<p>Premium üyelik bilgilerinizi girerek lütfen hemen kullanıma başlayın.</p>
		</div>
	</div>
</div>
