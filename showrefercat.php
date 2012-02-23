<?php require_once('Connections/standart.php'); ?>
<?php $eintragenin = $_GET['album'] ?>
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

if ((isset($_POST['delete'])) && ($_POST['delete'] != "")) {
  $deleteSQL = sprintf("DELETE FROM referenzen_bilder WHERE id=%s",
                       GetSQLValueString($_POST['delete'], "int"));

$neuebilderanzahl2 = $_POST['neuebilder2'];	
$sql = mysql_query("UPDATE referenzen SET bilder='$neuebilderanzahl2' WHERE id = '$eintragenin'") or die(mysql_error()); 

  mysql_select_db($database_standart, $standart);
  $Result1 = mysql_query($deleteSQL, $standart) or die(mysql_error());
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO referenzen_bilder (id, album, titel, bildlink) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['album'], "text"),
                       GetSQLValueString($_POST['titel'], "text"),
                       GetSQLValueString($_POST['bildlink'], "text"));

$neuebilderanzahl = $_POST['neuebilder'];				   
$sql = mysql_query("UPDATE referenzen SET bilder='$neuebilderanzahl' WHERE id = '$eintragenin'") or die(mysql_error()); 

  mysql_select_db($database_standart, $standart);
  $Result1 = mysql_query($insertSQL, $standart) or die(mysql_error());
}

$colname_alben = "-1";
if (isset($_GET['album'])) {
  $colname_alben = $_GET['album'];
}
/******************** Projekt erneut aus Projekt-Tabelle laden ********************/
mysql_select_db($database_standart, $standart);
$query_alben = sprintf("SELECT * FROM tbl_projekte WHERE id = %s AND active = 1", GetSQLValueString($colname_alben, "int"));
$alben = mysql_query($query_alben, $standart) or die(mysql_error());
$row_alben = mysql_fetch_assoc($alben);
$totalRows_alben = mysql_num_rows($alben);

$colname_referpics = "-1";
if (isset($_GET['album'])) {
  $colname_referpics = $_GET['album'];
}

/******************** Bilder-Tabelle sortiert nach Datum laden **********************/
mysql_select_db($database_standart, $standart);
$query_referpics = sprintf("SELECT * FROM referenzen_bilder WHERE album = %s ORDER BY folge ASC", GetSQLValueString($colname_referpics, "text"));
$referpics = mysql_query($query_referpics, $standart) or die(mysql_error());
$row_referpics = mysql_fetch_assoc($referpics);
$totalRows_referpics = mysql_num_rows($referpics);

$colname_Recordset1 = "-1";
if (isset($_GET['album'])) {
  $colname_Recordset1 = $_GET['album'];
}

$query_bauherren = 'SELECT * FROM bauherren WHERE id = '.$row_alben['bauherr_'];
$bauherren = mysql_query($query_bauherren, $standart) or die(mysql_error());
$row_bauherren = mysql_fetch_assoc($bauherren);

