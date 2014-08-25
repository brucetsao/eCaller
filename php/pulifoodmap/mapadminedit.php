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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE maplist SET mapName=%s, mapDesc=%s, mapLat=%s, mapLng=%s, mapTel=%s, mapAddr=%s, map_web=%s, map_fb=%s, map_blog=%s WHERE mapId=%s",
                       GetSQLValueString($_POST['mapName'], "text"),
                       GetSQLValueString($_POST['mapDesc'], "text"),
                       GetSQLValueString($_POST['mapLat'], "text"),
                       GetSQLValueString($_POST['mapLng'], "text"),
                       GetSQLValueString($_POST['mapTel'], "text"),
                       GetSQLValueString($_POST['mapAddr'], "text"),
                       GetSQLValueString($_POST['map_web'], "text"),
                       GetSQLValueString($_POST['map_fb'], "text"),
                       GetSQLValueString($_POST['map_blog'], "text"),
                       GetSQLValueString($_POST['mapId'], "int"));

  mysql_select_db($database_conn_web, $conn_web);
  $Result1 = mysql_query($updateSQL, $conn_web) or die(mysql_error());

  $updateGoTo = "mapadmin.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_RecMap = "-1";
if (isset($_GET['uid'])) {
  $colname_RecMap = $_GET['uid'];
}
mysql_select_db($database_conn_web, $conn_web);
$query_RecMap = sprintf("SELECT * FROM maplist WHERE mapId = %s", GetSQLValueString($colname_RecMap, "int"));
$RecMap = mysql_query($query_RecMap, $conn_web) or die(mysql_error());
$row_RecMap = mysql_fetch_assoc($RecMap);
$totalRows_RecMap = mysql_num_rows($RecMap);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>埔里美食地圖 - 管理介面</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script language="javascript">
//-------------------------------------------------------------------------
//[加入GoogleMap地圖 ver3]
//1.可加入多個景點,點選時會顯示資訊視窗
//2.每景點的資訊視窗中可顯示景點名稱及詳細資料
//3.景點資訊視窗可顯示街景縮圖,點選會進入街景模式
//織夢平台 茶米 2012.10 http://www.dreamweaver.com.tw
//-------------------------------------------------------------------------
//景點資料,可多筆，每筆資料格式為 {'name':'名稱', 'lat':'緯度', 'lng':'經度', 'desc':'說明', 'tel':'電話', 'addr':'住址'},
var google_maps_data = [
{'name':'<?php echo $row_RecMap['mapName']; ?>', 'lat':'<?php echo $row_RecMap['mapLat']; ?>', 'lng':'<?php echo $row_RecMap['mapLng']; ?>', 'desc':'<?php echo $row_RecMap['mapDesc']; ?>', 'tel':'<?php echo $row_RecMap['mapTel']; ?>', 'addr':'<?php echo $row_RecMap['mapAddr']; ?>'},
];
//顯示GoogleMap
function loadGoogleMap() {
	//設定中心點
	var center = new google.maps.LatLng(<?php echo $row_RecMap['mapLat']; ?>, <?php echo $row_RecMap['mapLng']; ?>);
	var markers = [];
	//設定地圖顯示圖層
	var map = new google.maps.Map(document.getElementById('smap_div'), {
		zoom: 14,
		center: center,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	});	
	//加上景點
	var data_count = google_maps_data.length;
	for (var i = 0; i <data_count; i++) {
		var mapItem = google_maps_data[i];
		var latLng = new google.maps.LatLng(mapItem.lat, mapItem.lng);
		var marker = new google.maps.Marker({
			position: latLng,
			title: mapItem.name,
			animation: google.maps.Animation.DROP,
			map: map
		});
		markers.push(marker);
		var message = "<div class='markdiv'><div class='marktitle'>" + mapItem.name + "</div>" + mapItem.desc + "<br><div class='contactinfo'>電話："+mapItem.tel+"<br>住址："+mapItem.addr+"</div><a href='#' onClick='show_streeview()'><img src='http://cbk0.google.com/cbk?output=thumbnail&w=250&h=50&ll="+mapItem.lat+","+mapItem.lng+"'></a></div>"
		attachMessage(i, message, latLng);
	}
	//加上景點infowindow
	var info_window = [];
	function attachMessage(index, msg, latLng) {
		google.maps.event.addListener(markers[index], 'click', function(event) {
			close_other_makers(index);
			if (info_window[index]){
				info_window[index].close();
				info_window[index] = null;
				return;
			}
			info_window[index] = new google.maps.InfoWindow({
				content: msg,
				maxWidth: 280
			});
			info_window[index].open(markers[index].getMap(), markers[index]);		
			//將目前景點設為中心
			markers[index].getMap().panTo(latLng);
			//設定該景點街景
			panorama = markers[index].getMap().getStreetView();
			panorama.setPosition(latLng);
			panorama.setPov({
				heading: 0,
				zoom: 1,
				pitch: 0
			});
		});
	}
	//關閉所有景點infowindow
	function close_other_makers(index){
		var makers_count = markers.length;
		for (var i=0;i<makers_count;i++){
			if ( i == index ) continue;
			if (info_window[i]) info_window[i].close();
			info_window[i] = null;
		}
	}
}
//顯示街景
function show_streeview() {
	panorama.setVisible(true);
}
//啟動 GoogleMap
google.maps.event.addDomListener(window, 'load', loadGoogleMap);
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
          <td height="40" valign="top"><a href="mapadmin.php">管理首頁</a> | <a href="<?php echo $logoutAction ?>">登出管理</a></td>
        </tr>
      </table>
