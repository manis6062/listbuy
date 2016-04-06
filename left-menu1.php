<?
if(isset($_REQUEST['val1'])!="")
		{
			
		}
	if(isset($_REQUEST['val'])!="")
		{
	//getinsert($_REQUEST['email_signup'],'');
	$newslchk=Select_Qry("*",USERNEWSLETTER,"email='".$_REQUEST['email_signup']."'","","","","");
	if($newslchk=="")
	{
	Insert_Qry(USERNEWSLETTER,"email='".$_REQUEST['email_signup']."'");
	$msgN=("<span style='font-size:9px; color:#004080;'>Successfully registered!</span>");
	}
	else
	{
	$msgN=("<span style='font-size:9px; color:#AA0000;'>Email address already exists!</span>");
	}
}

$total_message=Select_Qry("COUNT(id) as prim",INBOX,"unread='0' AND recipent_id='".$_SESSION['user_id']."'","","","","");
##################  PENDING BIN OFFERS ###########################
$ads=Listing_Qry("add_id",ADVERTISE,"WHERE user_id='".$_SESSION['user_id']."' AND status='1' order by add_id ","");
	if($ads){
		$k=1;
		$ad_id="";
		foreach($ads as $recs){
			$ad_id.="'".$recs['add_id']."'";
			if($k < sizeof($ads)){
				$ad_id.=",";
			}
		$k++;
		}
		#echo $ad_id;
	$total_bin=Select_Qry("COUNT(id) as PBIN",BIN,"accept='0' AND add_id IN (".$ad_id.")","","","","");
	}
#################################################################

##################  ACCEPTED BIN OFFERS ###########################
	$acc_bin=Select_Qry("COUNT(id) as ABIN",BIN,"accept='2' AND user_id ='".$_SESSION['user_id']."'","","","","");
#################################################################

?>

<script type="text/javascript" src="js/validate_email.js"></script>
<script type="text/javascript">
	function quickLogin(val)
	{
		if(document.frmemail.email_signup.value=="")
		{
			alert("Please Provide Your Email");
			document.frmemail.email_signup.focus();
			return false;
		}
		else if(!emailCheck(document.frmemail.email_signup))
		{
			document.frmemail.email_signup.focus();
			return false;
		}
		
		else
		{
		document.frmemail.action="<?=$_SERVER['PHP_SELF']?>?val="+val;
		document.frmemail.submit();
		}
	}
	
	function quick(val)
	{
		if(document.fsrch.srch.value=="")
		{
			alert("Please Enter");
			document.fsrch.srch.focus();
			return false;
		}
		else
		{
		val=document.fsrch.srch.value;
		document.fsrch.action="<?=$_SERVER['PHP_SELF']?>?val1="+val;
		document.fsrch.submit();
		}
	}

</script>

<div id="sidebar">
  
  

<table width="216" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><img src="images/lbd_22.jpg" width="216" height="13" alt="" /></td>
  </tr
  ><tr>
    <td class="left_menu_bg">
    
  <form action="" method="post">
<table border="0" cellpadding="0" cellspacing="0" width="190" align="left">
													<tr>
														<td colspan="3">
															<table border="0" cellpadding="0" cellspacing="0">
															<!-- searchfield-->
															<tr>
																<td><b>Keyword</b></td>
																<td>&nbsp;</td>
																<td><b>Extension</b></td>
															</tr>
															<!-- tld -->
															<tr>
																<td><input class="form_textfeld" name="searchfield" type="text"
																	value="" size="12" maxlength="60"></td>
																<td>&nbsp;<b>.</b>&nbsp;</td>
																<td><select name="cc" style="width: 70px;" class="auswahl_2" size="1">
																	<option value="">All</option>
 <optgroup label="common">
