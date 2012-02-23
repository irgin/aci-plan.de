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

$colname_alben = "-1";
if (isset($_GET['function'])) {
  $colname_alben = $_GET['function'];
}
mysql_select_db($database_standart, $standart);
$query_alben = sprintf("SELECT * FROM tbl_projekte WHERE cat = %s AND active = 1 ORDER BY datum DESC", GetSQLValueString($colname_alben, "text"));
$alben = mysql_query($query_alben, $standart) or die(mysql_error());
// $row_alben = mysql_fetch_assoc($alben);
$totalRows_alben = mysql_num_rows($alben);
?><style type="text/css">
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
.album {
	background-color: #FFFFFF;
	height: 100px;
	width: 100px;
	border: thin solid #999999;
}
.bilderanzahl {
	color: #000000;
	padding:3px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	border: thin solid #999999;
	background-image: url(bilder/spacer.png);
	background-repeat: repeat;
	vertical-align: bottom;
}
.projektitel {
	border-bottom: 1px solid #CC0000;
} 
.rahmen {
	border: thin solid #CCCCCC;
}
-->
</style>
<table width="898" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="182" align="left" valign="top" bgcolor="#F4F4F4"><img src="bilder/referenzen.jpg" width="193"/></td>
    <td width="716" valign="top">
	<table width="90%" border="0" cellspacing="0" cellpadding="5" style="margin: 5px;">
      <tr>
        <td align="left" valign="top">
		<?php if ($_GET['function'] == 1) echo "<h1>Wohnungsbau</h1>"; 
			  else if ($_GET['function'] == 2) echo "<h1>Gewerbebau</h1>"; 
			  else if ($_GET['function'] == 3) echo "<h1>St&auml;dtebau/Wettbewerbe</h1>"; 
			  // else if ($_GET['function'] == 4) echo "<h1>Städtebau</h1>"; 
			  // else if ($_GET['function'] == 5) echo "<h1>Wettbewerbe</h1>";
		if ($totalRows_alben == 0) { // Show if recordset empty
			echo '<br />Dieser Bereich wird Ihnen in den nächsten Tagen wieder zur Verfügung stehen.';
		} // Show if recordset empty ?>
		</td>
	  </tr>	  
		<?php if (empty($_SESSION['MM_Username'])) { } else { ?><a href="index.php?s=newrefer">Neues Album erstellen!</a><?php } ?>
	  </table>
        <?php if ($totalRows_alben > 0) { // Show if recordset not empty ?>
      <table width="90%" cellspacing="5" cellpadding="5" style="margin-left: 20px">
<?php
$alben_endRow = 0;
$alben_columns = 5; // number of columns
$alben_hloopRow1 = 0; // first row flag
while ($row_alben = mysql_fetch_assoc($alben)) {
 //   if($alben_endRow == 0  && $alben_hloopRow1++ != 0) echo "<tr>";	
 echo '			<tr>
					<td width="50" valign="middle">'.$row_alben['datum'].'</td>
					<td>
					 <img height="9" border="0" width="10" alt="" src="images/pfeil-klein01.gif"/>
					</td>
					<td>
					 <span class="projektitel"><strong>
					 <a href="index.php?s=showrefercat&amp;album='.$row_alben['id'].'">'.$row_alben['projektname'].'</a>
					 </strong></span>
					</td>
					<td align="right" valign="top">'.$row_alben['ort'].'</td>
				</tr>';

/*	$alben_endRow++;
	if($alben_endRow >= $alben_columns) {
		$alben_endRow = 0;
	} */
} 
/* if($alben_endRow != 0) {
while ($alben_endRow < $alben_columns) {
    echo("<td>&nbsp;</td>");
    $alben_endRow++;
}
} */
?>
		</table>
		<?php } // Show if recordset not empty ?>
		</td>
      </tr>
</table>
<?php
mysql_free_result($alben);
?>