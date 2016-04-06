<?php
	session_start();
	header("Content-type: image/jpeg");
	$string = $_REQUEST['txt'];
	$imageArr = array('image_code_blue.jpg', 'image_code_green.jpg', 'image_code_orange.jpg');
	$image = imagecreatefromjpeg("images/".$imageArr[rand()%3]);
	//$color = imagecolorallocate($image, 220, 210, 60);
	$color = imagecolorallocate($image, 255, 255, 255);
	ImageStringAlignAndWrap($image, 17, $string, $color, 105, "center");
	imagejpeg($image);
	imagedestroy($image);
	
	function ImageStringAlignAndWrap($image, $font, $text, $color, $maxwidth, $alignment){
		$fonFamily = array('./imagefont/verdana.ttf', './imagefont/trebucbi.ttf', './imagefont/trebuc.ttf', './imagefont/tahomabd.ttf', './imagefont/tahoma.ttf', './imagefont/cour.ttf', './imagefont/comicbd.ttf', './imagefont/comic.ttf', './imagefont/arialbd.ttf', './imagefont/arial.ttf');
		
		$fontwidth = imagefontwidth($font);
		$fontheight = imagefontheight($font);
		if ($maxwidth != NULL) {
			$maxcharsperline = floor($maxwidth / $fontwidth);
			$text = wordwrap($text, $maxcharsperline, "\n", 1);
		}
   
		$lines = explode("\n", $text);
		
		$y = 7;
		
		if ($alignment == "right") {
			while (list($numl, $line) = each($lines)) {
				imagestring($image, $font, imagesx($image) - $fontwidth*strlen($line), $y, $line, $color);
				$y += $fontheight;
			}
		}
		elseif ($alignment == "center") {
			while (list($numl, $line) = each($lines)) {
				//imagestring($image, $font, floor((imagesx($image) - $fontwidth*strlen($line))/2), $y, $line, $color);
				imagettftext ($image, $font, 0, 5, 19, $color, $fonFamily[(rand()%10)], $line);
				$y += $fontheight;
			}
		} else {
			while (list($numl, $line) = each($lines)) {
				imagestring($image, $font, 0, $y, $line, $color);
				$y += $fontheight;
			}
		}
	}

?> 