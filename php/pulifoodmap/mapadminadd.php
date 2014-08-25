<?php require_once('../Connections/conn_web.php'); ?>

<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "maplogin.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO maplist (mapName, mapDesc, mapLat, mapLng, mapTel, mapAddr, map_web, map_fb, map_blog) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['mapName'], "text"),
                       GetSQLValueString($_POST['mapDesc'], "text"),
                       GetSQLValueString($_POST['mapLat'], "text"),
                       GetSQLValueString($_POST['mapLng'], "text"),
                       GetSQLValueString($_POST['mapTel'], "text"),
                       GetSQLValueString($_POST['mapAddr'], "text"),
                       GetSQLValueString($_POST['map_web'], "text"),
                       GetSQLValueString($_POST['map_fb'], "text"),
                       GetSQLValueString($_POST['map_blog'], "text"));

  mysql_select_db($database_conn_web, $conn_web);
  $Result1 = mysql_query($insertSQL, $conn_web) or die(mysql_error());

  $insertGoTo = "mapadmin.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
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
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr valign="bottom">
          <td valign="top"><a href="mapadmin.php">管理首頁</a> | <a href="<?php echo $logoutAction ?>">登出管理</a></td>
        </tr>
      </table>
<form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1" id="form1">
  <table width="80%" align="center" cellpadding="0" cellspacing="0" class="maptable">
    <tr>
      <th align="right">名稱</th>
      <th>內容</th>
      </tr>
    <tr class="alt">
      <td align="right">名稱</td>
      <td><input name="mapName" type="text" id="mapName" style="width:300px" /></td>
      </tr>
    <tr class="alt">
      <td align="right">地標</td>
      <td>緯度
        <input name="mapLat" type="text" id="mapLat" style="width:90px" />
        經度
        <input name="mapLng" type="text" id="mapLng" style="width:90px" /></td>
      </tr>
    <tr class="alt">
      <td align="right">電話</td>
      <td><input name="mapTel" type="text" id="mapTel" style="width:300px" /></td>
      </tr>
    <tr class="alt">
      <td align="right">住址</td>
      <td><input name="mapAddr" type="text" id="mapAddr" style="width:300px" /></td>
      </tr>
    <tr class="alt">
      <td align="right">介紹</td>
      <td><textarea name="mapDesc" rows="5" id="mapDesc" style="width:300px"></textarea></td>
      </tr>
    <tr class="alt">
      <td align="right">官方網站</td>
      <td><input name="map_web" type="text" id="map_web" style="width:300px" size="150" /></td>
      </tr>
    <tr class="alt">
      <td align="right">官方臉書</td>
      <td><input name="map_fb" type="text" id="map_fb" style="width:300px" size="150" /></td>
      </tr>
    <tr class="alt">
      <td align="right">官方部落格</td>
      <td><input name="map_blog" type="text" id="map_blog" style="width:300px" size="150" /></td>
      </tr>
    <tr class="alt">
      <td colspan="2" align="center"><input type="submit" name="button" id="button" value="確定新增" />
        <input type="button" name="button2" id="button2" value="回上一頁" onclick="window.history.back();" /></td>
      </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
    </div>
  </div>
  <div id="footer">  
      <strong>埔里美食地圖</strong> &nbsp;&nbsp;版權所有 by BruceTsao.All Rights Reserved. 
</div></div>
</body>
</html>