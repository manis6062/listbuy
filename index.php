<?
error_reporting(0);
require_once('config/config.php');
$where = "AND status='1' AND featured='1'";
if (isset($_REQUEST['category']) && $_REQUEST['category'] != "") {
    $where = "";
    if ($_REQUEST['category'] == 'Featured') {
        $where .= " AND status='1' AND featured='1'";
    }
    if ($_REQUEST['category'] == 'All') {
        $where .= " AND status='1' ";
    }

    /*if($_REQUEST['category'] == 'Private')
    {
         $where.=" AND privatesale_auction='privatesale'";
    }*/
    if ($_REQUEST['category'] == 'Ending') {
        $where .= " AND status='1'  AND TIMESTAMPDIFF(DAY,NOW(),valid_till)<=5";
    }

    if ($_REQUEST['category'] == 'Sold') {
        $where = " AND status='2'";
    }

    if ($_REQUEST['category'] == 'BIN') {
        if ($_REQUEST['bin1'] != "") {
            $where .= " order by buyer_price DESC ,add_id DESC ";
        } else {
            $where .= " order by buyer_price ASC ,add_id DESC";
        }
    }
}
//echo $where;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?= TITLE ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta name="keywords" content=""/>
    <meta name="description" content=""/>
    <link href="css/fresh-auction.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript">
        function jsHitListAction(p1) {
            document.frm.action = "<?=$_SERVER['PHP_SELF']?>?<?=$_REQUEST['category'] != '' ? "category=" . $_REQUEST['category'] . "&" : ""?>PageNo=" + eval(p1);
            document.frm.submit()
        }
    </script>
