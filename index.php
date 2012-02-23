<?php require_once('Connections/standart.php'); ?>
<?php
if (empty($_GET)) $_GET['s']=1;
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $aktuell = $_GET['s'];
  $indexphp = "index.php?s=";
  $nachricht = "&messagebox=5";
  $logoutGoTo = "$indexphp$aktuell$nachricht";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}

?>
<?php session_start() ?>
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

$colname_getsite = "-1";
if (isset($_GET['s'])) {
  $colname_getsite = $_GET['s'];
}
mysql_select_db($database_standart, $standart);
$query_getsite = sprintf("SELECT * FROM sites WHERE id = %s", GetSQLValueString($colname_getsite, "int"));
$getsite = mysql_query($query_getsite, $standart) or die(mysql_error());
$row_getsite = mysql_fetch_assoc($getsite);
$totalRows_getsite = mysql_num_rows($getsite);
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['user'])) {
  $index = "index.php?s=4";
  $hier = $_POST['wobinich'];
  $message1 = "&messagebox=2";
  $message2 = "&messagebox=3";
  $loginUsername=$_POST['user'];
  $password=$_POST['pass'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "index.php?s=1";
  $MM_redirectLoginFailed = "index.php?s=1";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_standart, $standart);
  
  $LoginRS__query=sprintf("SELECT benutzername, passwort FROM aci_benutzer WHERE benutzername=%s AND passwort=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $standart) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html"; charset="utf-8" />
<title>aci- Gesellschaft f&uuml;r Projektentwicklung, Bauplanung und -management mbH - <?php echo $row_getsite['seitenname']; ?></title>
<link href="site_text/style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-color: #565656;
	margin-top: 0px;
}
-->
</style>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-29103771-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<script language="JavaScript1.2" type="text/javascript" src="mm_css_menu.js"></script>
<style type="text/css" media="screen">
	@import url("./navigation.css");
</style>
<style type="text/css" media="screen">
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
h1,h2,h3,h4,h5,h6 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
}
h1 {
	font-size: 14px;
	color: #999999;
}
a:link {
	color: #cd071e;
	text-decoration:underline;
}
a:visited {
	color: #cd071e;
	text-decoration:underline;
}
a:hover {
	color: #CD071E;
	text-decoration: underline;
}
.redbox {
	background-color: #CC0000;
}
a:active {
	color: #cd071e;
	text-decoration:underline;
}
#admin a {
	color: #333333;
	text-decoration: none;
}
        H1 { margin-bottom: 2px; }

        DIV#loader {
            border: 1px solid #ccc;
            width: 500px;
            height: 500px;
            overflow: hidden;
        }

        DIV#loader.loading {
            background: url(/images/loading.gif) no-repeat center center;
        }
</style>
</head>

<body>
<table width="900" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="900" border="0" align="center" cellpadding="0" cellspacing="20" class="header_table_logo">
      <tr>
        <td align="right" valign="middle" class="header_logo"></td>
      </tr>
    </table>
      <table border="0" align="center" cellpadding="0" cellspacing="0" class="header_navigation">
        <tr>
          <td><div id="FWTableContainer757161780"> <img name="navigation" src="bilder/navigation.jpg" width="880" height="21" border="0" id="navigation" usemap="#m_navigation" alt="" />
                <map name="m_navigation" id="m_navigation">
                  <area shape="poly" coords="398,0,452,0,452,21,398,21,398,0" href="index.php?s=kontakt" alt="" />
                  <area shape="poly" coords="21,0,81,0,81,21,21,21,21,0" href="index.php?s=1" alt="" />
                  <area shape="poly" coords="191,0,292,0,292,21,191,21,191,0" href="index.php?s=aktuelles" alt="" />
                  <area shape="poly" coords="312,0,382,0,382,21,312,21,312,0" href="javascript:;" alt="" onmouseout="MM_menuStartTimeout(100);"  onmouseover="MM_menuShowMenu('MMMenuContainer0423110247_0', 'MMMenu0423110247_0',191,21,'navigation');"  />
                  <area shape="poly" coords="101,0,169,0,169,21,101,21,101,0" href="javascript:;" alt="" onmouseout="MM_menuStartTimeout(100);"  onmouseover="MM_menuShowMenu('MMMenuContainer0423110247_1', 'MMMenu0423110247_1',101,21,'navigation');"  />
                </map>
                <div id="MMMenuContainer0423110247_0">
                  <div id="MMMenu0423110247_0" onmouseout="MM_menuStartTimeout(100);" onmouseover="MM_menuResetTimeout();"> 
					<a href="index.php?s=referenzen&amp;function=1" id="MMMenu0423110247_0_Item_0" class="MMMIFVStyleMMMenu0423110247_0" onmouseover="MM_menuOverMenuItem('MMMenu0423110247_0');"> -&nbsp;Wohnungsbau </a> 
					<a href="index.php?s=referenzen&amp;function=2" id="MMMenu0423110247_0_Item_1" class="MMMIVStyleMMMenu0423110247_0" onmouseover="MM_menuOverMenuItem('MMMenu0423110247_0');"> -&nbsp;Gewerbebau </a> 
					<a href="index.php?s=referenzen&amp;function=3" id="MMMenu0423110247_0_Item_2" class="MMMIVStyleMMMenu0423110247_0" onmouseover="MM_menuOverMenuItem('MMMenu0423110247_0');"> -&nbsp;St&auml;dtebau/Wettbewerbe </a> 
				<!--	<a href="index.php?s=referenzen&amp;function=4" id="MMMenu0423110247_0_Item_3" class="MMMIVStyleMMMenu0423110247_0" onmouseover="MM_menuOverMenuItem('MMMenu0423110247_0');"> -&nbsp;St&auml;dtebau </a> 
					<a href="index.php?s=referenzen&amp;function=5" id="MMMenu0423110247_0_Item_4" class="MMMIVStyleMMMenu0423110247_0" onmouseover="MM_menuOverMenuItem('MMMenu0423110247_0');"> -&nbsp;Wettbewerbe </a> -->
				  </div>
                </div>
            <div id="MMMenuContainer0423110247_1">
                  <div id="MMMenu0423110247_1" onmouseout="MM_menuStartTimeout(100);" onmouseover="MM_menuResetTimeout();"> 
					<a href="index.php?s=2" id="MMMenu0423110247_1_Item_0" class="MMMIFVStyleMMMenu0423110247_1" onmouseover="MM_menuOverMenuItem('MMMenu0423110247_1');"> -&nbsp;St&auml;dtebau </a> 
					<a href="index.php?s=3" id="MMMenu0423110247_1_Item_1" class="MMMIVStyleMMMenu0423110247_1" onmouseover="MM_menuOverMenuItem('MMMenu0423110247_1');"> -&nbsp;Architektur </a> 
				  </div>
            </div>
          </div></td>
        </tr>
      </table>
      <table width="900" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
        <tr>
          <td><?php if ($totalRows_getsite == 0) { // Show if recordset empty ?>
              <?php $sitename = $_GET['s']; ?>
              <?php include "$sitename.php" ?>
              <?php } // Show if recordset empty ?>
