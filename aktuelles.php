<?php require_once('Connections/standart.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

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
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
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

$maxRows_projekte = 100;
$pageNum_projekte = 0;
if (isset($_GET['pageNum_projekte'])) {
  $pageNum_projekte = $_GET['pageNum_projekte'];
}
$startRow_projekte = $pageNum_projekte * $maxRows_projekte;

mysql_select_db($database_standart, $standart);
$query_projekte = "SELECT * FROM tbl_projekte WHERE cat = 0 AND active = 1 ORDER BY ort ASC";
$query_limit_projekte = sprintf("%s LIMIT %d, %d", $query_projekte, $startRow_projekte, $maxRows_projekte);
$projekte = mysql_query($query_limit_projekte, $standart) or die(mysql_error());

if (isset($_GET['totalRows_projekte'])) {
  $totalRows_projekte = $_GET['totalRows_projekte'];
} else {
  $all_projekte = mysql_query($query_projekte);
  $totalRows_projekte = mysql_num_rows($all_projekte);
}
$totalPages_projekte = ceil($totalRows_projekte/$maxRows_projekte)-1;
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
<!--
a:link {
	color: #333333;
	text-decoration:none;
}
a:visited {
	color: #333333;
	text-decoration:none;
}
a:hover {
	color: #333333;
	text-decoration:none;
}
a:active {
	color: #333333;
	text-decoration:none;
}
.projektitel {
	border-bottom: 1px solid #CC0000;
}
.rahmen {
	border: thin solid #CCCCCC;
}
-->
</style>
	<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />
	
	<script src="js/prototype.js" type="text/javascript"></script>
	<script src="js/scriptaculous.js?load=effects,builder" type="text/javascript"></script>
	<script src="js/lightbox.js" type="text/javascript"></script>
</head>

<body>
<table width="898" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="182" align="left" valign="top" bgcolor="#F4F4F4">
		<img src="bilder/aktuelle.jpg" width="193"/>
	</td>
    <td width="716" valign="top">
	<table width="100%" border="0" cellspacing="5" cellpadding="0" style="margin:5px;">
	<tr>
		<td width="96%" align="left" valign="top">
			<h1>Aktuelle Projekte (Auswahl)</h1>
		</td>
    </tr>
    </table>
    <table width="90%" cellspacing="0" cellpadding="5" style="margin-left: 20px">
      <?php if ($totalRows_projekte > 0) { // Show if recordset not empty
				while ($row_projekte = mysql_fetch_assoc($projekte)) {
					echo '
					<tr>
						<td align="right" width="20">
							<img border="0" width="10" alt="" src="images/pfeil-klein01.gif" />
						</td>
						<td width="200">';
						echo $row_projekte['ort'];
						if ($row_projekte['neu'] == 1) echo '<img style="padding-left:5px; display:inline" src="./bilder/neu.jpg" width="25px" height="19px" alt="" />';
						echo '</td>
						<td>	
						   <span class="projektitel"><strong>
							<a href="index.php?s=showap&amp;projekt='.$row_projekte['id'].'">'.$row_projekte['projektname'].'</a></strong>
						   </span>';
						echo '</td>
					</tr>';
				} 
			} // Sow if recordset not empty ?>
	</table><br><br>
<?php if ($totalRows_projekte == 0) { // Show if recordset empty ?>
		<table width="100%" border="0" cellspacing="5" cellpadding="0">
			<tr>
				<td width="96%" align="left" valign="top">
					Dieser Bereich wird im Moment bearbeitet und wird in den <br>
					nächsten Tagen wieder zur Verfügung stehen.<br><br>
					Wir Danken für Ihr Verständnis!<br>
				</td>
            </tr>
        </table>

		
<?php } // Show if recordset empty 
	  if (empty($_SESSION['MM_Username'])) { } else { ?>
      <table width="100%" border="0" cellspacing="5" cellpadding="0">
        <tr>
			<td width="2%" align="left" valign="top"><br />
            </td>
            <td width="96%" align="left" valign="top"><a href="index.php?s=newakpro">Neues Projekt anlegen</a></td>
            <td width="2%" align="left" valign="top">&nbsp;</td>
        </tr>
      </table>
<?php } ?>
  </table>
 </body>
</html>
<?php
mysql_free_result($projekte);
?>