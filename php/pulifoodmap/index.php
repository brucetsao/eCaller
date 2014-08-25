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

mysql_select_db($database_conn_web, $conn_web);
$query_RecMap = "SELECT * FROM maplist ORDER BY mapId DESC";
$RecMap = mysql_query($query_RecMap, $conn_web) or die(mysql_error());
$row_RecMap = mysql_fetch_assoc($RecMap);
$totalRows_RecMap = mysql_num_rows($RecMap);

$maxRows_Recordset1 = 10;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_conn_web, $conn_web);
$query_Recordset1 = "SELECT * FROM maplist";
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $conn_web) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;

$query_RecMap = "SELECT * FROM maplist ORDER BY mapId DESC";
$RecMap = mysql_query($query_RecMap, $conn_web) or die(mysql_error());
$row_RecMap = mysql_fetch_assoc($RecMap);
$totalRows_RecMap = mysql_num_rows($RecMap);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>埔里美食地圖</title>
<link href="style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script language="javascript">
//-------------------------------------------------------------------------
//[加入GoogleMap地圖 ver3]
//1.可加入多個景點,點選時會顯示資訊視窗
//2.每景點的資訊視窗中可顯示景點名稱及詳細資料
//3.景點資訊視窗可顯示街景縮圖,點選會進入街景模式
// 
//-------------------------------------------------------------------------
//景點資料,可多筆，每筆資料格式為 {'name':'名稱', 'lat':'緯度', 'lng':'經度', 'desc':'說明', 'tel':'電話', 'addr':'住址'},
var google_maps_data = [
<?php do {?>
{'name':'<?php echo $row_RecMap['mapName']; ?>', 'lat':'<?php echo $row_RecMap['mapLat']; ?>', 'lng':'<?php echo $row_RecMap['mapLng']; ?>', 'desc':'<?php echo $row_RecMap['mapDesc']; ?>', 'tel':'<?php echo $row_RecMap['mapTel']; ?>', 'addr':'<?php echo $row_RecMap['mapAddr']; ?>'},
<?php }while ($row_RecMap = mysql_fetch_assoc($RecMap));?>
];
//顯示GoogleMap
function loadGoogleMap() {
	//設定中心點
		var center = new google.maps.LatLng(23.96612, 120.96626);

	//var center = new google.maps.LatLng(24.059240, 120.431446);
	// 改變上行就可以改變  顯示google map 中心點
	// 上行 為顯示地圖中心點
	//鹿港天后宮   505彰化縣鹿港鎮中山路414號  
	//鹿港天后宮 24.059240, 120.431446
	var markers = [];
	//設定地圖顯示圖層
	var map = new google.maps.Map(document.getElementById('map_div'), {
		zoom: 16,
		center: center,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	});	
	//  map_div 就是輸出地圖到哪一個網頁版面
	//加上景點
	// zoom :n 代表 google map 地圖顯示比例
	
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
  <div id="logo"><a href="index.php" target="_self"><img src="images/pulifoodmaplogo.png" width="157" height="143" alt="logo"></a></div>
  </div>
  <div id="content">
    <div id="map_list">
      <table width="100%" border="0">
        <tr>
          <?php do { ?>
            <td><a href="<?php echo $row_Recordset1['map_web']; ?>" target="_blank"><?php echo $row_Recordset1['mapName']; ?></a></td>
            <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
        </tr>
      </table>
    </div>
    <div id="map_div">
      <p>&nbsp;</p>
      <p>&nbsp;</p>
    </div>
  </div>
  <div id="footer">  
      <strong><a href="../weblink/weblinklist.php" target="_self">埔里美食地圖</a></strong> &nbsp;版權所有 by BruceTsao. 
<a href="mapadmin.php">管理</a>(v1.1)</div></div>
</body>
</html>
<?php
mysql_free_result($RecMap);

mysql_free_result($Recordset1);
?>
