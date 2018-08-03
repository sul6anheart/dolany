<?php
	include_once "header.php";
	session_start();
	include_once "actions.php";

	$info = row_one("notifications", "id='".$_GET['id']."'", "");
	if(isset($_GET['user_id']))
	{
		$user_info = row_one("users", "id='".$_GET['user_id']."'", "");
		$rep = row_one("operations", "user_id='".$_GET['user_id']."' and notify_id='".$_GET['id']."'", "");
	}
	include("../../class/captcha.php");
	$_SESSION['captcha'] = simple_php_captcha(
	  array(
	    'min_length' => 4,
	    'max_length' => 4,
	    'characters' => '0123456789',
	    'min_font_size' => 30,
	    'max_font_size' => 30,
	    'color' => '#666'
	  )
	);
?>
<style>
th{
	background-color: #0011;
}
</style>
	<!-- start: BODY -->
	<body class="login example2 rtl">
		<div class="main-login col-sm-8 col-sm-offset-2">
			<div class="logo">
        <img src="<?php echo site_option("logo"); ?>" class="responsive" width="300">
			</div>
			<br>
			<!-- start: LOGIN BOX -->
			<div class="box-login">
				<a href="home" role="button" class="btn btn-bricky pull-left">
					عودة للصفحة السابقة
				</a>
				<a href="home" role="button" class="btn btn-warning pull-right">
					إيصال حاج تائه
				</a>
				<br>
				<h1 class="text-center">معاينة البلاغ (<?php echo $info['id']; ?>)</h1>
				<h2 class="text-center">الحالة
					(<?php
						if($info['status'] == 0){
							echo '<label class="label label-danger" style="color: #fff;">بإنتظار استلام البلاغ</label>';
						}elseif($info['status'] == 1){
							echo '<label class="label label-info" style="color: #fff;">تمّ استلام البلاغ</label>';
						}elseif($info['status'] == 2){
							echo '<label class="label label-success" style="color: #fff;">تمّ تسليم الحاج لمقرّ الخيمة</label>';
						}
					?>)
				</h2>
				<h4>تاريخ البلاغ: <?php echo convert_date($info['created_at']); ?></h4>
				<?php if(isset($_POST['new_notification'])){ ?>
					<div class="row">
						<div class="col-md-12">
							<?php echo $msg; ?>
						</div>
					</div>
				<?php } ?>
					<?php if($info['status'] == 1 and !empty($user_info) and !empty($rep)){ ?>
						<h4>معلومات البلاغ</h4>
						<hr>
							<div class="row">
									<div class="col-md-4 col-sm-12 col-xs-12">
										<div class="form-group">
											<label>اسم المُبلغ ثلاثيًا: <span style="color:red;"><?php echo $info['notify_name']; ?></span></label>
										</div>
									</div>
									<div class="col-md-4 col-sm-12 col-xs-12">
										<div class="form-group">
											<label>رقم الجوال: <span style="color:red;"><?php echo $info['notify_mobile']; ?></span></label>
										</div>
									</div>
									<div class="col-md-4 col-sm-12 col-xs-12">
										<div class="form-group">
											<label>مكان البلاغ: <span style="color:red;"><?php echo $info['the_place']; ?></span></label>
										</div>
									</div>
							</div>
							<hr>
						<h4>معلومات الحاج</h4>
						<hr>
						<div class="row">
								<div class="col-md-4 col-sm-12 col-xs-12">
									<div class="form-group">
										<label>الجنس: <span style="color:red;"><?php if($info['sex'] == "m"){echo 'ذكر';}else{echo 'أنثى';} ?></span></label>
									</div>
								</div>
								<div class="col-md-4 col-sm-12 col-xs-12">
									<div class="form-group">
										<label>اسم الحاج ثلاثيًا: <span style="color:red;"><?php echo $info['who_lost_name']; ?></span></label>
									</div>
								</div>
								<div class="col-md-4 col-sm-12 col-xs-12">
									<div class="form-group">
										<label>رقم المُعرّف للحاج: <span style="color:red;"><?php echo $info['who_lost_id']; ?></span></label>
									</div>
								</div>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<div class="form-group">
										<label>رقم جوال الحاج: <span style="color:red;"><?php echo $info['who_lost_mobile']; ?></span></label>
									</div>
								</div>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<div class="form-group">
										<label>صورة الحاج</label>
										<?php
											if($info['who_lost_photo'] != 'NA')
											{
										?>
										<img src="<?php echo $info['who_lost_photo']; ?>" width="80">
									<?php
										}else{
											echo ': <label style="color:red;">لا يوجد</label>';
										}
									?>
									</div>
								</div>
						</div>
						<div class="form-actions">
							<a role="button" href="#conf_notification" data-toggle="modal" class="btn btn-warning pull-left">تأكيد تسليم الحاج</a>
							<div id="conf_notification" class="modal fade" tabindex="-1" data-width="760" style="display: none;">

								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
										&times;
									</button>
									<h4 class="modal-title"> تأكيد إغلاق البلاغ (<?php echo $info['id']; ?>)</h4>
								</div>
								<form method="post" id="conf_notification_d">
									<div class="modal-body">
										<div class="form-group">
											<div class="alert alert-info">
												نأمل تكرمًا تأكيد تسليم الحاج (<?php echo $info['who_lost_name']; ?>) ووضع رقم الترخيص بالحملة أو مؤسسة/شركة الحج لتأكيد تسليم الحاج.
											</div>
										</div>
										<div class="form-group">
										  <label>رقم ترخيص الحملة</label>
										  <input type="text" class="form-control" name="code">
										  <p class="help-block">سيتمّ التحقق من الرقم وإظهار اسم الحملة قبل المتابعة</p>
										</div>
										<div class="form-group conf_notification_result">

										</div>
									</div>
									<div class="modal-footer">
										<button type="button" onclick="conf_notification();" class="btn btn-danger">تحق من الرقم</button>
										<input  type="hidden" name="id" value="<?php echo $info['id']; ?>" />
										<button type="button" class="btn btn-warning" data-dismiss="modal">إغلاق النافذة</button>
									</div>
								</form>
							</div>
						</div>
					<?php }elseif(empty($user_info) and empty($rep) and $info['status'] != 0 ){ ?>
						<div class="alert alert-danger">
							عفوًا لقد تمّ ربط هذا البلاغ بشخص آخر لإدارته .. نشكر لك تعاونك ونسأل الله لك الأجر والمثوبة.
						</div>
					<?php } ?>
					<?php if($info['status'] == 0 and empty($rep)){ ?>
					<h4>معلومات البلاغ</h4>
					<hr>
					<fieldset>
						<div class="row">
							  <div class="col-md-4 col-sm-12 col-xs-12">
									<div class="form-group">
										<label>اسم المُبلغ ثلاثيًا: <span style="color:red;"><?php echo $info['notify_name']; ?></span></label>
									</div>
							  </div>
							  <div class="col-md-4 col-sm-12 col-xs-12">
									<div class="form-group">
										<label>رقم الجوال: <span style="color:red;"><?php echo $info['notify_mobile']; ?></span></label>
									</div>
							  </div>
							  <div class="col-md-4 col-sm-12 col-xs-12">
									<div class="form-group">
										<label>مكان البلاغ: <span style="color:red;"><?php echo $info['the_place']; ?></span></label>
									</div>
							  </div>
						</div>
						<h4>معلومات الحاج</h4>
						<hr>
						<div class="row">
								<div class="col-md-4 col-sm-12 col-xs-12">
									<div class="form-group">
										<label>الجنس: <span style="color:red;"><?php if($info['sex'] == "m"){echo 'ذكر';}else{echo 'أنثى';} ?></span></label>
									</div>
								</div>
								<div class="col-md-4 col-sm-12 col-xs-12">
									<div class="form-group">
										<label>اسم الحاج ثلاثيًا: <span style="color:red;"><?php echo $info['who_lost_name']; ?></span></label>
									</div>
								</div>
								<div class="col-md-4 col-sm-12 col-xs-12">
									<div class="form-group">
										<label>رقم المُعرّف للحاج: <span style="color:red;"><?php echo $info['who_lost_id']; ?></span></label>
									</div>
								</div>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<div class="form-group">
										<label>رقم جوال الحاج: <span style="color:red;"><?php echo $info['who_lost_mobile']; ?></span></label>
									</div>
								</div>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<div class="form-group">
										<label>صورة الحاج</label>
										<?php
											if($info['who_lost_photo'] != 'NA')
											{
										?>
										<img src="<?php echo $info['who_lost_photo']; ?>" width="80">
									<?php
										}else{
											echo ': <label style="color:red;">لا يوجد</label>';
										}
									?>
									</div>
								</div>
						</div>

							<div class="form-actions">
								<a role="button" href="#r_notification" data-toggle="modal" class="btn btn-warning pull-left">استلام الطلب</a>

								<div id="r_notification" class="modal fade" tabindex="-1" data-width="760" style="display: none;">

									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
											&times;
										</button>
										<h4 class="modal-title"> استلام البلاغ (<?php echo $info['id']; ?>)</h4>
									</div>
									<form method="post" class="information">
										<div class="modal-body">
											<div class="form-group">
												<label>رقم جوالك المعتمد لدينا</label>
												<input type="text" class="form-control" id="mobile" pattern="\d*" maxlength="10" name="mobile" autocomplete='tel-national' required />
												<span class="help-block">05xxxxxxxx</span>
											</div>
											<div class="form-group req_result">

											</div>
										</div>
										<div class="modal-footer">
											<button type="button" onclick="r_notification();" class="btn btn-danger">استلام الطلب</button>
											<input  type="hidden" name="id" value="<?php echo $info['id']; ?>" />
											<button type="button" class="btn btn-warning" data-dismiss="modal">إغلاق النافذة</button>
										</div>
								  </form>
								</div>


								</div>


							</div>
						<?php } ?>
					</fieldset>
			</div>
			<!-- end: LOGIN BOX -->
		</div>
<?php include_once "footer.php"; ?>

<script>
function r_notification()
{
	var datastring = $(".information").serialize();
	//var form = $('#information')[0];
	//var formData = new FormData(form);
	$.ajax({
	    url: "r_notification",
	    data: datastring,
			type: "POST",
			cache: false,
	    success: function(data) {
				$(".req_result").fadeIn(1000);
				$(".req_result").html(data);
	    },
	    error: function() {
	        alert('error handing here');
	    }
	});
}
function conf_notification()
{
	var datastring = $("#conf_notification_d").serialize();
	$.ajax({
	    url: "conf_notification",
	    data: datastring,
			type: "POST",
			cache: false,
	    success: function(data) {
				$(".conf_notification_result").fadeIn(1000);
				$(".conf_notification_result").html(data);
	    },
	    error: function() {
	        alert('error handing here');
	    }
	});
}
</script>
