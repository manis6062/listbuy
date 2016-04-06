<script type="text/javascript">
	function doSearch()
	{
		document.frmSearch.action='search.php';
		document.frmSearch.submit()
	}
</script>
<div class="top_menu"> <a href="index.php">Home</a> <a href="how-itworks.php">how it works</a> <? if($_SESSION['user_id']==""){?><a href="registration.php">Register</a><? }?> <a href="asrch.php">browse</a> <a href="fees.php">fees</a> <? if($_SESSION['user_id']!=""){?><a href="my-account.php">MY ACCOUNT</a> <? } else {?> <a href="login.php">LOG IN</a><? }?> <a href="contact-us.php">Contact Us</a></div>
<form name="frmSearch" method="post" action="">
</form>