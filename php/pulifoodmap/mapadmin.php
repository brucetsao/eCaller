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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_RecMap = 10;
$pageNum_RecMap = 0;
if (isset($_GET['pageNum_RecMap'])) {
  $pageNum_RecMap = $_GET['pageNum_RecMap'];
}
$startRow_RecMap = $pageNum_RecMap * $maxRows_RecMap;

mysql_select_db($database_conn_web, $conn_web );
$query_RecMap = "SELECT * FROM maplist ORDER BY mapId DESC";
$query_limit_RecMap = sprintf("%s LIMIT %d, %d", $query_RecMap, $startRow_RecMap, $maxRows_RecMap);
$RecMap = mysql_query($query_limit_RecMap, $conn_web ) or die(mysql_error());
$row_RecMap = mysql_fetch_assoc($RecMap);

if (isset($_GET['totalRows_RecMap'])) {
  $totalRows_RecMap = $_GET['totalRows_RecMap'];
} else {
  $all_RecMap = mysql_query($query_RecMap);
  $totalRows_RecMap = mysql_num_rows($all_RecMap);
}
$totalPages_RecMap = ceil($totalRows_RecMap/$maxRows_RecMap)-1;

$queryString_RecMap = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_RecMap") == false && 
        stristr($param, "totalRows_RecMap") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_RecMap = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_RecMap = sprintf("&totalRows_RecMap=%d%s", $totalRows_RecMap, $queryString_RecMap);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>埔里美食地圖 - 管理介面</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function tfm_confirmLink(message) { //v1.0
	if(message == "") message = "Ok to continue?";	
	document.MM_returnValue = confirm(message);
}
</script>
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
          <td height="40" valign="top"><a href="mapadminadd.php">新增景點</a> | <a href="<?php echo $logoutAction ?>">登出管理</a></td>
        </tr>
      </table>
      <table width="98%" align="center" class="maptable">
        <tr>
          <th>編號</th>
          <th>景點名稱</th>
          <th>經緯度</th>
          <th>電話</th>
          <th>地址</th>
          <th>管理</th>
        </tr>
        <?php do { ?>
          <tr class="alt">
            <td align="center"><?php echo $row_RecMap['mapId']; ?></td>
            <td><?php echo $row_RecMap['mapName']; ?></td>
            <td><?php echo $row_RecMap['mapLat']; ?>,<?php echo $row_RecMap['mapLng']; ?></td>
            <td><?php echo $row_RecMap['mapTel']; ?></td>
            <td><?php echo $row_RecMap['mapAddr']; ?></td>
            <td><a href="mapadminedit.php?uid=<?php echo $row_RecMap['mapId']; ?>">編輯</a> <a href="mapadmindele.php?uid=<?php echo $row_RecMap['mapId']; ?>&amp;delmap=true" onclick="tfm_confirmLink('確定要刪除這個景點？');return document.MM_returnValue">刪除</a></td>
          </tr>
          <?php } while ($row_RecMap = mysql_fetch_assoc($RecMap)); ?>
      </table>
      <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr valign="bottom">
          <td height="40">
          記錄 <?php echo ($startRow_RecMap + 1) ?> 到 <?php echo min($startRow_RecMap + $maxRows_RecMap, $totalRows_RecMap) ?> 共 <?php echo $totalRows_RecMap ?></td>
          <td align="right"><?php if ($pageNum_RecMap > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_RecMap=%d%s", $currentPage, 0, $queryString_RecMap); ?>">第一頁</a>
            <?php } // Show if not first page ?>
            <?php if ($pageNum_RecMap > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_RecMap=%d%s", $currentPage, max(0, $pageNum_RecMap - 1), $queryString_RecMap); ?>">上一頁</a>
            <?php } // Show if not first page ?>
            <?php if ($pageNum_RecMap < $totalPages_RecMap) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_RecMap=%d%s", $currentPage, min($totalPages_RecMap, $pageNum_RecMap + 1), $queryString_RecMap); ?>">下一頁</a>
            <?php } // Show if not last page ?>
            <?php if ($pageNum_RecMap < $totalPages_RecMap) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_RecMap=%d%s", $currentPage, $totalPages_RecMap, $queryString_RecMap); ?>">最後一頁</a>
            <?php } // Show if not last page ?></td>
        </tr>
      </table>
    </div>
  </div>
  <div id="footer">  
<strong>埔里美食地圖</strong> &nbsp;版權所有 by BruceTsao. All Rights Reserved. </div></div>
</body>
</html>
<?php
mysql_free_result($RecMap);
?>