<option value="uk">.uk</option>
 <option value="com">.com</option>
 <option value="net">.net</option>
 <option value="org">.org</option>
 <option value="eu">.eu</option>
 <option value="info">.info</option>
 <option value="biz">.biz</option>
 <option value="name">.name</option>
 </optgroup>
																	<optgroup label="other">
																		<option value="ac">.ac</option>
 <option value="ad">.ad</option>
 <option value="ae">.ae</option>
 <option value="af">.af</option>
 <option value="ag">.ag</option>
 <option value="ai">.ai</option>
 <option value="al">.al</option>
 <option value="am">.am</option>
 <option value="an">.an</option>
 <option value="ao">.ao</option>
 <option value="aq">.aq</option>
 <option value="ar">.ar</option>
 <option value="as">.as</option>
 <option value="at">.at</option>
 <option value="au">.au</option>
 <option value="aw">.aw</option>
 <option value="az">.az</option>
 <option value="ba">.ba</option>
 <option value="ba">.ba</option>
 <option value="bb">.bb</option>
 <option value="bd">.bd</option>
 <option value="be">.be</option>
 <option value="bf">.bf</option>
 <option value="bg">.bg</option>
 <option value="bh">.bh</option>
 <option value="bi">.bi</option>
 <option value="bj">.bj</option>
 <option value="bm">.bm</option>
 <option value="bn">.bn</option>
 <option value="bo">.bo</option>
 <option value="br">.br</option>
 <option value="bs">.bs</option>
 <option value="bt">.bt</option>
 <option value="bv">.bv</option>
 <option value="bw">.bw</option>
 <option value="by">.by</option>
 <option value="bz">.bz</option>
 <option value="ca">.ca</option>
 <option value="cat">.cat</option>
 <option value="cc">.cc</option>
 <option value="cd">.cd</option>
 <option value="cf">.cf</option>
 <option value="cg">.cg</option>
 <option value="ch">.ch</option>
 <option value="ci">.ci</option>
 <option value="ck">.ck</option>
 <option value="cl">.cl</option>
 <option value="cm">.cm</option>
 <option value="cn">.cn</option>
 <option value="co">.co</option>
 <option value="cr">.cr</option>
 <option value="cu">.cu</option>
 <option value="cv">.cv</option>
 <option value="cx">.cx</option>
 <option value="cy">.cy</option>
 <option value="cz">.cz</option>
 <option value="de">.de</option>
 <option value="dj">.dj</option>
 <option value="dk">.dk</option>
 <option value="dm">.dm</option>
 <option value="do">.do</option>
 <option value="dz">.dz</option>
 <option value="ec">.ec</option>
 <option value="ee">.ee</option>
 <option value="eg">.eg</option>
 <option value="eh">.eh</option>
 <option value="er">.er</option>
 <option value="es">.es</option>
 <option value="et">.et</option>
 <option value="fi">.fi</option>
 <option value="fj">.fj</option>
 <option value="fk">.fk</option>
 <option value="fm">.fm</option>
 <option value="fo">.fo</option>
 <option value="fr">.fr</option>
 <option value="fx">.fx</option>
 <option value="ga">.ga</option>
 <option value="gd">.gd</option>
 <option value="ge">.ge</option>
 <option value="gf">.gf</option>
 <option value="gg">.gg</option>
 <option value="gh">.gh</option>
 <option value="gi">.gi</option>
 <option value="gl">.gl</option>
 <option value="gm">.gm</option>
 <option value="gn">.gn</option>
 <option value="gp">.gp</option>
 <option value="gq">.gq</option>
 <option value="gr">.gr</option>
 <option value="gs">.gs</option>
 <option value="gt">.gt</option>
 <option value="gu">.gu</option>
 <option value="gw">.gw</option>
 <option value="gy">.gy</option>
 <option value="hk">.hk</option>
 <option value="hm">.hm</option>
 <option value="hn">.hn</option>
 <option value="hr">.hr</option>
 <option value="ht">.ht</option>
 <option value="hu">.hu</option>
 <option value="id">.id</option>
 <option value="ie">.ie</option>
 <option value="il">.il</option>
 <option value="im">.im</option>
 <option value="in">.in</option>
 <option value="io">.io</option>
 <option value="iq">.iq</option>
 <option value="ir">.ir</option>
 <option value="is">.is</option>
 <option value="it">.it</option>
 <option value="je">.je</option>
 <option value="jm">.jm</option>
 <option value="jo">.jo</option>
 <option value="jp">.jp</option>
 <option value="ke">.ke</option>
 <option value="kg">.kg</option>
 <option value="kh">.kh</option>
 <option value="ki">.ki</option>
 <option value="km">.km</option>
 <option value="kn">.kn</option>
 <option value="kp">.kp</option>
 <option value="kr">.kr</option>
 <option value="kw">.kw</option>
 <option value="ky">.ky</option>
 <option value="kz">.kz</option>
 <option value="la">.la</option>
 <option value="lb">.lb</option>
 <option value="lc">.lc</option>
 <option value="li">.li</option>
 <option value="lk">.lk</option>
 <option value="lr">.lr</option>
 <option value="ls">.ls</option>
 <option value="lt">.lt</option>
 <option value="lu">.lu</option>
 <option value="lv">.lv</option>
 <option value="ly">.ly</option>
 <option value="ma">.ma</option>
 <option value="mc">.mc</option>
 <option value="md">.md</option>
 <option value="me">.me</option>
 <option value="mg">.mg</option>
 <option value="mh">.mh</option>
 <option value="mk">.mk</option>
 <option value="ml">.ml</option>
 <option value="mm">.mm</option>
 <option value="mn">.mn</option>
 <option value="mo">.mo</option>
 <option value="mobi">.mobi</option>
 <option value="mp">.mp</option>
 <option value="mq">.mq</option>
 <option value="mr">.mr</option>
 <option value="ms">.ms</option>
 <option value="mt">.mt</option>
 <option value="mu">.mu</option>
 <option value="mv">.mv</option>
 <option value="mw">.mw</option>
 <option value="mx">.mx</option>
 <option value="my">.my</option>
 <option value="mz">.mz</option>
 <option value="na">.na</option>
 <option value="nc">.nc</option>
 <option value="ne">.ne</option>
 <option value="nf">.nf</option>
 <option value="ng">.ng</option>
 <option value="ni">.ni</option>
 <option value="nl">.nl</option>
 <option value="no">.no</option>
 <option value="np">.np</option>
 <option value="nr">.nr</option>
 <option value="nu">.nu</option>
 <option value="nz">.nz</option>
 <option value="om">.om</option>
 <option value="pa">.pa</option>
 <option value="pe">.pe</option>
 <option value="pf">.pf</option>
 <option value="pg">.pg</option>
 <option value="ph">.ph</option>
 <option value="pk">.pk</option>
 <option value="pl">.pl</option>
 <option value="pm">.pm</option>
 <option value="pn">.pn</option>
 <option value="pr">.pr</option>
 <option value="pro">.pro</option>
 <option value="ps">.ps</option>
 <option value="pt">.pt</option>
 <option value="pw">.pw</option>
 <option value="py">.py</option>
 <option value="qa">.qa</option>
 <option value="re">.re</option>
 <option value="ro">.ro</option>
 <option value="rs">.rs</option>
 <option value="ru">.ru</option>
 <option value="rw">.rw</option>
 <option value="sa">.sa</option>
 <option value="sb">.sb</option>
 <option value="sc">.sc</option>
 <option value="sd">.sd</option>
 <option value="se">.se</option>
 <option value="sg">.sg</option>
 <option value="sh">.sh</option>
 <option value="si">.si</option>
 <option value="sj">.sj</option>
 <option value="sk">.sk</option>
 <option value="sl">.sl</option>
 <option value="sm">.sm</option>
 <option value="sn">.sn</option>
 <option value="so">.so</option>
 <option value="sr">.sr</option>
 <option value="st">.st</option>
 <option value="sv">.sv</option>
 <option value="sy">.sy</option>
 <option value="sz">.sz</option>
 <option value="tc">.tc</option>
 <option value="td">.td</option>
 <option value="tf">.tf</option>
 <option value="tg">.tg</option>
 <option value="th">.th</option>
 <option value="tj">.tj</option>
 <option value="tk">.tk</option>
 <option value="tl">.tl</option>
 <option value="tm">.tm</option>
 <option value="tn">.tn</option>
 <option value="to">.to</option>
 <option value="tp">.tp</option>
 <option value="tr">.tr</option>
 <option value="travel">.travel</option>
 <option value="tt">.tt</option>
 <option value="tv">.tv</option>
 <option value="tw">.tw</option>
 <option value="tz">.tz</option>
 <option value="ua">.ua</option>
 <option value="ug">.ug</option>
 <option value="um">.um</option>
 <option value="us">.us</option>
 <option value="uy">.uy</option>
 <option value="uz">.uz</option>
 <option value="va">.va</option>
 <option value="vc">.vc</option>
 <option value="ve">.ve</option>
 <option value="vg">.vg</option>
 <option value="vi">.vi</option>
 <option value="vn">.vn</option>
 <option value="vu">.vu</option>
 <option value="wf">.wf</option>
 <option value="ws">.ws</option>
 <option value="xyz">.xyz</option>
 <option value="ye">.ye</option>
 <option value="yt">.yt</option>
 <option value="yu">.yu</option>
 <option value="za">.za</option>
 <option value="zm">.zm</option>
 <option value="zr">.zr</option>
 <option value="zw">.zw</option>
 </optgroup>
																</select></td>
															</tr>
															<tr>
																<td colspan="3"><img src="http://icloudcenter.net/demos/icdomains//img/0.gif" width="1" height="6" alt="" border="0"></td>
															</tr>
                                                          
															<!-- keyword position -->
															<tr >
																<td colspan="3" style="height:auto; padding-bottom:10px;">
																	<input type="Radio" value="0" name="kws">begins 																									       						<input type="Radio" value="1" name="kws" checked>contains					       						
										       						<input type="Radio" value="2" name="kws">ends                                                                </td>
															</tr>
														</table>
														</td>
													</tr>
													<!-- category -->
													<tr >
														<td  valign="top" style="height:auto; padding-bottom:10px;"><b>Category</b></td>
														<td style="height:auto; padding-bottom:10px;">&nbsp;</td>
														<td style="height:auto; padding-bottom:10px;">
                    <select name="cat" class="auswahl_2" style="width: 120px;" size=4>
															<!-- multiple -- for the new search -->
