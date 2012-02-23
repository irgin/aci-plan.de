<?php require_once('Connections/standart.php'); ?><?php $projektid = $_GET['projekt'] ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO aktuelleprojekte_bilder (id, projektid, bildlink) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['projektid'], "text"),
                       GetSQLValueString($_POST['bildlink'], "text"));

  mysql_select_db($database_standart, $standart);
  $Result1 = mysql_query($insertSQL, $standart) or die(mysql_error());
}

if ((isset($_POST['delete'])) && ($_POST['delete'] != "")) {
  $deleteSQL = sprintf("DELETE FROM aktuelleprojekte_bilder WHERE id=%s",
                       GetSQLValueString($_POST['delete'], "int"));

  mysql_select_db($database_standart, $standart);
  $Result1 = mysql_query($deleteSQL, $standart) or die(mysql_error());
}

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

$colname_projekte = "-1";
if (isset($_GET['projekt'])) {
  $colname_projekte = $_GET['projekt'];
}
mysql_select_db($database_standart, $standart);
$query_projekte = sprintf("SELECT * FROM tbl_projekte WHERE id = %s", GetSQLValueString($colname_projekte, "int"));
$query_limit_projekte = sprintf("%s LIMIT %d, %d", $query_projekte, $startRow_projekte, $maxRows_projekte);
$projekte = mysql_query($query_limit_projekte, $standart) or die(mysql_error());
$row_projekte = mysql_fetch_assoc($projekte);

if (isset($_GET['totalRows_projekte'])) {
  $totalRows_projekte = $_GET['totalRows_projekte'];
} else {
  $all_projekte = mysql_query($query_projekte);
  $totalRows_projekte = mysql_num_rows($all_projekte);
}
$totalPages_projekte = ceil($totalRows_projekte/$maxRows_projekte)-1;

mysql_select_db($database_standart, $standart);
$query_weiterebilder = "SELECT * FROM referenzen_bilder WHERE album = '$projektid' ORDER BY folge ASC";
$weiterebilder = mysql_query($query_weiterebilder, $standart) or die(mysql_error());
$row_weiterebilder = mysql_fetch_assoc($weiterebilder);
$totalRows_weiterebilder = mysql_num_rows($weiterebilder);

$query_bauherren = 'SELECT * FROM bauherren WHERE id = '.$row_projekte['bauherr_'];
$bauherren = mysql_query($query_bauherren, $standart) or die(mysql_error());
$row_bauherren = mysql_fetch_assoc($bauherren);


/*
mysql_select_db($database_standart, $standart);
$query_Recordset1 = "SELECT * FROM aktuelleprojekte_bilder WHERE projektid = '$projektid' ORDER BY folge ASC";
$Recordset1 = mysql_query($query_Recordset1, $standart) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1); 
*/
?>
<style type="text/css">
<!--
.projektitel {
	border-bottom-width: thin;
	border-bottom-style: solid;
	border-bottom-color: #CC0000;
}
.textfeld {
	background-image: url(images/textfeld.jpg);
	background-repeat: no-repeat;
	background-position: right bottom;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	border: thin solid #999999;
}
.rahmen {
	border: thin solid #CCCCCC;
}
-->
</style>
	<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen">
	<script src="js/prototype.js" type="text/javascript"></script>
	<script src="js/scriptaculous.js?load=effects,builder" type="text/javascript"></script>
	<script src="js/lightbox.js" type="text/javascript"></script>
