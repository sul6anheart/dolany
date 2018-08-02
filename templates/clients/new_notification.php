<?php
	include_once "header.php";
	session_start();
	include_once "actions.php";
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
				<h1 class="text-center">إبلاغ عن حاج تائه</h1>
				<?php if(isset($_POST['new_notification'])){ ?>
					<div class="row">
						<div class="col-md-12">
							<?php echo $msg; ?>
						</div>
					</div>
				<?php } ?>
				<form method="post" enctype="multipart/form-data">
					<h4>معلومات البلاغ</h4>
					<hr>
					<fieldset>
						<div class="row">
							  <div class="col-md-4 col-sm-12 col-xs-12">
									<div class="form-group">
										<label><span style="color:red;">*</span> اسم المُبلغ ثلاثيًا</label>
										<input type="text" class="form-control" name="notify_name" autocomplete='tel-national' required />
									</div>
							  </div>
							  <div class="col-md-4 col-sm-12 col-xs-12">
									<div class="form-group">
										<label><span style="color:red;">*</span> رقم الجوال</label>
										<input type="text" class="form-control"  pattern="\d*" maxlength="10" name="notify_mobile" autocomplete='tel-national' required />
										<span class="help-block">05xxxxxxxx</span>
									</div>
							  </div>
							  <div class="col-md-4 col-sm-12 col-xs-12">
									<div class="form-group">
										<label><span style="color:red;">*</span> مكان البلاغ</label>
										<input type="text" class="form-control" name="the_place" required />
										<span class="help-block">المنطقة التي يتمّ التبيلغ منها كرقم المُخيّم أو اسم الحملة أو أيّ شيء آخر يدل على مكان البلاغ</span>
									</div>
							  </div>
						</div>
						<h4>معلومات الحاج التائه</h4>
						<hr>
						<div class="row">
								<div class="col-md-4 col-sm-12 col-xs-12">
									<div class="form-group">
										<label><span style="color:red;">*</span> جنس الحاج</label>
										<select name="who_lost_sex" class="form-control">
											<option value="m">ذكر</option>
											<option value="f">أنثى</option>
										</select>
									</div>
								</div>
								<div class="col-md-4 col-sm-12 col-xs-12">
									<div class="form-group">
										<label><span style="color:red;">*</span> اسم الحاج ثلاثيًا</label>
										<input type="text" class="form-control" name="who_lost_name" autocomplete='tel-national' required />
									</div>
								</div>
								<div class="col-md-4 col-sm-12 col-xs-12">
									<div class="form-group">
										<label><span style="color:red;">*</span> رقم المُعرّف للحاج</label>
										<input type="text" class="form-control"  pattern="\d*" maxlength="10" name="who_lost_id" autocomplete='tel-national' required />
										<span class="help-block">يُمكن الحصول على الرقم من خلال إدارة حملة الحاج</span>
									</div>
								</div>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<div class="form-group">
										<label>(إن وجد) رقم جوال الحاج</label>
										<input type="text" class="form-control"  pattern="\d*" maxlength="10" name="who_lost_mobile" autocomplete='tel-national' />
										<span class="help-block">05xxxxxxxx</span>
									</div>
								</div>
								<div class="col-md-6 col-sm-12 col-xs-12">
									<div class="form-group">
										<label>صورة الحاج (إن وجدت)</label>
										<input type="file" class="form-control" name="who_lost_photo" />
										<span class="help-block">الصورة ستساعدنا على الوصول إليه سريعًا</span>
									</div>
								</div>
						</div>
						<h4>التحقق البشري</h4>
						<hr>
						<div class="row">
						  <div class="col-md-6 col-sm-6 col-xs-6">
								<div class="form-group">
		                <?php echo '<img src="' . $_SESSION['captcha']['image_src'] . '" alt="CAPTCHA" />'; ?>
								</div>
						  </div>
						  <div class="col-md-6 col-sm-6 col-xs-6">
								<div class="form-group">
									<span class="input-icon input-icon-right">
		                <input name="code" class="form-control" type="text" pattern="\d*" placeholder="ادخل رمز التحقق المدرج بالصورة">
										<i class="fa fa-key"></i> </span>
								</div>
						  </div>
						</div>
						<div class="form-actions">
							<button type="submit" name="new_notification" class="btn btn-success pull-left">
								إرسال الطلب
							</button>
						</div>
					</fieldset>
				</form>
			</div>
			<!-- end: LOGIN BOX -->
		</div>
<?php include_once "footer.php"; ?>
