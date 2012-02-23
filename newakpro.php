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

if ((isset($_POST['delete'])) && ($_POST['delete'] != "")) {
  $deleteSQL = sprintf("DELETE FROM projekte WHERE id=%s",
                       GetSQLValueString($_POST['delete'], "int"));

  mysql_select_db($database_standart, $standart);
  $Result1 = mysql_query($deleteSQL, $standart) or die(mysql_error());
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO projekte (id, projektname, datum, ort, text, bild1, bild2, bild3) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['projektname'], "text"),
                       GetSQLValueString($_POST['datum'], "text"),
                       GetSQLValueString($_POST['ort'], "text"),
                       GetSQLValueString($_POST['text'], "text"),
                       GetSQLValueString($_POST['1'], "text"),
                       GetSQLValueString($_POST['2'], "text"),
                       GetSQLValueString($_POST['3'], "text"));

/*
$newordner = $_POST['neuerordner'];		   
  if ( mkdir ( "bilder/projekte/$newordner",0755,true ) )
{
  echo "";
}
*/
  mysql_select_db($database_standart, $standart);
  $Result1 = mysql_query($insertSQL, $standart) or die(mysql_error());
}

mysql_select_db($database_standart, $standart);
$query_projekte = "SELECT * FROM projekte ORDER BY id DESC";
$projekte = mysql_query($query_projekte, $standart) or die(mysql_error());
$row_projekte = mysql_fetch_assoc($projekte);
$totalRows_projekte = mysql_num_rows($projekte);

mysql_select_db($database_standart, $standart);
$query_lastid = "SELECT * FROM projekte ORDER BY id DESC";
$lastid = mysql_query($query_lastid, $standart) or die(mysql_error());
$row_lastid = mysql_fetch_assoc($lastid);
$totalRows_lastid = mysql_num_rows($lastid);
?><table width="898" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="182" align="left" valign="top" bgcolor="#F4F4F4"><img src="bilder/aktuelle.jpg" width="193"/></td>
    <td width="716" valign="top"><table width="100%" border="0" cellspacing="5" cellpadding="0">
          <tr>
            <td width="2%" align="left" valign="top"><br /></td>
            <td width="96%" align="left" valign="top"><h1>Neues Projekt anlegen</h1></td>
            <td width="2%" align="left" valign="top">&nbsp;</td>
          </tr>
      </table>
      <table width="100%" border="0" cellspacing="5" cellpadding="0">
        <tr>
          <td width="2%" align="left" valign="top"><br /></td>
          <td width="96%" align="left" valign="top"><form method="post" name="form1" action="<?php echo $editFormAction; ?>">
            <table width="100%" align="center">
              <tr valign="baseline">
                <td width="16%" align="right" valign="middle" nowrap>Projektname:</td>
                <td width="84%"><input type="text" name="projektname" value="" size="32"></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="middle" nowrap>Datum:</td>
                <td><input type="text" name="datum" size="32" value="<?php echo date("d.m.Y"); ?>"></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="middle" nowrap>Ort:</td>
                <td><input type="text" name="ort" value="" size="32"></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top" nowrap>Text:</td>
                <td valign="top"><textarea name="text" cols="50" rows="10"></textarea></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="middle" nowrap>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="middle" nowrap>&nbsp;</td>
                <td>Die Vorschaubilder müssen in den Ordner<strong> (bilder/projekte/<?php echo $row_lastid['id']; ?>/)</strong><br />
                    Dieser Ordner wird automatisch erstellt wenn das Projekt gespeichert wird!</td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="middle" nowrap="nowrap">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="middle" nowrap="nowrap">Vorschaubild (1):</td>
                <td><input name="1" type="text" id="1" size="32" /></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="middle" nowrap="nowrap">Vorschaubild (2):</td>
                <td><input name="2" type="text" id="2" size="32" /></td>
              </tr>
              
              <tr valign="baseline">
                <td align="right" valign="middle" nowrap>Vorschaubild (3):</td>
                <td><input name="3" type="text" id="3" size="32" /></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="middle" nowrap>&nbsp;</td>
                <td><strong><br />
                  Weitere Bilder können hinterher in der Projektansicht eingefügt werden!</strong><br />
                  <br />
                  <input type="submit" value="Projekt anlegen" /></td>
              </tr>
            </table>
            <input type="hidden" name="id" value="">
            <input type="hidden" name="MM_insert" value="form1">
            <input type="hidden" name="neuerordner" value="<?php echo $row_lastid['id']+1; ?>" />
          </form>
          <p>&nbsp;</p></td>
          <td width="2%" align="left" valign="top">&nbsp;</td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="5" cellpadding="0">
        <tr>
          <td width="2%" align="left" valign="top"><br /></td>
          <td width="96%" align="left" valign="top"><h1>Projekt löschen</h1></td>
          <td width="2%" align="left" valign="top">&nbsp;</td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="5" cellpadding="0">
        <tr>
          <td width="2%" align="left" valign="top"><br /></td>
          <td width="96%" align="left" valign="top"><form action="index.php?s=newakpro" method="post" name="loeschen" id="loeschen">
Projekt:
<select name="delete" id="delete">
  <?php
do {  
?>
  <option value="<?php echo $row_projekte['id']?>"><?php echo $row_projekte['projektname']?></option>
  <?php
} while ($row_projekte = mysql_fetch_assoc($projekte));
  $rows = mysql_num_rows($projekte);
  if($rows > 0) {
      mysql_data_seek($projekte, 0);
	  $row_projekte = mysql_fetch_assoc($projekte);
  }
?>
            </select>
<input type="submit" name="button" id="button" value="löschen">
          </form>
            - Der Ordner muss manuell gelöscht werden!</td>
          <td width="2%" align="left" valign="top">&nbsp;</td>
        </tr>
      </table>
      <br />
</td>
  </tr>
</table>
<?php
mysql_free_result($projekte);

mysql_free_result($lastid);
?>