<table width="898" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="182" align="left" valign="top" bgcolor="#F4F4F4"><img src="bilder/aktuelle.jpg" width="193" alt=""></td>
    <td width="716" valign="top">
	<table width="30%" border="0" cellspacing="5" cellpadding="0" style="margin:5px;">
      <tr>
        <td align="left" valign="top">
			<h1>Aktuelle Projekte</h1>	
		</td>
		<td align="left">
			<a href="index.php?s=aktuelles">
				<img src="images/p2-links-07.gif" alt="" />
			</a>
		</td>
      </tr>
    </table>
    <?php if ($totalRows_projekte > 0) { // ***Projektbeschreibung*** ?>
    <table width="90%" border="0" cellspacing="5" cellpadding="0">
		<tr>
			<td width="16%" align="left" valign="top">
			<table width="100%" border="0" cellspacing="5" cellpadding="0">
				<tr>
					<td width="600" align="left" valign="top">
						<strong>
							<span class="projektitel">
							<?php echo $row_projekte['projektname']; ?>
							</span>
						</strong>
						<br />
						<br />
						<strong>Ort:</strong> <?php echo $row_projekte['ort']; ?><br />
						<?php if ($row_projekte['bauherr_']) { ?>
							<strong>Bauherr:</strong> <?php echo $row_bauherren['name']; echo ' // '.$row_bauherren['link']; ?><br />
						<?php } ?>
						<strong>Jahr:</strong> <?php echo $row_projekte['datum']; ?>
					</td>
				</tr>
			</table>
			</td>
		</tr>
    </table>
    <?php } // END ***Projektbeschreibung*** ?>
    <br>
    <?php // ***Bilder*** 
	  if ($totalRows_weiterebilder > 0) { ?>
        <table width="100%" border="0" cellspacing="5" cellpadding="0">
          <tr>
            <td width="96%" align="left" valign="top">
				<table>
					<tr>
						<?php
						$weiterebilder_endRow = 0;
						$weiterebilder_columns = 6; // Anzahl der Spalten nebeneinander
						$weiterebilder_hloopRow1 = 0; // first row flag
						do {
							if($weiterebilder_endRow == 0  && $weiterebilder_hloopRow1++ != 0) { ?> <tr> <?php }
							echo '
							<td align="center" valign="middle" bgcolor="#F4F4F4">
							  <table style="table-layout:fixed; height:50px;" cellpadding="0" cellspacing="7">
								  <tr>
								   <td valign="middle">
										<a href="bilder/projekte/'.$row_projekte['id'].'/'.$row_weiterebilder['bildlink'].'" rel="lightbox['.$row_projekte['id'].']" title="'.$row_weiterebilder['titel'].'">
										 <img src="bilder/projekte/'.$row_projekte['id'].'/'.$row_weiterebilder['bildlink'].'" border="0" width="90" /><br>
										</a> 
								   </td>
								  </tr>
							  </table>
							</td>';
							$weiterebilder_endRow++;
							if($weiterebilder_endRow >= $weiterebilder_columns) { ?>
								</tr>
								<?php
								$weiterebilder_endRow = 0;
							}
						} while ($row_weiterebilder = mysql_fetch_assoc($weiterebilder));
						if($weiterebilder_endRow != 0) {
							while ($weiterebilder_endRow < $weiterebilder_columns) {
								echo("<td>&nbsp;</td>");
								$weiterebilder_endRow++;
							}
						echo("</tr>");
						}?>
					</tr>
				</table>
	</td>
        </table>
		<?php } 
		// END ***Bilder***
		// ***Management*** ?>
        <br>
    <?php if (empty($_SESSION['MM_Username'])) { echo ""; } else { ?><table width="100%" border="0" cellspacing="5" cellpadding="0">
          <tr>
            <td width="2%" align="left" valign="top"><br />
            </td>
            <td width="96%" align="left" valign="top"><h1>Bild zu diesem Projekt hinzufügen</h1></td>
            <td width="2%" align="left" valign="top">&nbsp;</td>
          </tr>
        </table>
      
      <table width="100%" border="0" cellspacing="5" cellpadding="0">
        <tr>
          <td width="2%" align="left" valign="top"><p>&nbsp;</p></td>
          <td width="97%" align="left" valign="top"><strong>Das neue Bild muss im Ordner &quot;bilder/projekte/<?php echo $projektid ?>/&quot; liegen! </strong><br>
            <br>
            <br>
            <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
              <table width="100%" align="center">
                <tr valign="baseline">
                  <td width="13%" align="left" nowrap>Bildlink:</td>
                  <td width="87%"><input name="bildlink" type="text" class="textfeld" value="" size="32"></td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="left">&nbsp;</td>
                  <td><input type="submit" class="textfeld" value="Bild speichern!">
                    <input type="hidden" name="id" value="">
                    <input type="hidden" name="projektid" value="<?php echo $projektid ?>">
                    <input type="hidden" name="MM_insert" value="form1"></td>
                </tr>
              </table>
            </form>
          <p></p></td>
          <td width="1%" align="left" valign="top">&nbsp;</td>
        </tr>
      </table>
	  
      <?php if ($totalRows_Recordset1 > 0) { // Show if recordset not empty ?>
        <br>
        <table width="100%" border="0" cellspacing="5" cellpadding="0">
          <tr>
            <td width="2%" align="left" valign="top"><br />            </td>
            <td width="96%" align="left" valign="top"><h1>Bild von diesem Projekt entfernen</h1></td>
            <td width="2%" align="left" valign="top">&nbsp;</td>
          </tr>
        </table>
        <table width="100%" border="0" cellspacing="5" cellpadding="0">
          <tr>
            <td width="2%" align="left" valign="top"><br />            </td>
            <td width="96%" align="left" valign="top"><form action="" method="post" name="delete" id="delete">
                <select name="delete" id="delete">
<?php
do {  
?>
                  <option value="<?php echo $row_Recordset1['id']?>"><?php echo $row_Recordset1['bildlink']?></option>
                  <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
                </select>
                <input name="button" type="submit" class="textfeld" id="button" value="löschen!">
                </form>            </td>
            <td width="2%" align="left" valign="top">&nbsp;</td>
          </tr>
        </table>
        <?php } // END ***Management*** 
	} ?></td>
  </tr>
</table>
<?php
mysql_free_result($projekte);
mysql_free_result($weiterebilder);
?>
