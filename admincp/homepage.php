<?php
ob_start();
require_once('../config/config.php');
validation_check($_SESSION['logged'], 'index.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?=ADMIN_TITLE?></title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><? include_once('header.php'); ?></td>
      </tr>
	 
      <tr>
        <td class="bodyarea"></td>
      </tr>
	  <tr>
	  <td bgcolor="#fbfbfb"><table bgcolor="#fbfbfb" width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td valign="top"><!--<fieldset style="width:98%"><table width="100%" border="0" cellspacing="10" cellpadding="0">
           <tr>
              <td width="12%" align="center">
			  <a href="home.php?page=web-settings"><img src="images/globalconfiguration.png" alt="Website Settings"  border="0" width="48" height="48" /><br />
			  </a>
                Website Settings </td>
				<td width="12%" align="center">
			  <a href="home.php?page=category">
			  <img src="images/categorymanager.png" border="0" width="48" height="48" /><br />
			  </a>
                Theme Category Mgmt</td>
				<td width="12%" align="center">
			  <a href="home.php?page=static-cmslist">
			  <img src="images/sectionmanager.png" width="48" height="48" border="0" /><br />
			  </a>
                CMS Mgmt</td>
				<td width="12%" align="center">
			  <a href="home.php?page=news-list">
			  <img src="images/languagemanager.png"  border="0"/><br />
			  </a>
                News Mgmt</td>
              </tr>
          </table></fieldset>--></td>
        </tr>
      </table></td>
	  </tr>
        <tr>
        <td><? include_once('footer.php'); ?></td>
      </tr>
    </table>
	</td>
  </tr>
</table>
</body>
</html>
