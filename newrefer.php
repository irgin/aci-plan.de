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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO referenzen (id, erstelltam, bilder, albumid, cat, albumtitel) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['erstelltam'], "text"),
                       GetSQLValueString($_POST['bilder'], "text"),
                       GetSQLValueString($_POST['albumid'], "text"),
                       GetSQLValueString($_POST['cat'], "text"),
                       GetSQLValueString($_POST['albumtitel'], "text"));

  mysql_select_db($database_standart, $standart);
  $Result1 = mysql_query($insertSQL, $standart) or die(mysql_error());
}
?><style type="text/css">
<!--
.textfeld {
	background-repeat: no-repeat;
	background-position: right bottom;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	border: thin solid #999999;
}
.album {	background-color: #FFFFFF;
	height: 100px;
	width: 100px;
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
-->
</style>
<table width="898" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="182" align="left" valign="top" bgcolor="#F4F4F4"><img src="bilder/referenzen.jpg" width="193"/></td>
    <td width="716" valign="top"><table width="100%" border="0" cellspacing="5" cellpadding="0">
      <tr>
        <td width="2%" align="left" valign="top"><br />
              <br />
              <br /></td>
        <td width="96%" align="left" valign="top"><h1>Neues Album erstellen!</h1>
          <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
            <table width="100%" align="center">
              <tr valign="baseline">
                <td width="13%" align="right" nowrap>Kategorie:</td>
                <td width="87%"><select name="cat" class="textfeld" id="cat">
                    <option value="1" selected>Einfamilienhäuser</option>
                    <option value="2">Geschosswohnungsbau</option>
                    <option value="3">Gewerbeimmobilien</option>
                    <option value="4">Städtebau</option>
                    <option value="5">Wettbewerbe</option>
                  </select>
                  </td>
              </tr>
              <tr valign="baseline">
                <td nowrap align="right">Albumtitel:</td>
                <td><input name="albumtitel" type="text" class="textfeld" value="" size="32"></td>
              </tr>
              <tr valign="baseline">
                <td nowrap align="right">&nbsp;</td>
                <td><input type="submit" class="textfeld" value="Album erstellen"></td>
              </tr>
            </table>
            <input type="hidden" name="id" value="">
            <input type="hidden" name="erstelltam" value="<?php $datum = date("d.m.Y") ?><?php echo $datum ?>">
            <input type="hidden" name="bilder" value="0">
            <input type="hidden" name="albumid" value="1">
            <input type="hidden" name="MM_insert" value="form1">
            <br>
          </form>
          </td>
        <td width="2%" align="left" valign="top">&nbsp;</td>
      </tr>
    </table>
      <table width="100%" border="0" cellspacing="5" cellpadding="0">
        <tr>
          <td width="2%" align="left" valign="top"><br />
              <br />
              <br /></td>
          <td width="96%" align="left" valign="top"><h1>Ausführliche Anleitung</h1>
          1.
          Erstellen Sie mit dem Formular ein neues Album.<br />
          2. Gehen Sie in die Referenzen und dort in die von Ihnen zuvor gewählte Kategorie.<br />
          3. Im Titel des neuen Albums steht eine ID, merken Sie sich diese.<br />
          4. Gehen Sie nun in den Ordner &quot;bilder/referenzen&quot; und erstellen dort einen Ordner mit der ID als namen.<br />
          - Dort werden alle Bilder gespeichert die in diesem Album zu finden sein sollen.<br />
          <br />
          5. Kopieren Sie das Vorschaubild für dieses Album in den Ordner &quot;bilder/referenzen&quot; und nennen dieses bild <strong>ID</strong>.jpg <strong>// ID muss durch die ID des Albums ersetzt werden!<br />
          <br />
          </strong>6. Gehen Sie nun in Ihr neu erstelltes Album und scrollen Sie zu &quot;Neues Bild hinzufügen&quot; dort geben Sie nun den Bildtitel ein und den dateinamen  (Das bild muss in dem Album Ordner liegen).<br />
          <br />
          <strong>7. Anschließend klicken Sie auf &quot;Bild speichern&quot;</strong></td>
          <td width="2%" align="left" valign="top">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