<?php if ($totalRows_getsite > 0) { // Show if recordset not empty ?>
              <table width="898" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="182" align="left" valign="top" bgcolor="#F4F4F4"><img src="bilder/<?php echo $row_getsite['bildlinks']; ?>" width="193" /></td>
                  <td width="716" valign="top"><?php if ($_GET['messagebox'] == 1) {?>
                      </p>
                      <table width="100%" border="0" cellpadding="0" cellspacing="5">
                        <tr>
                          <td width="2%" align="left" valign="top"><br />
                              <br />
                              <br /></td>
                          <td width="96%" align="left" valign="top"><form id="login" name="login" method="post" action="<?php echo $loginFormAction; ?>">
                            <table width="100%" border="0" cellpadding="0" cellspacing="5" bgcolor="#F4F4F4" class="login">
                              <tr>
                                <td width="130"><h1>BenutzerLogin</h1></td>
                                <td width="755">&nbsp;</td>
                              </tr>
                              <tr>
                                <td>Name:</td>
                                <td><input name="user" type="text" id="user" size="35" /></td>
                              </tr>
                              <tr>
                                <td>Passwort:</td>
                                <td><input name="pass" type="password" id="pass" size="35" /></td>
                              </tr><input name="wobinich" type="hidden" id="wobinich" size="35" value="<?php echo $_GET['s'] ?>"/>
                              <tr>
                                <td>&nbsp;</td>
                                <td><input type="submit" name="button" id="button" value="Einloggen" />
                                <br />
                                <br /></td>
                              </tr>
                            </table>
                                                    </form></td>
                          <td width="2%" align="left" valign="top">&nbsp;</td>
                        </tr>
                      </table>
                    <p><?php } ?></p>
                    <table width="100%" border="0" cellspacing="5" cellpadding="0">
                      <tr>
                        <td width="2%" align="left" valign="top"><br />
                          <br />
                        <br /></td>
                        <td width="96%" align="left" valign="top"><div align="justify"><?php echo ($row_getsite['inhaltstext']); ?></div>
                        <br />
                        <br />
                        <?php if (empty($_SESSION['MM_Username'])) { echo ""; } else { ?>&raquo; <a href="index.php?s=edit&site=<?php echo $row_getsite['id']; ?>">Seite bearbeiten</a> (<a href="index.php?s=edit&amp;site=<?php echo $row_getsite['id']; ?>" target="_blank">Neues Fenster</a>)                      
                        <br />
                        <br />
                        <?php if (empty($row_getsite['zuletztbearbeitet'])) { echo ""; } else { ?>Zuletzt bearbeitet von <strong><?php echo $row_getsite['zuletztbearbeitetvon']; ?></strong> am <strong><?php echo $row_getsite['zuletztbearbeitet']; ?></strong>
                        <?php } ?>
                        <?php } ?></td>
                        <td width="2%" align="left" valign="top">&nbsp;</td>
                      </tr>
                  </table></td></tr>
                        </table>
              <?php } // Show if recordset not empty ?></td>
        </tr>
      </table></td>
  </tr>
</table>
<div id="admin" align="center"><?php if (empty($_SESSION['MM_Username'])) { ?><a href="index.php?s=<?Php echo $_GET['s'] ?>&messagebox=1">Admin</a><?php } else { ?>
    <a href="<?php echo $logoutAction ?>">Ausloggen</a>
    <?php } ?>
</div>
</body>
</html>
<?php
mysql_free_result($getsite);
?>