<form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1" id="form1">
  <table cellpadding="0" cellspacing="0" class="smaptable">
    <tr>
      <th align="right">名稱</th>
      <th>內容</th>
      </tr>
    <tr class="alt">
      <td align="right">名稱</td>
      <td><input name="mapName" type="text" id="mapName" style="width:300px" value="<?php echo $row_RecMap['mapName']; ?>" />
        <input name="mapId" type="hidden" id="mapId" value="<?php echo $row_RecMap['mapId']; ?>" /></td>
      </tr>
    <tr class="alt">
      <td align="right">地標</td>
      <td>緯度
        <input name="mapLat" type="text" id="mapLat" style="width:90px" value="<?php echo $row_RecMap['mapLat']; ?>" />
        經度
        <input name="mapLng" type="text" id="mapLng" style="width:90px" value="<?php echo $row_RecMap['mapLng']; ?>" /></td>
      </tr>
    <tr class="alt">
      <td align="right">電話</td>
      <td><input name="mapTel" type="text" id="mapTel" style="width:300px" value="<?php echo $row_RecMap['mapTel']; ?>" /></td>
      </tr>
    <tr class="alt">
      <td align="right">住址</td>
      <td><input name="mapAddr" type="text" id="mapAddr" style="width:300px" value="<?php echo $row_RecMap['mapAddr']; ?>" /></td>
      </tr>
    <tr class="alt">
      <td align="right">介紹</td>
      <td><textarea name="mapDesc" rows="5" id="mapDesc" style="width:300px"><?php echo $row_RecMap['mapDesc']; ?></textarea></td>
      </tr>
     <tr class="alt">
      <td align="right">官方網站</td>
      <td><p>
        <input name="map_web" type="text" id="map_web" style="width:300px" value="<?php echo $row_RecMap['map_web']; ?>" size="150" />
        </p>
        <p><a href="<?php echo $row_RecMap['map_web']; ?>" target="_blank"><?php echo $row_RecMap['map_web']; ?></a></p></td>
      </tr>
    <tr class="alt">
      <td align="right">官方臉書</td>
      <td><p>
        <input name="map_fb" type="text" id="map_fb" style="width:300px" value="<?php echo $row_RecMap['map_fb']; ?>" size="150" />
      </p>
        <p><a href="<?php echo $row_RecMap['map_fb']; ?>" target="_blank"><?php echo $row_RecMap['map_fb']; ?></a> </p></td>
      </tr>
    <tr class="alt">
      <td align="right">官方部落格</td>
      <td><p>
        <input name="map_blog" type="text" id="map_blog" style="width:300px" value="<?php echo $row_RecMap['map_blog']; ?>" size="150" />
      </p>
        <p><a href="<?php echo $row_RecMap['map_blog']; ?>" target="_blank"><?php echo $row_RecMap['map_blog']; ?></a> </p></td>
      </tr>
     
    <tr class="alt">
      <td colspan="2" align="center"><input type="submit" name="button" id="button" value="確定更新" />
        <input type="button" name="button2" id="button2" value="回上一頁" onclick="window.history.back();" /></td>
      </tr>
  </table>
  <div id="smap_div"></div>
  <input type="hidden" name="MM_update" value="form1" />
</form>
<div class="hr_div"></div>
    </div>
  </div>
  <div id="footer">  
      <strong>埔里美食地圖</strong> &nbsp;&nbsp;版權所有 by BruceTsao. All Rights Reserved. 
</div></div>
</body>
</html>
<?php
mysql_free_result($RecMap);
?>