<option value='' selected>All</option>
	  <?
	  	$catList=Listing_Qry("*",CATEGORY,"WHERE status='1' ORDER BY cat_id DESC","");
		if($catList!="")
		{
			foreach($catList as $cat)
			{
	  ?>
	  <option value="<?=$cat['cat_id']?>"><?=$cat['cat_name']?></option>
	  <?
	  		}
		}
	  ?>
	  </select>
</td>
													</tr>
													<!-- price -->
													<tr >
														<td style="height:auto; padding-bottom:10px;"><b>Price</b></td>
														<td>&nbsp;</td>
		<td style="height:auto; padding-bottom:10px;"><select name="price" style="width: 120px;" class="auswahl_2">
<option value='' selected>All</option>
 <option value='1'>1 - 300</option>
 <option value='2'>300 - 1.000</option>
 <option value='3'>1.000 - 10.000</option>
 <option value='4'>10.000 - 100.000</option>
 <option value='5'>> 100.000</option>
 </select></td>
													</tr>
													<!-- Listing Type -->
												<!--	<tr bgcolor="#E8ECF5">
														<td><b>Listing Type</b></td>
														<td>&nbsp;</td>
														<td><select name="listing_type" style="width: 120px;" class="auswahl_2">
															<option value="all">All</option>
 <option value="auctions_only">Auctions only</option>
 <option value="offer_only">Offer/Counter Offer only</option>
 </select></td>
													</tr>
													<!-- insertion date (aka age) -->
