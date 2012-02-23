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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE sites SET seitenname=%s, inhaltstext=%s, bildlinks=%s, zuletztbearbeitet=%s, zuletztbearbeitetvon=%s, ersteltlam=%s WHERE id=%s",
                       GetSQLValueString($_POST['seitenname'], "text"),
                       GetSQLValueString($_POST['inhaltstext'], "text"),
                       GetSQLValueString($_POST['bildlinks'], "text"),
                       GetSQLValueString($_POST['zuletztbearbeitet'], "text"),
                       GetSQLValueString($_POST['zuletztbearbeitetvon'], "text"),
                       GetSQLValueString($_POST['ersteltlam'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_standart, $standart);
  $Result1 = mysql_query($updateSQL, $standart) or die(mysql_error());
}

$colname_edit = "-1";
if (isset($_GET['site'])) {
  $colname_edit = $_GET['site'];
}
mysql_select_db($database_standart, $standart);
$query_edit = sprintf("SELECT * FROM sites WHERE id = %s", GetSQLValueString($colname_edit, "int"));
$edit = mysql_query($query_edit, $standart) or die(mysql_error());
$row_edit = mysql_fetch_assoc($edit);
$totalRows_edit = mysql_num_rows($edit);
?>
<style type="text/css">
<!--
.textfeld {
	background-image: url(images/textfeld.jpg);
	background-repeat: no-repeat;
	background-position: right bottom;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	border: thin solid #999999;
}
.buttonsend {
	font-family: Georgia, "Times New Roman", Times, serif;
	font-size: 12px;
	font-weight: bold;
	color: #CC0000;
	background-color: #FFFFFF;
	border: thin solid #999999;
	padding:2px;
}
.grau {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #CCCCCC;
}
.info {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #666666;
}
-->
</style>
<table width="898" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="182" align="left" valign="top" bgcolor="#F4F4F4"><div align="center"><img src="bilder/<?php echo $row_edit['bildlinks']; ?>" width="193"/><br />
      (Aktuelles Bild)<br />
      <span class="info"><br />  
      <strong>Neues Bild einf&uuml;gen</strong><br />
      1. Das bild muss eine breite von 193px  haben.<br />
      <br />
      2. Danach das Bild in den Unterordner &quot;bilder/&quot; speichern.<br />
      <br />
      3. Bildnamen in das Textfeld &quot;Bildlink&quot; eintragen. (Mit der dateiengung z.B. .jpg)<br />
      <br />
    4. Speichern!</span></div></td>
    <td width="716" valign="top"><table width="100%" border="0" cellspacing="5" cellpadding="0">
      <tr>
        <td align="left" valign="top"><h1>Seite bearbeiten</h1><br />
          <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
            <table width="100%" align="center">
              <tr valign="baseline">
                <td width="11%" align="right" valign="middle" nowrap>Seitenname:</td>
                <td width="89%" valign="middle"><table width="453" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="192" valign="middle"><input name="seitenname" type="text" class="buttonsend" value="<?php echo htmlspecialchars($row_edit['seitenname'], ENT_COMPAT, ''); ?>" size="32" /></td>
                    <td width="261" align="center" valign="middle"><span class="grau">(Wird nur in der Titelleiste angezeigt!)</span></td>
                  </tr>
                </table></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="middle" nowrap>Bildlink:</td>
                <td valign="middle"><table width="453" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="192" valign="middle"><input name="bildlinks" type="text" class="buttonsend" value="<?php echo htmlentities($row_edit['bildlinks'], ENT_COMPAT, ''); ?>" size="32" /></td>
                      <td width="261" align="center" valign="middle"><span class="grau">(Weitere Informationen unter dem Bild))</span></td>
                    </tr>
                  </table></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="top" nowrap>Inhaltstext:</td>
                <td><textarea name="inhaltstext" cols="90" rows="20" class="textfeld"><?php echo htmlspecialchars($row_edit['inhaltstext'], ENT_COMPAT, ''); ?></textarea></td>
              </tr>
              <tr valign="baseline">
                <td nowrap align="right">&nbsp;</td>
                <td><input type="submit" class="buttonsend" value="Speichern!">
                  <input name="button" type="reset" class="buttonsend" id="button" value="Daten verwerfen" /></td>
              </tr>
            </table>
            <div align="right"><br />
              <a href="index.php?s=<?php echo $row_edit['id']; ?>">Zur&uuml;ck zur letzten Seite</a>
              <?php $datum = $datum = date("d.m.Y"); $uhrzeit = date("H:i");?>
                <input type="hidden" name="id" value="<?php echo $row_edit['id']; ?>">
                <input type="hidden" name="zuletztbearbeitet" value="<?php echo $datum ?> / <?php echo $uhrzeit ?> Uhr">
                <input type="hidden" name="zuletztbearbeitetvon" value="<?php echo $_SESSION['MM_Username'] ?>">
                <input type="hidden" name="ersteltlam" value="<?php echo htmlentities($row_edit['ersteltlam'], ENT_COMPAT, ''); ?>">
                <input type="hidden" name="MM_update" value="form1">
                <input type="hidden" name="id" value="<?php echo $row_edit['id']; ?>">
              </div>
          </form>
          </td>
      </tr>
    </table></td>
  </tr>
</table>
<?php
mysql_free_result($edit);
?>
