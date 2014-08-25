<?php require_once('../Connections/conn_web.php'); ?>

<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['username'])) {
  $loginUsername=$_POST['username'];
  $password=$_POST['passwd'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "mapadmin.php";
  $MM_redirectLoginFailed = "index.php";
  $MM_redirecttoReferrer = true;
  mysql_select_db($database_conn_web, $conn_web);
  
  $LoginRS__query=sprintf("SELECT username, passwd FROM sysadmin WHERE username=%s AND passwd=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $conn_web) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && true) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>埔里美食地圖 - 管理介面</title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="wrap">
  <div id="header">
  <div id="logo"><img src="images/pulifoodmaplogo.png" width="157" height="143" alt="logo"></div>
  </div>
  <div id="content">
    <div>
      <form ACTION="<?php echo $loginFormAction; ?>" id="form1" name="form1" method="POST">
        <table border="0" align="center" cellpadding="10" cellspacing="0">
          <tr>
            <td width="20%" align="right" valign="baseline">帳號</td>
            <td valign="baseline"><input type="text" name="username" id="username" style="width:200px" /></td>
          </tr>
          <tr>
            <td align="right" valign="baseline">密碼</td>
            <td valign="baseline"><input type="password" name="passwd" id="passwd" style="width:200px" /></td>
          </tr>
          <tr>
            <td colspan="2" align="center" valign="baseline"><input type="submit" name="button" id="button" value="登入管理" />
            <input type="button" name="button2" id="button2" value="回上一頁" onclick="window.history.back();" /></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
  <div id="footer">  
      <strong>埔里美食地圖</strong> &nbsp;&nbsp;版權所有 by BruceTsao. All Rights Reserved. 
</div></div>
</body>
</html>