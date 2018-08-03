<?php
	include_once "header.php";
	session_start();
	if(isset($_POST['logout_this']))
	{
	  clear_cookies();
	  header("Location: notifications");
	}
	if(isset($_POST['login_to_page']))
	{
	  if($_SESSION['captcha']['code'] == $_POST['code'])
	  {

	    if(!empty($_POST['username']) OR !empty($_POST['password']))
	    {
				$get_user_info = row_one("users", "username='".$_POST['username']."' and password='".$_POST['password']."'", "");
				if(!empty($get_user_info))
				{
					$time =  time()+3600*2;
					setcookie('username', base64_encode($get_user_info['username']), $time);
					setcookie('password', base64_encode($get_user_info['password']), $time);
					header("Location: notifications");
				}else{
					$msg = "<div class='alert alert-danger'>";
	      	$msg .= "عفوًا البيانات المدخلة خاطئة، يجب إدخال البيانات بصورة صحيحة لإتمام الدخول.";
	      	$msg .= "</div>";
					clear_cookies();
			 }

	    }else{
	      $msg = "<div class='alert alert-danger'>";
	      $msg .= "عفوًا هنالك نقص في بعض الحقول الهامة، يجب تعبئة كافة الحقول المطلوبة قبل معاينة البلاغات";
	      $msg .= "</div>";
				clear_cookies();
	    }

	  }else{
	    $msg = "<div class='alert alert-danger'>";
	    $msg .= "عفوًا رمز التحقق المدخل غير صحيح.";
	    $msg .= "</div>";
	  }

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
        <img src="<?php echo site_option("logo"); ?>" class="responsive" width="130">
			</div>
			<br>
			<!-- start: LOGIN BOX -->
			<div class="box-login">
				<?php if(isset($_COOKIE['username']) and isset($_COOKIE['password']) ) { ?>
				<form method="post">
					<button name="logout_this" class="btn btn-danger pull-left">
						خروج
					</button>
				</form>
				<br>
				<?php } ?>
				<h1 class="text-center">عرض البلاغات النشطة</h1>
				<?php if(isset($_POST['login_to_page'])){ ?>
					<div class="row">
						<div class="col-md-12">
							<?php echo $msg; ?>
						</div>
					</div>
				<?php } ?>
				<form method="post" enctype="multipart/form-data">
					<?php if(!isset($_COOKIE['username']) and !isset($_COOKIE['password']) ) { ?>
						<?php
							if(isset($_GET['username']))
							{
								$user_info = row_one("users", "username='".base64_decode($_GET['username'])."'", "");
							}
						?>
					<fieldset>
						<div class="row">
						  <div class="col-md-6 col-sm-12 col-xs-12">
								<div class="form-group">
									<label>اسم المستخدم</label>
									<input type="text" class="form-control" <?php if(isset($_GET['username'])){ ?>value="<?php echo $user_info['username']; ?>"<?php } ?> name="username" required />
								</div>
						  </div>
						  <div class="col-md-6 col-sm-12 col-xs-12">
								<div class="form-group">
									<label>كلمة المرور</label>
									<input type="password" class="form-control" <?php if(isset($_GET['password'])){ ?>value="<?php echo $user_info['password']; ?>"<?php } ?> name="password" required />
								</div>
						  </div>
						</div>
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
							<button type="submit" name="login_to_page" class="btn btn-bricky pull-left">
								عرض البلاغات
							</button>
						</div>
					</fieldset>
				</form>
				<?php }else{
					$user_info = row_one("users", "username='".base64_decode($_COOKIE['username'])."' and password='".base64_decode($_COOKIE['password'])."'", "");
				?>
				<table class="table table-bordered mohd_okfie_tables">
					<thead>
						<tr>
							<th class="center">رقم البلاغ</th>
							<th class="center">اسم المُبلّغ</th>
							<th class="center">اسم الحاج</th>
							<th class="center">مكان البلاغ</th>
							<th class="center">تاريخ البلاغ</th>
							<th class="center">الإجراءات</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$counter = 1;
							$get_notifications = Pager("notifications WHERE status='0'","notifications_page=",$pid,1,10,"created_at DESC");
							foreach ($get_notifications as $notifications):
								if (is_array($notifications) || is_object($notifications))
								{
									foreach ($notifications as $notification):
						?>
					<tr>
						<td class="text-center" data-title="رقم البلاغ">#<?php echo $notification['id']; ?></td>
						<td class="text-center" data-title="اسم المُبلّغ"><?php echo $notification['notify_name']; ?></td>
						<td class="text-center" data-title="اسم الحاج"><?php echo $notification['who_lost_name']; ?></td>
						<td class="text-center" data-title="مكان البلاغ"><?php echo $notification['the_place']; ?></td>
						<td class="text-center" data-title="تاريخ البلاغ"><?php echo convert_date($notification['created_at']); ?></td>
						<td class="text-center" data-title="الإجراءات"><a role="button" class="btn btn-primary" href="v=<?php echo $notification['id']; ?>"><i class="fa fa-eye"></i></a></td>
					</tr>
					<?php $counter++; endforeach; ?>
				<?php } endforeach; ?>
					</tbody>
				</table>
				<?php } ?>
			</div>
			<!-- end: LOGIN BOX -->
		</div>
<?php include_once "footer.php"; ?>
