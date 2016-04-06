<? require_once('../config/config.php');	?>
<?
	if($_REQUEST['m']=="accept")
	{
	$objprop=Select_Qry("*",PROPOSAL,"id='".$_REQUEST['p']."'","","","","");
	$objuser=Select_Qry("*",USER,"user_id='".$objprop['user_id']."'","","","","");
?>
<fieldset  style="width:98%;">
<legend class="content_title2">Proposal Details </legend>
<table cellpadding="5" cellspacing="0" width="100%">
<tr><td align="left" valign="top">
<table cellpadding="3" cellspacing="0" width="100%">
<tr><td width="25%" align="left" valign="top" class="label">Title</td><td width="25%" align="left" valign="top"><?=ADDTITLE($objprop['add_id'])?></td>
  <td width="25%" align="left" valign="top" class="label">Proposed Amount</td>
  <td width="25%" align="left" valign="top" class="price"><?=$objprop['proposed_amt']?>$</td>
</tr>
</table>
</td></tr>
<tr><td align="left" valign="top" class="content_title2">User Details : </td></tr>
<tr>
  <td align="left" valign="top">
  <table cellpadding="3" cellspacing="0" width="100%">
  <tr><td width="25%" align="left" valign="top" class="label">Name</td><td width="25%" align="left" valign="top"><?=$objuser['first_name'].' '.$objuser['last_name']?></td>
    <td width="25%" align="left" valign="top" class="label">Username</td>
    <td width="25%" align="left" valign="top"><?=$objuser['username']?></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="label">&nbsp;</td>
    <td colspan="3" align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="top" class="label">&nbsp;</td>
    <td colspan="3" align="left" valign="top"><input type="radio" checked="checked" />&nbsp;Confirm your acceptance</td>
  </tr>
  <tr>
    <td align="left" valign="top" class="label">&nbsp;</td>
    <td colspan="3" align="left" valign="top"><input type="submit" name="btnsubmit" value="I Agree" />&nbsp;<input type="button" name="cancel" value="I dont Agree" onclick="window.location.href='received-bids.php';" /></td>
  </tr>
  </table>
  </td>
</tr>
</table>
</fieldset>
<? } ?>