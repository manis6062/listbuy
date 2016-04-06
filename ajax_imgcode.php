<? require_once('config/config.php');	?>
<?
function makeRandomWord($size) {
		$salt = "ABCHEFGHJKMNPQRSTUVWXYZ0123456789abchefghjkmnpqrstuvwxyz";
		srand((double)microtime()*1000000);
		$word = '';
		$i = 0;
		while (strlen($word)<$size) {
			$num = rand() % 59;
			$tmp = substr($salt, $num, 1);
			$word = $word . $tmp;
			$i++;
		}
		return $word;
	}
	$checkCode = makeRandomWord(5);
	$random=rand().$_SESSION['checkCode'];
	
?>	<img src="image_code.php?txt=<?=$checkCode?>" align="absmiddle" /> <a href="javascript: void(0)" onclick="imgcode()"><img src="images/refresh.png" alt="Click To refresh the image" width="16" height="16" border="0" align="absmiddle" /></a>&nbsp;<input type="text" name="captcha_code" size="10" class="inputTextBox" onfocus="showdiv('captcha')" /><input type="hidden" id="capture_value" name="capture_value" value="<?=$checkCode?>"><span id="capt"></span>