/*
mysql_select_db($database_standart, $standart);
$query_Recordset1 = sprintf("SELECT * FROM referenzen_bilder WHERE album = %s ORDER BY folge ASC", GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $standart) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1); */
?>
<style type="text/css">
<!--
.album {	background-color: #FFFFFF;
	height: 100px;
	width: 100px;
	border: thin solid #999999;
}
.textfeld {
	background-image: url(images/textfeld.jpg);
	background-repeat: no-repeat;
	background-position: right bottom;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	border: thin solid #999999;
}
.bilderanzahl {	color: #000000;
	padding:3px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	border: thin solid #999999;
	background-image: url(bilder/spacer.png);
	background-repeat: repeat;
	vertical-align: bottom;
}
.projektitel {
	border-bottom-width: thin;
	border-bottom-style: solid;
	border-bottom-color: #CC0000;
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
<table width="898" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="182" align="left" valign="top" bgcolor="#F4F4F4">
		<img src="bilder/referenzen.jpg" width="193"/>
	</td>
    <td width="716" valign="top">
	<table width="30%" border="0" cellspacing="5" cellpadding="0" style="margin:5px;">
      <tr>
        <td align="left" valign="top">
			<h1>
				<?php if ($row_alben['cat'] == "1") echo "Wohnungsbau"; else if ($row_alben['cat'] == "2") echo "Gewerbebau"; else if ($row_alben['cat'] == "3") echo "St&auml;dtebau/Wettbewerbe"; else if ($row_alben['cat'] == "4") echo "Städtebau"; else if ($row_alben['cat'] == "5") echo "Wettbewerbe";?>
			</h1>	
		</td>
		<td align="left">
			<a href="index.php?s=referenzen&function=<?php if ($row_alben['cat'] == "1") echo "1"; else if ($row_alben['cat'] == "2") echo "2"; else if ($row_alben['cat'] == "3") echo "3"; else if ($row_alben['cat'] == "4") echo "4"; else if ($row_alben['cat'] == "5") echo "5";?>">
				<img src="images/p2-links-07.gif" alt="" />
			</a>
		</td>
      </tr>
    </table>
     <?php if ($totalRows_alben > 0) { // Show if recordset not empty ?>
        <table width="90%" border="0" cellspacing="5" cellpadding="0">
              <tr>
                <td width="16%" align="left" valign="top">
				<table width="80%" border="0" cellspacing="5" cellpadding="0">
                <tr>
					<td width="600" align="left">
						<strong><span class="projektitel"><?php echo $row_alben['projektname']; ?></span></strong><br /><br />
						<strong>Ort:</strong> <?php echo $row_alben['ort']; ?><br />
						<?php  if ($row_alben['bauherr_']) { ?>
							<strong>Bauherr:</strong> <?php  echo $row_bauherren['name']; echo ' // '.$row_bauherren['link']; ?><br />
						<?php } ?>
						<strong>Jahr:</strong> <?php echo $row_alben['datum']; ?>
					</td>
				</tr>
				</table>
				<table width="100%" border="0" cellspacing="5" cellpadding="0">
				   <tr><td><?php echo $row_alben['text']; ?></td></tr>
				</table>                
			  </td>
            </tr>
        </table><br /><br />
      <?php } // Show if recordset not empty ?>
      <?php if ($totalRows_referpics > 0) { // Show if recordset not empty ?>
        <table width="100%" border="0" cellspacing="5" cellpadding="0">
          <tr>
            <td width="96%" align="left" valign="top">
			<table>
                <tr>
                  <?php
					$referpics_endRow = 0;
					$referpics_columns = 6; // number of columns
					$referpics_hloopRow1 = 0; // first row flag
					do {
						if($referpics_endRow == 0  && $referpics_hloopRow1++ != 0) echo "<tr>";
						echo'
												<td align="center" valign="top" bgcolor="#F4F4F4">
												  <table style="table-layout:fixed; width:105px; height:50px;" cellpadding="0" cellspacing="7">
													  <tr>
													   <td>
														<a href="bilder/projekte/'.$row_alben['id'].'/'.$row_referpics['bildlink'].'" rel="lightbox['.$row_alben['id'].']" title="'.$row_referpics['titel'].'"><img src="bilder/projekte/'.$row_alben['id'].'/'.$row_referpics['bildlink'].'" width="90" border="0" /><br></a>
													   </td>
													  </tr>
												  </table>
												</td>';
											$referpics_endRow++;
						if($referpics_endRow >= $referpics_columns) {
							?>
							</tr>
							<?php
							$referpics_endRow = 0;
						}
					} 
					while ($row_referpics = mysql_fetch_assoc($referpics));
					if($referpics_endRow != 0) {
					while ($referpics_endRow < $referpics_columns) {
						echo("<td>&nbsp;</td>");
						$referpics_endRow++;
					}
				echo("</tr>");
				}?>
              </table></td>
          </tr>
        </table>
        <?php } // Show if recordset not empty ?>
        <?php if ($totalRows_referpics == 0) { // Show if recordset empty ?>
          <table width="100%" border="0" cellspacing="5" cellpadding="0">
            <tr>
              <td width="2%" align="left" valign="top">&nbsp;</td>
              <td width="96%" align="left" valign="top"><br>
              In diesem Album befinden sich derzeit keine Bilder!</td>
              <td width="2%" align="left" valign="top">&nbsp;</td>
            </tr>
        </table>
          <?php } // Show if recordset empty ?>
<br>
      <?php if (empty($_SESSION['MM_Username'])) { echo ""; } else { ?><table width="100%" border="0" cellspacing="5" cellpadding="0">
        <tr>
          <td width="2%" align="left" valign="top"><br /></td>
          <td width="96%" align="left" valign="top"><h1>Neues bild hinzufügen</h1>
          <strong>Die Bilder müssen im Ordner &quot;bilder/referenzen/<?php echo $row_alben['id']; ?>/&quot; liegen!</strong></td>
          <td width="2%" align="left" valign="top">&nbsp;</td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="5" cellpadding="0">
        <tr>
          <td width="2%" align="left" valign="top">&nbsp;</td>
          <td width="96%" align="left" valign="top"><form method="post" name="form1" action="<?php echo $editFormAction; ?>">
              <table width="100%" align="center">
                <tr valign="baseline">
                  <td width="13%" align="left" nowrap>Bildtitel:</td>
                  <td width="87%"><input name="titel" type="text" class="textfeld" value="" size="32"></td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="left">Bildlink:</td><?php $akalbum = $_GET['album'] ?>
                  <td><input name="bildlink" type="text" class="textfeld" value="" size="32"></td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="left">&nbsp;</td>
                  <td><input type="submit" class="textfeld" value="Bild speichern!"></td>
                </tr>
              </table>
              <input type="hidden" name="id" value="">
              <input type="hidden" name="neuebilder" value="<?php echo $akvielbilder+1 ?>">
              <input type="hidden" name="album" value="<?php echo $akalbum ?>">
              <input type="hidden" name="MM_insert" value="form1">
          </form>
          </td>
          <td width="2%" align="left" valign="top"></td>
        </tr>
      </table>
      
      <?php if ($totalRows_Recordset1 > 0) { // Show if recordset not empty ?>
        <br>
        <table width="100%" border="0" cellspacing="5" cellpadding="0">
          <tr>
            <td width="2%" align="left" valign="top"><br /></td>
            <td width="96%" align="left" valign="top"><h1>Bild aus diesem Album entfernen</h1>                </td>
            <td width="2%" align="left" valign="top">&nbsp;</td>
          </tr>
              </table>
        <table width="100%" border="0" cellspacing="5" cellpadding="0">
          <tr>
            <td width="2%" align="left" valign="top"><br /></td>
            <td width="96%" align="left" valign="top"><form action="" method="post" name="delete" id="delete">
                <select name="delete" class="textfeld" id="delete">
                  <?php
do {  
?>
                  <option value="<?php echo $row_Recordset1['id']?>"><?php echo $row_Recordset1['titel']?> - <?php echo $row_Recordset1['bildlink']; ?></option>
                  <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
                </select>
                                <input name="button" type="submit" class="textfeld" id="button" value="löschen">
                                <input type="hidden" name="neuebilder2" value="<?php echo $akvielbilder-1 ?>">
                </form>            </td>
            <td width="2%" align="left" valign="top">&nbsp;</td>
          </tr>
              </table>
        <?php } // Show if recordset not empty ?><?php } ?></td>
  </tr>
</table>
<?php
mysql_free_result($alben);

mysql_free_result($referpics);
?>