<tr >
<td style="height:auto; padding-bottom:10px;"><b>Date added</b></td>
<td>&nbsp;</td>
<td style="height:auto; padding-bottom:10px;"><select name="age" style="width: 120px;" class="auswahl_2">
<option value=''selected>All</option>
<option value='1'>last 2 days</option>
<option value='2'>last week</option>
<option value='3'>last month</option>
<option value='4'>last 3 months</option>
</select></td>
</tr> 
													<!-- length -->
<tr>
<td style="height:auto; padding-bottom:10px;"><b>Length</b></td>
<td>&nbsp;</td>
<td style="height:auto; padding-bottom:10px;"><select name="len" style="width: 120px;" class="auswahl_2">
<option value='' selected>All</option>
<option value='3'>3 characters</option>
<option value='4'>4 characters</option>
<option value='5'>5 characters</option>
<option value='6'>6 characters</option>
<option value='7'>>6 characters</option>
</select></td>
</tr>
													<!-- exclude hypehns and numerals -->
													<tr >
														<td valign="top"><b>Exclude</b></td>
														<td>&nbsp;</td>
														<td><input type="Checkbox" name="no_hyphen" value="1">Hyphens<br>
														<input type="Checkbox" name="no_numeral" value="2">Numerals<br>
														</td>
													</tr>
													<!-- domain /website checkboxes -->
													<tr >
														<td valign="top"><b>Search</b></td>
														<td>&nbsp;</td>
														<td><input type="Checkbox" name="checkeddomains" value="1" checked>Domains<br>
														<input type="Checkbox" name="checkedprojects" value="1" checked
															onclick="document.frm_advanced_search.elements.visitors.disabled=!(document.frm_advanced_search.elements.visitors.disabled)">Websites
														</td>
													</tr>
													<!-- visitors - enabled only for projects -->
													<tr >
														<td valign="top" ><b>Visitors</b><br>
														<span style="color: #810436; font-size: 10px;">per month</span></td>
														<td>&nbsp;</td>
											<td><select name="visitors" style="width: 120px;" class="auswahl_2" enabled
															onchange="document.frm_advanced_search.elements.checkeddomains.checked = (document.frm_advanced_search.elements.visitors.selectedIndex == 0 ? true:false) ">
