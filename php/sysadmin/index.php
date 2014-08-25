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

$MM_restrictGoTo = "loginfail.php";
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>後台管理</title>
<link href="../CSSStyle/webcss.css" rel="stylesheet" type="text/css" />
</head>

<body>
<p>&nbsp;</p>
<p><a href="sysmbrtlist.php" target="_self">後台帳號管理</a></p>
<p><a href="../news/newslist.php" title="最新消息管理" target="_self">最新消息管理</a></p>
<p><a href="../weblink/weblinklist.php" target="_self">好站連結管理</a></p>
<p><a href="../guestmsg/index.php" target="_self">留言版管理</a></p>
<p><a href="../pulifoodmap/index.php" title="埔里美食管理" target="_self">埔里美食管理</a></p>
<p><a href="../webalbum/admin.php" title="網路相簿管理" target="_self">網路相簿管理</a></p>
<p><a href="../member/index.php" title="會員管理" target="_self">會員管理</a></p>
<p><a href="../member/index.php" title="網路部落格管理" target="_self">網路部落格管理</a></p>
<p></p>
<p><a href="../shopcart/productlist.php" title="購物車模組產品管理" target="_self">購物車模組產品管理</a></p>
</body>
</html>