<link rel="stylesheet" type="text/css" href="css/ddlevelsmenu-base.css" />
<link rel="stylesheet" type="text/css" href="css/ddlevelsmenu-topbar.css" />
<link rel="stylesheet" type="text/css" href="css/ddlevelsmenu-sidebar.css" />
<link href="../css/internet_market.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/ddlevelsmenu.js">
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td height="30" colspan="2">&nbsp;</td>
			  </tr>
			  <tr>
				<td><img src="images/logoadmin.jpg" alt="" /></td>
				<td align="right" valign="bottom" class="footer_band">ADMIN CONTROL PANEL</td>
			  </tr>
</table></td>
  </tr>
  <tr>
  <td>
  <? if($_SESSION['logged']!=''){ ?>
  <div id="ddtopmenubar" class="mattblackmenu">
<ul>
<li><a href="home.php">Home</a></li>
<li><a href="#" rel="ddsubmenu1">Admin</a></li>
<li><a href="#" rel="ddsubmenu2">Settings</a></li>
<li><a href="#" rel="ddsubmenu3">User Mgmt</a></li>
<li><a href="#" rel="ddsubmenu4">Site Mgmt</a></li>
<li><a href="home.php?page=static-cmslist" rel="ddsubmenu5">CMS Mgmt</a></li>
<li><a href="#" rel="ddsubmenu6">Report Mgmt</a></li>
<li><a href="dbbckup.php" rel="ddsubmenu">database backup</a></li>
<!--<li><a href="home.php?page=news-list" rel="ddsubmenu6">News Mgmt</a></li>-->
<!--<li><a href="home.php?page=feedback-list" rel="ddsubmenu7">Feedback Mgmt</a></li>-->
<!--<li><a href="#" rel="ddsubmenu7">Sales Mgmt</a></li>
<li><a href="#" rel="ddsubmenu8">Sales Reports</a></li>-->
</ul>
</div>
<? }?>

<script type="text/javascript">
ddlevelsmenu.setup("ddtopmenubar", "topbar") //ddlevelsmenu.setup("mainmenuid", "topbar|sidebar")
</script>


<ul id="ddsubmenu1" class="ddsubmenustyle">
<li><a href="home.php?page=change-password">Change Password</a></li>
<li><a href="logout.php">Logout</a></li>
</ul>

<!--Top Drop Down Menu 2 HTML-->

<ul id="ddsubmenu2" class="ddsubmenustyle">
<li><a href="home.php?page=web-settings">Site Configuration</a></li>
<li><a href="home.php?page=email-setting">Email Setting</a></li>
<li><a href="home.php?page=account-setting">Account Setting</a></li>
</ul>

<ul id="ddsubmenu3" class="ddsubmenustyle">
<li><a href="home.php?page=user-list">User List</a></li>
<li><a href="home.php?page=newsletter-user">Newsletter User List</a></li>
</ul>

<ul id="ddsubmenu4" class="ddsubmenustyle">
<li><a href="home.php?page=category-list">Category List</a></li>
<li><a href="home.php?page=sitestatus">Site Status List</a></li>
<li><a href="home.php?page=auction-list">Auction List</a></li>
<li><a href="home.php?page=cancel-list">Cancelled Auction List</a></li>
<li><a href="home.php?page=all-proposal">Bidding History</a></li>
<li><a href="home.php?page=bin-history">BIN History</a></li>
</ul>

<ul id="ddsubmenu5" class="ddsubmenustyle">
<!--<li><a href="home.php?page=cms-list">CMS Management</a></li>-->
<li><a href="home.php?page=static-cmslist">StaticCMS Management</a></li>
<li><a href="home.php?page=all-newsletter">Newsletter List</a></li>
<li><a href="home.php?page=update-logo">Update Logo</a></li>
</ul>

<ul id="ddsubmenu6" class="ddsubmenustyle">
<li><a href="home.php?page=report-list">Report List</a></li>
</ul>

<!--<ul id="ddsubmenu6" class="ddsubmenustyle">
<li><a href="home.php?page=news-list">News Management</a></li>
</ul>-->

<!--<ul id="ddsubmenu7" class="ddsubmenustyle">
<li><a href="home.php?page=feedback-list">Feedback Management</a></li>
</ul>-->

<ul id="ddsubmenu7" class="ddsubmenustyle">
<li><a href="home.php?page=buy-list">Sales List</a></li>
<li><a href="home.php?page=order-list">Order List</a></li>
</ul>

<ul id="ddsubmenu8" class="ddsubmenustyle">
<li><a href="home.php?page=sales-report">Sales Report</a></li>
</ul>

<!--Top Drop Down Menu 3 HTML-->


  </td>
  </tr>
 </table>