<option value='' selected>All</option>
 <option value='1'>1 - 1.000</option>
 <option value='2'>1.000 - 10.000</option>
 <option value='3'>10.000 - 100.000</option>
 <option value='4'>>100.000</option>
 </select></td>
													</tr>
													<!-- sort by -->
<tr>
<td  style="height:auto; padding-bottom:10px;"><b>Sort by</b></td>
<td>&nbsp;</td>
<td  style="height:auto; padding-bottom:10px;"><select name="rel" style="width: 120px;" class="auswahl_2">
<option value="" selected>Quality</option>
<option value="2">Alphabetical</option>
<option value="3">Price</option>
<option value="4">Bid</option>
<option value="5">Traffic</option>
</select></td>
</tr>
													<!-- page size -->
													<tr>
														<td  valign="top" ><b>Display</b></td>
														<td>&nbsp;</td>
									<td style="height:auto; padding-bottom:10px;"><select name="pagesize" style="width: 120px;" class="auswahl_2">
															<option value="30" selected>30</option>
 <option value="60">60</option>
 <option value="100">100</option>
 </select> <span style="color: #810436; font-size: 10px;">results per page</span>
														</td>
													</tr>
                                    
													<!-- language of search -->
								<!--					<tr bgcolor="#F7F8FB">
														<td><b>Language</b></td>
														<td>&nbsp;</td>
														<td><select name="search_language" style="width: 120px;" class="auswahl_2">
															<option value=en selected>English</option>
 <option value=de>German</option>
 <option value=fr>French</option>
 <option value=es>Spanish</option>
 </select></td>
													</tr>
								-->					<!-- submit button -->
                            
													<tr>
														<td colspan="3" align="center" style="border-bottom: 1px solid #012266;">
             
         <input type="submit" name="submit" value="Search" style="background:#009; color:#FFF; margin-bottom:10px;">
         </td>
													</tr>
												</table>
												</form>
                                 
                        
</td>
<td width="50%">
</td>
<td>

<table>
<?
while($te=mysql_fetch_array($qu1))
{
	?>
    <tr>
    <td>
    
	<a  onclick="window.open(this.href); return false;" href="<? echo $te['domain']; ?> "><? echo $te['domain']; ?></a>
    </td>
    </tr>
    <?
}
?>
</table>

  
  
</td>
  </tr>
  <tr>
    <td><img src="images/lbd_30.jpg" width="216" height="13" alt="" /></td>
  </tr>
  <tr>
    <td><img src="images/lbd_22.jpg" width="216" height="13" alt="" /></td>
  </tr>
  <!--
   <tr>
    <td class="left_menu_bg">
	<form name="frmemail" method="post" action="">
		  <h2>Newsletter Signup<br />
		    <br />
		    <?php echo $msgN?>
		    <input name="email_signup" type="text" class="search_box" id="email_signup" size="20" /><img src="images/news1.png" width="32" height="32" align="absbottom" border="0" onclick="return quickLogin(this.value)"  /></h2>
	</form>
    
    
    </td>  </tr> -->

</table>	

  <!--div class="sidebar_sep"></div-->
  <table width="216" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><img src="images/lbd_22.jpg" width="216" height="13" alt="" /></td>
  </tr>

  <tr>
    <td><img src="images/lbd_30.jpg" width="216" height="13" alt="" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>	


    <!--div class="sidebar_sep"></div-->
    
    
      <table width="216" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><img src="images/lbd_22.jpg" width="216" height="13" alt="" /></td>
  </tr>
  <tr>
    <td class="left_menu_bg">
    
    
<?=statica_cms_page_value(19)?>

</td>
  </tr>
  <tr>
    <td><img src="images/lbd_30.jpg" width="216" height="13" alt="" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>	


</div>