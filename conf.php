<?php
date_default_timezone_set("Asia/Riyadh");
include_once "class/phpqrcode/qrlib.php";
include_once "class/Barcode_Gen/generate-verified-files.php";
include_once "class/is_email.php";
include_once "class/hijri.class.php";
include_once "class/excel/PHPExcel/IOFactory.php";
include_once "class/PHPMailer/PHPMailerAutoload.php";
include_once "class/mpdf/mpdf.php";
$localhost = "localhost";
$usrname = "root";
$password = "";
$database_name = "dolny_project";

$conn = mysqli_connect($localhost,$usrname,$password,$database_name);
mysqli_set_charset($conn, 'utf8');
mysqli_query($conn,"SET NAMES 'utf-8'");
// Check connection
if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
include_once "class/DB_Functions.php";

function site_option($key)
{
    $get_key_value = row_one("site_options","op_key='".$key."'","");
    return $get_key_value['op_value'];
}
function update_site_option($key, $val)
{
    $value = array();
    $value["op_value"] = $val;
    update("site_options", $value,"op_key='".$key."'","");
}

function clear_cookies()
{
    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
    foreach($cookies as $cookie) {

        $parts = explode('=', $cookie);
        $name = trim($parts[0]);
        // print_r($name);
        // exit();
        unset($_COOKIE[$name]);
        setcookie($name, null, time()-3600);
        setcookie($name, null, time()-3600, '/');
    }
}


if(isset($_POST['logout']))
{
  clear_cookies();
  header("Location: cplogin");
}

function fetch_field($table_name, $col, $id, $col_name)
{
  $get_info = row_one($table_name, "".$col."='".$id."'", "");
  $col_name = $get_info[$col_name];
  return $col_name;
}

function get_shortlink($link)
{
  $id = generate_rand_num("short_links", "id", 0, 8, 4, 3);
  $val = array();
  $val['id'] = $id;
  $val['link'] = $link;
  $val['hide'] = 1;
  $val['created_at'] = date("Y-m-d H:i:s");
  $val['updated_at'] = date("Y-m-d H:i:s");
  Insertdb("short_links", $val);
  $the_link = $_SERVER['SERVER_NAME']."/rl=".$id;
  return $the_link;
}

function convert_date($date, $f = '')
{
  global $conf;
  if(!empty($date)){
    if(!empty($f))
    {
      $format = $f;
    }else {
      $format = site_option("format_date");
    }
    $convert_date = (new hijri\datetime(  $date, NULL, 'ar'  ))->format($format);
  }else{
    $convert_date = '-';
  }
  return $convert_date;
}
function rand_num_char($length)
{
			$len = $length;
			$string = "";
			$characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"; // change to whatever characters you want
			while ($len > 0) {
					$string .= $characters[mt_rand(0,strlen($characters)-1)];
					$len -= 1;
			}
			return $string;
}
function convert_num_to_en($string)
{
  $english = array('0','1','2','3','4','5','6','7','8','9');
  $arabic = array('٠','١','٢','٣','٤','٥','٦','٧','٨','٩');
  $str = str_replace($arabic, $english, $string);
  return $str;
}

function generate_rand_num($table_name, $col_nam, $min_num, $max_num, $limit, $plus_limit){
  $rand_id = "";
  for($i=0; $i<$limit; $i++)
  {
    $rand_id .= rand($min_num,$max_num);
  }
  $chcek_rand_num = row_one($table_name, "$col_nam='".$rand_id."'", "");
  if(!empty($chcek_rand_num))
  {
    $rand_number = $rand_id+$plus_limit;
  }else{
    $rand_number = $rand_id;
  }
  return $rand_number;
}
function send_email($to, $to_name, $from_email, $from_name, $subject, $content, $attachments = null )
{
  echo $message_text;
  include "email_template.php";
	$mail = new PHPMailer(true);
try {
    global $message;
    $mail->CharSet = 'UTF-8';
	  $mail->setFrom($from_email, $from_name);
	  $mail->addAddress($to, $to_name);
	  $mail->Subject = $subject;
	  $mail->msgHTML($message);
	  if($attachments != null)
	  {
		    $mail->addAttachment($attachments);
	  }
	   $mail->send();

	} catch (phpmailerException $e)
	  {
		echo $e->errorMessage();
	  } catch (Exception $e)
		{
		  echo $e->getMessage();
		}
}
function SendSMS($mobiles,$msgmobile)
{

  include_once "functionUnicode.php";
  $msgmobiles =  convertToUnicode(iconv('UTF-8','WINDOWS-1256', $msgmobile));

  $usernamemobile = site_option("sms_username");
  $passwordmoible = site_option("sms_password");
  $sendername = site_option("sms_sendername");

  $cons = curl_init();
  if(site_option("sms_provider") == "mobily"){
    $mobily = "http://mobily.ws/api/msgSend.php?mobile=$usernamemobile&password=$passwordmoible&numbers=$mobiles&sender=$sendername&msg=$msgmobiles&applicationType=24";
    curl_setopt($cons,CURLOPT_URL,$mobily);
  }
  elseif(site_option("sms_provider") == "gateway"){
    $gateway_sa = "https://sms.gateway.sa/api/sendsms.php?username=$usernamemobile&password=$passwordmoible&message=$msgmobiles&numbers=$mobiles&sender=$sendername&unicode=e&Rmduplicated=1&return=string";
    curl_setopt($cons,CURLOPT_URL,$gateway_sa);
  }
  elseif(site_option("sms_provider") == "yamamah"){
    $yamamah = "http://services.yamamah.com/yamamahwebservicev2.2/SMSService.asmx/SendSingleSMS?strUserName=$usernamemobile&strPassword=$passwordmoible&strTagName=$sendername&strRecepientNumber=$mobiles&strMessage=$msgmobile&sendDateTime=0";
    curl_setopt($cons,CURLOPT_URL,$yamamah);
  }
  elseif(site_option("sms_provider") == "malath"){
    $malath = "http://sms.malath.net.sa/httpSmsProvider.aspx?username=$usernamemobile&password=$passwordmoible&mobile=$mobiles&unicode=U&message=$msgmobiles&sender=$sendername";
    curl_setopt($cons,CURLOPT_URL,$malath);
  }

  curl_setopt($cons,CURLOPT_RETURNTRANSFER,true);
  curl_setopt($cons,CURLOPT_HEADER,false);
  $GoNow = curl_exec($cons);
  curl_close($cons);
  return $GoNow;
}

function upload_file($field_name, $allow_files, $file_path, $size)
{
  $output = "";
  10*pow(1024,2);
  if($field_name['size'] < ($size*pow(1024,2)) )
  {
    if(in_array($field_name['type'], $allow_files))
    {
      $start = explode(".", $field_name['name']);
      $ext = end($start);
      $filename = time()."_".rand(000000000,999999999).".".$ext;
      $new_path = dirname(__FILE__)."/".$file_path.$filename;
      move_uploaded_file($field_name['tmp_name'], $new_path);
      $output .= $file_path.$filename;
    }else{
      $output .= "NA";
    }
  }else {
     $output .= "SO";
  }
  return $output;
}
?>