</head>
<body>
<? include_once("toppage2.php"); ?>
<!--? include_once("header.php")?-->
<div id="container">
    <? include_once("left-menu.php"); ?>
    <div id="content">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td><img src="images/lbd_24.jpg" width="742" height="10"/></td>
            </tr>
            <tr>
                <td>

                    <div class="header_top">
                        <? include_once("cart-info.php"); ?>
                    </div>

                    <? include_once("recent-adds.php") ?>
                    <div class="listing">
                        <div class="listing_links" td align="right"><a href="<?= $_SERVER['PHP_SELF'] ?>?category=All">View
                                All Listings</a><a href="<?= $_SERVER['PHP_SELF'] ?>?category=Featured">Featured
                                Listings</a> <a href="<?= $_SERVER['PHP_SELF'] ?>?category=Sold">Recently Sold</a><a
                                href="<?= $_SERVER['PHP_SELF'] ?>?category=Ending">Ending Soon</a>
                            <? if ($_REQUEST['category'] == "BIN" && $_REQUEST['bin1'] == "") { ?><a
                                href="<?= $_SERVER['PHP_SELF'] ?>?category=BIN&bin1=desc">BIN</a>
                            <? } elseif ($_REQUEST['category'] == "BIN" && $_REQUEST['bin1'] == "desc") { ?> <a
                                href="<?= $_SERVER['PHP_SELF'] ?>?category=BIN">BIN</a>
                            <? } else { ?> <a href="<?= $_SERVER['PHP_SELF'] ?>?category=BIN">BIN</a> <? } ?>

                        </div>
                        <div class="list-holder">
                            <form name="frm" method="post" action="">
                                <table width="99%" border="0" cellspacing="0" cellpadding="03">
                                    <tr>
                                        <td width="50%">&nbsp;</td>
                                        <td width="14%">&nbsp;</td>
                                        <td width="13%">&nbsp;</td>
                                        <td width="11%">&nbsp;</td>

                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td align="right"><strong>Current Price</strong></td>
                                        <td align="center"><strong># of Bids</strong></td>
                                        <td align="center"><strong>Ends</strong></td>
                                        <td align="center"><strong>BIN</strong></td>

                                    </tr>
                                    <?
                                    $sql = "SELECT * FROM " . ADVERTISE . " WHERE 1 " . $where . " ";
                                    $PageSize = 15;
                                    $StartRow = 0;
                                    include_once('paging-top.php');
                                    if (mysql_num_rows($rs) > 0) {
                                        $bgColor = "#ffffff";
                                        for ($i = 0; $i < mysql_num_rows($rs); $i++) {
                                            $arradv = mysql_fetch_array($rs);
                                            $bidcou = Select_Qry("COUNT(id) as addID", PROPOSAL, "add_id='" . $arradv['add_id'] . "'", "", "", "", "");
                                            $pending = Select_Qry("COUNT(id) as PEND", PROPOSAL, "add_id='" . $arradv['add_id'] . "' AND accept='0'", "", "", "", "");
                                            $reject = Select_Qry("COUNT(id) as REJ", PROPOSAL, "add_id='" . $arradv['add_id'] . "' AND accept='1'", "", "", "", "");
                                            ?>
                                            <? if ((CATEGORY_ADD($arradv['cat_id']) == '1') && ($arradv['site_img'] == '')) { ?>
                                                <tr <? if ($arradv['highlight'] == '1') { ?> bgcolor="#FBFEE7"<? } ?>>
                                                    <td <? if ($arradv['rowborder'] == 1){ ?>style="border-left:1px solid #024D86;border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? } ?>>
                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                                <td align="left"
                                                                    width="10"><? if ($arradv['featured'] == '1') { ?>
                                                                        <img src="images/fd.png" border="0"
                                                                             alt="Featured"
                                                                             title="Featured"/><? } else { ?><img
                                                                        src="images/spacer.gif" border="0" height="32"
                                                                        width="32"/><? } ?></td>
                                                                <td align="left" valign="top" style="padding-left:5px;">
                                                                    Category: <?= CATEGORY($arradv['cat_id']) ?><br/>
                                                                    <a href="http://<?= substr(strip_tags($arradv['title']), 0, 40) ?>"
                                                                       <? if ($arradv['bold'] == 1){ ?>class="bold"<? } ?>><?= substr(strip_tags($arradv['title']), 0, 40) ?></a>
                                                                   <a href="details.php?add_id=<?=$arradv['add_id']?>" <? if($arradv['bold']==1){?>class="bold"<? }?>><?=$arradv['title']?></a>
                                                                    <span
                                                                        class="error"> <?= $arradv['status'] == 2 ? '[Sold]' : '' ?></span>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td align="center"
                                                        <? if ($arradv['rowborder'] == 1){ ?>style="border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? } ?>><?php /*?><?=$arradv['price']?><?php */ ?></td>
                                                    <td align="right"
                                                        <? if ($arradv['rowborder'] == 1){ ?>style="border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? } ?>>
                                                        &nbsp;</td>
                                                    <td align="center"
                                                        <? if ($arradv['rowborder'] == 1){ ?>style="border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? } ?>><?= $arradv['status'] == 2 ? 'Ended' : enddate($arradv['valid_till']) ?></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" style="height:5px;"></td>
                                                </tr>
                                            <? } else { ?>
                                                <tr <? if ($arradv['highlight'] == '1') { ?> bgcolor="#FBFEE7"<? } ?>>
                                                    <td <? if ($arradv['rowborder'] == 1){ ?>style="border-left:1px solid #024D86;border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? } ?>>
                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                                <td align="left"
                                                                    width="32"><? if ($arradv['featured'] == '1') { ?>
                                                                        <img src="images/fd.png" border="0"
                                                                             alt="Featured"
                                                                             title="Featured"/><? } else { ?><img
                                                                        src="images/spacer.gif" border="0" height="32"
                                                                        width="32"/><? } ?></td>
                                                                <td width="56"><a
                                                                        href="http://<?= substr(strip_tags($arradv['title']), 0, 40) ?>">
                                                                        
                                                                        
                                                                                   <?php
                                                                if(!empty($arradv['site_img'])){ ?>
                                                                 <img
                                                                            src="websiteImage/thumb<?= $arradv['site_img'] ?>"
                                                                            border="0" class="img_border"/>
                                                                <?php } 
                                                                else { ?>
                                                                
                                                              
                                                                       
                                                                           <img
                                                                            src="../images/logo/default_addimg.jpg"
                                                                            border="0" class="img_border"/> 
                                                                            <?php } ?>  
                                                                            
                                                                            
                                                                            
                                                                            </a></td>
                                                                <td width="415" valign="top" style="padding-left:5px;"
                                                                    align="left">
                                                                    Category: <?= CATEGORY($arradv['cat_id']) ?><br/>
                                                                     <a href="details.php?add_id=<?=$arradv['add_id']?>" <? if($arradv['bold']==1){?>class="bold"<? }?>><?=$arradv['title']?></a>
                                                                </td>


                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td align="center"
                                                        <? if ($arradv['rowborder'] == 1){ ?>style="border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? } ?>>
                                                        <? if ($arradv['status'] == 2) {
                                                            $acbin = Select_Qry("bin_amt, COUNT(id) as ACCBIN", BIN, "accept >'1' AND add_id ='" . $arradv['add_id'] . "'", "", "", "", "");
                                                            if ($acbin['ACCBIN'] > 0) {
                                                                $price = $acbin['bin_amt'];
                                                            } else {
                                                                $price = $arradv['price'];
                                                            }
                                                        } else {
                                                            $price = $arradv['price'];
                                                        }
                                                        ?>
                                                        <?= $price ?></td>
                                                    <td align="center"
                                                        <? if ($arradv['rowborder'] == 1){ ?>style="border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? } ?>>
                                                        <?
                                                        if ($arradv['status'] != "2") {
                                                            ?><?= $bidcou['addID'] ?><br/>
                                                            <?
                                                        } else {
                                                            ?>
                                                            <span style="color:#FF0033">Sold</span><? } ?></td>
                                                    <td align="center"
                                                        <? if ($arradv['rowborder'] == 1){ ?>style="border-top:1px solid #024D86;border-bottom:1px solid #024D86;"<? } ?>><?= $arradv['status'] == 2 ? 'Ended' : enddate($arradv['valid_till'])
                                                        ?>
                                                    </td>
                                                    <td align="center"><? echo $arradv['buyer_price']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" style="height:5px;"></td>
                                                </tr>
                                            <? } ?>
                                            <?
                                        }
                                        ?>
                                        <tr>
                                            <td colspan="4" align="right"
                                                valign="top"><? include_once('pageno.php'); ?></td>
                                        </tr>
                                        <?
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="4" align="center"
                                                valign="top"><?= errormessage("Currently, there are no active listings in this category") ?></td>
                                        </tr>
                                        <?
                                    }
                                    ?>
                                    <!--<tr>
                                      <td class="td_bg"> animal prints to all over sequins, tran</td>
                                      <td align="right" class="td_bg">$2300</td>
                                      <td align="right" class="td_bg">12days</td>
                                      <td align="right" class="td_bg">Yestyerday</td>
                                    </tr>
                                    <tr>
                                      <td class="td_bg">From animal prints to all over sequins</td>
                                      <td align="right" class="td_bg">$500</td>
                                      <td align="right" class="td_bg">9days</td>
                                      <td align="right" class="td_bg">Today</td>
                                    </tr>
                                    <tr>
                                      <td class="td_bg"> animal prints to all over sequins, tran</td>
                                      <td align="right" class="td_bg">$2300</td>
                                      <td align="right" class="td_bg">12days</td>
                                      <td align="right" class="td_bg">Yestyerday</td>
                                    </tr>
                                    <tr>
                                      <td class="td_bg">From animal prints to all over sequins</td>
                                      <td align="right" class="td_bg">$500</td>
                                      <td align="right" class="td_bg">9days</td>
                                      <td align="right" class="td_bg">Today</td>
                                    </tr>
                                    <tr>
                                      <td class="td_bg"> animal prints to all over sequins, tran</td>
                                      <td align="right" class="td_bg">$2300</td>
                                      <td align="right" class="td_bg">12days</td>
                                      <td align="right" class="td_bg">Yestyerday</td>
                                    </tr>
                                    <tr>
                                      <td class="td_bg">From animal prints to all over sequins</td>
                                      <td align="right" class="td_bg">$500</td>
                                      <td align="right" class="td_bg">9days</td>
                                      <td align="right" class="td_bg">Today</td>
                                    </tr>
                                    <tr>
                                      <td class="td_bg"> animal prints to all over sequins, tran</td>
                                      <td align="right" class="td_bg">$2300</td>
                                      <td align="right" class="td_bg">12days</td>
                                      <td align="right" class="td_bg">Yestyerday</td>
                                    </tr>
                                    <tr>
                                      <td class="td_bg">From animal prints to all over sequins</td>
                                      <td align="right" class="td_bg">$500</td>
                                      <td align="right" class="td_bg">9days</td>
                                      <td align="right" class="td_bg">Today</td>
                                    </tr>
                                    <tr>
                                      <td class="td_bg"> animal prints to all over sequins, tran</td>
                                      <td align="right" class="td_bg">$2300</td>
                                      <td align="right" class="td_bg">12days</td>
                                      <td align="right" class="td_bg">Yestyerday</td>
                                    </tr>-->
                                </table>
                            </form>
                        </div>
                        <!--<div class="list-holder"><img src="images/fresh-auction_41.jpg" width="169" height="32" /></div>-->
                    </div>
                </td>
            </tr>
            <tr>
                <td><img src="images/lbd_24a.jpg" width="742" height="10"/></td>
            </tr>
        </table>
    </div>
</div>
<? require_once("upper-footer.php"); ?>
<? require_once("footer.php"); ?>


</body>
</html>
