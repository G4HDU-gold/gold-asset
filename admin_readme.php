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
require_once("../../class2.php");
if (!defined('e107_INIT'))
{
    exit;
}
if (!getperms("P"))
{
    header("location:" . e_HTTP . "index.php");
    exit;
}
include_lan(e_PLUGIN . "gold_asset/languages/readme/" . e_LANGUAGE . ".php");
require_once("plugin.php");
require_once(e_ADMIN . "auth.php");
if (!defined('ADMIN_WIDTH'))
{
    define(ADMIN_WIDTH, "width:100%;");
}
$welcome_text = "
<table class='fborder' style='" . ADMIN_WIDTH . "'>
	<tr>
		<td class='fcaption' colspan='2'>" . GASSET_R01 . "</td>
	</tr>
	<tr>
		<td class='forumheader3' style='width:15%;' >" . GASSET_R02 . "</td>
		<td class='forumheader3'>" .$eplug_name . "&nbsp;</td>
	</tr>
	<tr>
		<td class='forumheader3' style='width:15%;' >" . GASSET_R04 . "</td>
		<td class='forumheader3'>" . $eplug_author . "</td>
	</tr>
	<tr>
		<td class='forumheader3' style='width:15%;' >" . GASSET_R06 . "</td>
		<td class='forumheader3'>" .$eplug_version . "&nbsp;</td>
	</tr>
	<tr>
		<td class='forumheader3' style='width:15%;' >" . GASSET_R08 . "</td>
		<td class='forumheader3'>" . GASSET_R09 . "</td>
	</tr>
	<tr>
		<td class='forumheader3' style='width:15%;' >" . GASSET_R10 . "</td>
		<td class='forumheader3'>" . GASSET_R11 . "</td>
	</tr>
	<tr>
		<td class='forumheader3' style='width:15%;' >" . GASSET_R12 . "</td>
		<td class='forumheader3'>" . GASSET_R13 . "</td>
	</tr>
	<tr>
		<td class='forumheader3' style='width:15%;' >" . GASSET_R14 . "</td>
		<td class='forumheader3'>" . GASSET_R15 . "</td>
	</tr>
	<tr>
		<td class='forumheader3' style='width:15%;' >" . GASSET_R16 . "</td>
		<td class='forumheader3'>" . GASSET_R17 . "</td>
	</tr>
	<tr>
		<td class='forumheader3' style='width:15%;' >" . GASSET_R25 . "</td>
		<td class='forumheader3'><span style='color:#ff4444;'>" . GASSET_R24 . "</span></td>
	</tr>
	<tr>
		<td class='forumheader3' colspan='2'>
		<strong>" . GASSET_R18 . "</strong><br /><br />" . GASSET_R19 . "<br /><br />
		<strong>" . GASSET_R20 . "</strong><br /><br />" . GASSET_R21 . "<br /><br />
		<strong>" . GASSET_R22 . "</strong><br /><br />" . GASSET_R23 . "
		</td>
	</tr>
	<tr>
		<td class='fcaption' colspan='2'>&nbsp;</td>
	</tr>
</table>";


$ns->tablerender(GASSET_R01, $welcome_text);

require_once(e_ADMIN . "footer.php");


?>