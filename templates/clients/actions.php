<?php
if(isset($_GET['check_mobile_number']) and $_GET['check_mobile_number'] == "true")
{
  $user_info = row_one("users", "mobile='".$_POST['mobile']."'", "");

  die();
}
if(isset($_GET['r_notification']) and $_GET['r_notification'] == "true")
{
  include_once "../../conf.php";
  $user_info = row_one("users", "mobile='".$_POST['mobile']."'", "");
  if(!empty($user_info))
  {
    $val = array();
    $val['status'] = 1;
    update("notifications", $val, "id='".$_POST['id']."'");
    $op = array();
    $id = generate_rand_num("operations", "id", 1, 8, 4, 3);
    $op['id'] = $id;
    $op['user_id'] = $user_info['id'];
    $op['notify_id'] = $_POST['id'];
    $op['operation_name'] = 'العثور على حاج تائه';
    $op['created_at'] = date("Y-m-d H:i:s");
    Insertdb("operations", $op);
    echo 'تمّ تعميد استلام البلاغ، نشكر لك تعاونك ونسأل الله أن يكتب لك الأجر العظيم تجاه ما تقوم به.';
  }else {
    echo 'لا يمكن استلام البلاغ نظرًا لأنّ رقم جوالك غير موجود بقاعدتنا.';
  }
  die();
}
if(isset($_POST['new_notification']))
{
  if($_SESSION['captcha']['code'] == $_POST['code'])
  {
    if(!empty($_POST['notify_name']) OR !empty($_POST['notify_mobile']) OR !empty($_POST['the_place']) OR !empty($_POST['who_lost_name']) OR !empty($_POST['who_lost_id']) )
    {
      $val = array();
      $id = generate_rand_num("notifications", "id", 1, 8, 4, 3);
      $val['id'] = $id;

      $val['notify_name'] = $_POST['notify_name'];
      $val['notify_mobile'] = $_POST['notify_mobile'];
      $val['the_place'] = $_POST['the_place'];
      $val['who_lost_sex'] = $_POST['who_lost_sex'];
      $val['who_lost_name'] = $_POST['who_lost_name'];
      $val['who_lost_id'] = $_POST['who_lost_id'];
      $val['who_lost_mobile'] = $_POST['who_lost_mobile'];
      $val['the_place'] = $_POST['the_place'];
      $val['status'] = 0;
      $val['created_at'] = date("Y-m-d H:i:s");
      if(!empty($_FILES['who_lost_photo']))
      {
        $val['who_lost_photo'] = upload_file($_FILES['who_lost_photo'],
        array(
        "image/png",
        "image/jpeg",
        "image/jpg",
        "image/bmp"),
        "uploads/",
        5
        );
      }
      Insertdb("notifications", $val);

      $msg = "<div class='alert alert-success'>";
      $msg .= "نشكرك على التبليغ ونفيدك بأنّه تمّ إصدار بلاغ جديد برقم <strong>".$id."</strong> كما يسعدنا إبلاغك بأنّنا قمنا بتبليغ كافة منتسبينا للبحث عنه في أقرب فرصة وإبلاغك مباشرةً.";
      $msg .= "</div>";


    }else {
      $msg = "<div class='alert alert-danger'>";
      $msg .= "عفوًا هنالك نقص في بعض الحقول الهامة، يجب تعبئة كافة الحقول المطلوبة قبل إرسال الطلب.";
      $msg .= "</div>";
    }

  }else {
    $msg = "<div class='alert alert-danger'>";
    $msg .= "عفوًا رمز التحقق المدخل غير صحيح، يرجى التأكد من ذلك مجددًا.";
    $msg .= "</div>";
  }
}



?>
