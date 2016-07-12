<?php
/*
+---------------------------------------------------------------+
|        Gold Asset for e107 v7xx - by Father Barry
|
|        This module for the e107 .7+ website system
|        Copyright Barry Keal 2004-2009
|
|        Released under the terms and conditions of the
|        GNU General Public License (http://gnu.org).
|
+---------------------------------------------------------------+
*/
require_once('../../class2.php');
if (!defined('e107_INIT'))
{
    exit;
}
if (!getperms('P'))
{
    header('location:' . e_HTTP . 'index.php');
    exit;
}
include_lan(e_PLUGIN . "gold_asset/languages/" . e_LANGUAGE . "_goldasset.php");
require_once(e_HANDLER . 'userclass_class.php');

if (!is_object($gasset_obj))
{
    require_once(e_PLUGIN . 'gold_asset/includes/gold_asset_class.php');
    $gasset_obj = new gold_asset;
}
require_once(e_ADMIN . 'auth.php');
if (!defined('ADMIN_WIDTH'))
{
    define(ADMIN_WIDTH, 'width:100%;');
}
// *
// *
if (isset($_POST['update']))
{
    // Update rest
    $GOLD_ASSET_PREF['gasset_buyclass'] = intval($_POST['gasset_buyclass']);
    $GOLD_ASSET_PREF['gasset_showall'] = intval($_POST['gasset_showall']);
    $GOLD_ASSET_PREF['gasset_sell'] = intval($_POST['gasset_sell']);

    $gasset_obj->save_prefs();
    $gasset_msg .= '<strong>' . GOLD_ASSET_C_05 . '</strong>';
}

$gasset_text .= '
<form method="post" action="' . e_SELF . '" id="gasset_form">
	<table style="' . ADMIN_WIDTH . '" class="fborder">
		<tr>
			<td colspan="2" class="fcaption">' . GOLD_ASSET_C_03 . '</td>
		</tr>
		<tr>
			<td class="forumheader3" colspan="2">' . $gasset_msg . '&nbsp;</td>
		</tr>';
// Main admin class
$gasset_text .= '
		<tr>
			<td style="width:30%" class="forumheader3">' . GOLD_ASSET_C_04 . '</td>
			<td style="width:70%" class="forumheader3">' . r_userclass('gasset_buyclass', $GOLD_ASSET_PREF['gasset_buyclass'], 'off', 'nobody,member,main,admin,classes') . '</td>
		</tr>';
$gasset_text .= '
		<tr>
 			<td style="width:30%" class="forumheader3">' . GOLD_ASSET_C_10 . '</td>
 			<td style="width:70%" class="forumheader3">
	 			<input name="gasset_showall" value="1" type="checkbox" class="tbox" style="border:0;" ' . ($GOLD_ASSET_PREF['gasset_showall'] == 1?'checked="checked"':'') . ' />
	 		</td>
	 	</tr>';
$gasset_text .= '
		<tr>
 			<td style="width:30%" class="forumheader3">' . GOLD_ASSET_C_06 . '</td>
 			<td style="width:70%" class="forumheader3">
	 			<input name="gasset_sell"  type="text" class="tbox" value="' . $GOLD_ASSET_PREF['gasset_sell'] . '" />
	 		</td>
	 	</tr>';
// Submit button
$gasset_text .= '
		<tr>
			<td colspan="2" class="forumheader2" style="text-align: left;">
				<input type="submit" name="update" value="' . GOLD_ASSET_C_02 . '" class="button" />
			</td>
		</tr>
		<tr>
			<td colspan="2" class="fcaption" style="text-align: left;">&nbsp;</td>
		</tr>
	</table>
</form>';
$ns->tablerender(GOLD_ASSET_C_01, $gasset_text);
require_once(e_ADMIN . "footer.php");
