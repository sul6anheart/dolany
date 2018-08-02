<?php
$message = '
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
<title></title>
<style type="text/css">
/* CLIENT-SPECIFIC STYLES */
body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; direction: '.site_option('dir').';}
table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
img { -ms-interpolation-mode: bicubic; }

/* RESET STYLES */
img { border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
table { border-collapse: collapse !important; }
body { height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important; direction: '.site_option('dir').';}

/* iOS BLUE LINKS */
a[x-apple-data-detectors] {
    color: inherit !important;
    text-decoration: none !important;
    font-size: inherit !important;
    font-family: inherit !important;
    font-weight: inherit !important;
    line-height: inherit !important;
}

/* MOBILE STYLES */
@media screen and (max-width: 600px) {
  .img-max {
    width: 100% !important;
    max-width: 100% !important;
    height: auto !important;
  }

  .max-width {
    max-width: 100% !important;
  }

  .mobile-wrapper {
    width: 85% !important;
    max-width: 85% !important;
  }

  .mobile-padding {
    padding-left: 5% !important;
    padding-right: 5% !important;
  }
}

/* ANDROID CENTER FIX */
div[style*="margin: 16px 0;"] { margin: 0 !important; }
</style>
</head>
<body style="margin: 0 !important; padding: 0; !important background-color: #ffffff;" bgcolor="#ffffff">

<!-- HIDDEN PREHEADER TEXT -->

<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td align="center" valign="top" width="100%" bgcolor="#561e11" style="background: #561e11 background-size: cover; padding: 50px 15px;" class="mobile-padding">
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" class="mobile-wrapper">
                <tr>
                    <td align="center" valign="top" style="padding: 0 0 20px 0;">

                    </td>
                </tr>
                <tr>
                    <td align="center" valign="top" style="padding: 0;">
                        <h1 style="font-family: arial; font-weight: bold; font-size: 40px; color: #ffffff;">'.$subject.'</h1>
                        <p style="font-family: arial; font-weight: bold; color: #feedd3; font-size: 20px; line-height: 28px; margin: 0;">
                          '.$today_date.'
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align="center" height="100%" valign="top" width="100%" bgcolor="#f6f6f6" style="padding: 50px 15px;" class="mobile-padding">
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" class="mobile-wrapper">
                <tr>
                    <td align="center" valign="top" style="padding: 25px 0; font-family: arial; font-weight: bold;">
                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                            <tr>
                                <td align="center" bgcolor="#ffffff" style="border-radius: 3px 3px 0 0;">
                                </td>
                            </tr>
                            <tr>
                                <td align="center" bgcolor="#ffffff" style="border-radius: 0 0 3px 3px; padding: 25px;">
                                    <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                        <tr>
                                            <td style="font-family: arial; font-weight: bold;">
                                                <p style="font-family: arial; font-weight: bold; color: #999999; font-size: 16px; line-height: 24px; margin: 0;">
                                                  '.$message_text.'
                                                </p>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

</body>
</html>
';
 ?>
