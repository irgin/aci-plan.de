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
  $updateSQL = sprintf("UPDATE kontakt SET email=%s WHERE id=%s",
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_standart, $standart);
  $Result1 = mysql_query($updateSQL, $standart) or die(mysql_error());
}

mysql_select_db($database_standart, $standart);
$query_email = "SELECT * FROM kontakt WHERE id = 1";
$email = mysql_query($query_email, $standart) or die(mysql_error());
$row_email = mysql_fetch_assoc($email);
$totalRows_email = mysql_num_rows($email);
?><style type="text/css">
<!--
.textfeld {
	background-image: url(images/textfeld.jpg);
	background-repeat: no-repeat;
	background-position: right bottom;
	color: black;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	border: thin solid #999999;
}
.textfeldbtn {
	background: white;
	color: black;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	border: thin solid #999999;
}
-->
</style>
<table width="898" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="182" align="left" valign="top" bgcolor="#F4F4F4"><img src="bilder/kontakt.jpg" width="193"/></td>
    <td width="716" valign="top"><table width="100%" border="0" cellspacing="5" cellpadding="0">
      <tr>
        <td width="2%" align="left" valign="top"><br />
              <br />
              <br /></td>
        <td width="96%" align="left" valign="top"><h1>Kontakt-Formular</h1>
          <?php if (empty($_SESSION['MM_Username'])) { echo ""; } else { ?><?php if ($_GET['fu'] == "editkontakt") { echo '<a href="index.php?s=kontakt">Fenster schliessen</a>'; } else { ?><a href="index.php?s=kontakt&amp;fu=editkontakt">(Kontakt eMail adresse ändern</a>)<?php } ?><br />
          <br /><?php if ($_GET['fu'] == editkontakt) { ?>
          <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
            <table width="100%" align="center">
              <tr valign="baseline">
                <td width="13%" align="left" valign="middle" nowrap="nowrap">Email:</td>
                <td width="87%"><input type="text" name="email" value="<?php echo htmlentities($row_email['email'], ENT_COMPAT, ''); ?>" size="32" /></td>
              </tr>
              <tr valign="baseline">
                <td align="left" valign="middle" nowrap="nowrap">&nbsp;</td>
                <td><input type="submit" class="textfeld" value="eMail adresse speichern!" /></td>
              </tr>
            </table>
            <br />
            <input type="hidden" name="id" value="<?php echo $row_email['id']; ?>" />
            <input type="hidden" name="MM_update" value="form1" />
            <input type="hidden" name="id" value="<?php echo $row_email['id']; ?>" />
            <?php } ?>
            <?php } ?>
          </form>
          <div align="justify">Wir freuen uns immer über ein Feedback zu unserem Unternehmen und unseren Dienstleistungen. Wenn Sie gerne weitere Informationen haben
möchten oder ein konkretes Projekt haben, kontaktieren Sie uns bitte. Wir
freuen uns darauf, mit Ihnen zusammen zu arbeiten.</div></td>
        <td width="2%" align="left" valign="top">&nbsp;</td>
      </tr>
    </table>
      
      <table width="100%" border="0" cellspacing="5" cellpadding="0">
        <tr>
          <td width="2%" align="left" valign="top"><br />
</td>
          <td width="96%" align="left" valign="top"><?php if ($_GET['fu'] == "fe") { echo "<b>Bitte f&uuml;llen sie alle Felder aus!</b><br><br>"; } else if ($_GET['fu'] == "so") { echo "<b>Ihre Nachricht wurde erfolgreich versendet!</b><br><br>"; } else if ($_GET['fu'] == "no") { echo "<b>Es ist ein Fehler aufgetreten!</b><br><br>"; }?><table border="0" cellpadding="1" cellspacing="2">
  <form action="kontaktformular-auswerten.php" method="post">
  <tr>
    <td width="82" valign="middle">Name:</td>
    <td width="240" valign="middle"><input name="Name" size="40" type="text"></td>
  </tr>
  <tr>
    <td valign="middle">eMail:</td>
    <td valign="middle"><input name="Email" size="40" type="text"></td>
  </tr>
  <tr>
    <td valign="top">Nachricht:</td>
    <td><textarea name="Nachricht" cols="39" rows="8" class="textfeld"></textarea></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td><input name="Send" type="submit" class="textfeldbtn" value="Abschicken" />
      <input name="Reset" type="reset" class="textfeldbtn" value="Löschen" /></td>
  </tr>
  </form>
</table></td><td width="2%" align="left" valign="top">&nbsp;</td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="5" cellpadding="0">
        <tr>
          <td width="2%" align="left" valign="top"><br />
              <br />
              <br /></td>
          <td width="96%" align="left" valign="top"><h1>Impressum</h1>
          Verantwortlich für diese Seite: <br />
          <img src="bilder/logosmall.gif" width="79" height="31" /><br />
Drischer Str. 45<br />
52146 Würselen<br />
Tel.: (0 24 05) 48 95 10<br />
Fax: (0 24 05) 48 95 20<br />
E-Mail: info@aci-plan.de<br />
www.aci-plan.de</td>
          <td width="2%" align="left" valign="top">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
<?php
mysql_free_result($email);
?>
