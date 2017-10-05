<?php
session_start();
$browsers = getenv("HTTP_USER_AGENT");
if (preg_match("/MSIE/i","$browsers"))
	$browser = '';
else
	$browser = 'Old';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">


<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="description" content="#" />
<meta name="keywords" content="#" />
<meta name="author" content="#" />

<title>Seismo-Surfer - A tool for collecting, querying and mining seismic data</title>

<link rel="stylesheet" type="text/css" href="styles/style.css"/>
<!--[if IE]><link href="styles/styleIE.css" rel="stylesheet" type="text/css"/><![endif]-->
<link rel="SHORTCUT ICON" href="img/surfer.ico"/>  

<Script language=JavaScript src="scripts/ajax.js"></Script>
<Script language=JavaScript src="scripts/update.js"></Script>
<Script language=JavaScript src="scripts/menu.js"></Script>
<Script language=JavaScript src="scripts/form.js"></Script>
<Script language=JavaScript src="scripts/print.js"></Script>
<Script language=JavaScript src="scripts/spinButton.js"></Script>
<Script language=JavaScript src="scripts/calendar.js"></Script>
<Script language=JavaScript src="scripts/utm.js"></Script>
<Script language=JavaScript src="scripts/mgrs.js"></Script>
<script type="text/javascript" src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAACnts4f39tAAU5dbilPydKhQiwB0frjzdj9x9Cub6KKk1BXnVcBSEjLJi1-U_gyRmgKBfYytcqsU3eg"></script>
<Script language=JavaScript src="scripts/dragzoom<?php echo $browser; ?>.js"></Script>
<Script language=JavaScript src="scripts/map.js"></Script>

</head>


<body id="theBody" onLoad="showLoader();loadRightLeftContent('contents/maps/map.php','contents/maps/mapMenu.php','Home',true);loadMap()" onunload="GUnload()">

<noscript>
<meta http-equiv="refresh" content="0;url=errors/noscript.htm" />
</noscript>

<div id="preloader">&nbsp;&nbsp;Loading Seismo Surfer...<br/><img src="img/loadingPage.gif" alt="Loading..." title="Loading..."/></div>

<div id="loader">
  <div id="boxForm"></div>
  <div id="dis"></div>
  <table align="center" border="0" cellpadding="0" cellspacing="0" width="950">
	<tr>
	  <td align="center"><!-- IE Fix
		<?php 
        require_once("contents/header.php");
        ?>
      </td>
    </tr>
    <tr>
      <td align="left" valign="top" id="content">
        <table align="center" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td align="center" valign="top"><!-- IE Fix
              <?php 
              require_once("contents/leftLogin.php");
              ?>
              <?php 
              require_once("contents/leftMenu.php");
              ?>
            </td>
            <td align="center" valign="top"><!-- IE Fix
              <?php 
              require_once("contents/rightContent.php");
              ?>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td align="center"><!-- IE Fix
        <?php 
        require_once("contents/footer.php");
        ?>
      </td>
    </tr>
  </table><br/>
</div>

</body>


</html>