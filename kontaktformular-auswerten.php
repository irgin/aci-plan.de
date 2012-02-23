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

mysql_select_db($database_standart, $standart);
$query_email = "SELECT * FROM kontakt";
$email = mysql_query($query_email, $standart) or die(mysql_error());
$row_email = mysql_fetch_assoc($email);
$totalRows_email = mysql_num_rows($email);
?>
<?php
if($_REQUEST['Send'])
{
   if(empty($_REQUEST['Name']) || empty($_REQUEST['Email']) || empty($_REQUEST['Nachricht']))
   {
      Header("Location: index.php?s=kontakt&fu=fe"); 
   }
   else
   {
$sender = $_REQUEST['Email'];
$name = $_REQUEST['Name'];
$empfaenger = $row_email['email'];
$nachricht = $_REQUEST['Nachricht'];
$betreff = "Sie haben eine neue Nachricht erhalten!";
$mailtext = '<style type="text/css">
<!--
body {
	background-color: #FFFFFF;
}
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
}
-->
</style><table width="600" border="3" align="center" cellpadding="0" cellspacing="3" bgcolor="#FFFFFF">
  <tr>
    <td bgcolor="#565656"><img src="http://www.aci-plan.de/bilder/emailheader.jpg" width="183" height="109"></td>
  </tr>
  <tr>
    <td>Sie haben über das aci Kontaktformular eine Nachricht erhalten:<br>
    <br>
    <table width="100%" border="0" cellspacing="3" cellpadding="0">
      <tr>
        <td width="14%" align="left" valign="top"><b>Name:</b></td>
        <td width="86%" align="left" valign="top">';
$mailtext.= "$name";
$mailtext.='</td>
      </tr>
      <tr>
        <td align="left" valign="top"><b>eMail:</b> </td>
        <td align="left" valign="top"><a href="mailto:';
$mailtext.="$sender";
$mailtext.='">';
$mailtext.="$sender";
$mailtext.="</a>";
$mailtext.='</td>
      </tr>
      <tr>
        <td align="left" valign="top"><br><b>Nachricht:</b></td>
        <td align="left" valign="top"><br>';
$mailtext.="$nachricht";
$mailtext.='</td>
      </tr>
    </table></td>
  </tr>
</table>
';
$mailtext2 = '<style type="text/css">
<!--
body {
	background-color: #FFFFFF;
}
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
}
-->
</style><table width="600" border="3" align="center" cellpadding="0" cellspacing="3" bgcolor="#FFFFFF">
  <tr>
    <td bgcolor="#565656"><img src="http://www.aci-plan.de/bilder/emailheader.jpg" width="183" height="109"></td>
  </tr>
  <tr>
    <td>Ihre Nachricht ist erfolgreich bei uns eingegangen, Wir werden uns schnellst möglich darum kümmern<br><br>Ihre Nachricht an Uns:<br>
    <br>
    <table width="100%" border="0" cellspacing="3" cellpadding="0">
      <tr>
        <td width="14%" align="left" valign="top"><b>Name:</b></td>
        <td width="86%" align="left" valign="top">';
$mailtext2.= "$name";
$mailtext2.='</td>
      </tr>
      <tr>
        <td align="left" valign="top"><b>eMail:</b> </td>
        <td align="left" valign="top"><a href="mailto:';
$mailtext2.="$sender";
$mailtext2.='">';
$mailtext2.="$sender";
$mailtext2.="</a>";
$mailtext2.='</td>
      </tr>
      <tr>
        <td align="left" valign="top"><br><b>Nachricht:</b></td>
        <td align="left" valign="top"><br>';
$mailtext2.="$nachricht";
$mailtext2.='</td>
      </tr>
    </table></td>
  </tr>
</table>
';
$betreff2 = "Ihre Nachricht ist erfolgreich bei uns eingegangen!";
mail($empfaenger, $betreff, $mailtext, "From: $sender\n" . "Content-Type: text/html; charset=utf-8");
mail($sender, $betreff2, $mailtext2, "From: $empfaenger\n" . "Content-Type: text/html; charset=utf-8");
} }
Header("Location: index.php?s=kontakt&fu=so");
mysql_free_result($email);
?> 
<?php 
//$Empfaenger = $row_email['email'];

//if($_REQUEST['Send'])
//{
//   if(empty($_REQUEST['Name']) || empty($_REQUEST['Email']) || empty($_REQUEST['Nachricht']))
// {
//  Header("Location: index.php?s=kontakt&fu=fe"); 
// }
// else
// {
//      $Mailnachricht = "Sie haben folgende Nachricht erhalten: \n\n";
//      while(list($Formularfeld, $Wert)=each($_REQUEST))
//      {
//         if($Formularfeld!="Send")
//         {
//            $Mailnachricht .= $Formularfeld.": ".$Wert."\n";
//         }
//      }
//      $Mailnachricht .= "\nGesendet am: ";
//      $Mailnachricht .= date("d.m.Y H:i:s");
//      $Mailbetreff = "aci - Kontakt";
//      $Mailbetreff .= ;
//      mail($Empfaenger, $Mailbetreff, $Mailnachricht, "From: ".$_REQUEST['Email']);
//      Header("Location: index.php?s=kontakt&fu=so"); 
//   }
//   }
//  else
//  {
//   Header("Location: index.php?s=kontakt&fu=no"); 
//   }
?>