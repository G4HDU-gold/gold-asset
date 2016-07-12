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
$sql->db_Select('gold_asset_cat', '*', 'order by gasset_cat_name', 'nowhere', false);
while ($fred = $sql->db_Fetch())
{
    $catlist[$fred['gasset_cat_id']] = $fred['gasset_cat_name'];
}
require_once(e_HANDLER . 'file_class.php');
$gasset_fclass = new e_file;

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
$gasset_omit = array('^\.$', '^\.\.$', '^\/$', '^CVS$', 'thumbs\.db', '.*\._$', '^\.htaccess$', 'index\.html', 'null\.txt', '\.LCK');
// scan the asset directories for all assets
$gasset_list = $gasset_fclass->get_files('assets/', 'asset.php', $gasset_omit, 1);
// print_a($gasset_list);
if (isset($_POST['gasset_sub']))
{
    // print_a($_POST);
    foreach($_POST['gasset_folder'] as $gasset_key => $gasset_folder)
    {
        $gasset_array[$gasset_folder]['cost'] = $_POST['gasset_cost'][$gasset_key];
        $gasset_array[$gasset_folder]['class'] = $_POST['gasset_class'][$gasset_key];
        $gasset_array[$gasset_folder]['category'] = $_POST['gasset_cat'][$gasset_key];
        $gasset_array[$gasset_folder]['maxnum'] = $_POST['gasset_maxnum'][$gasset_key];
    }
    $GOLD_ASSET_PREF['gasset_assets'] = serialize($gasset_array);
    // clear cache entries for assets
    $gasset_obj->save_prefs();
    $cache_cleartag = array('nq_gasset_menu', 'gasset_list', 'nomd5_gasset_plist', 'nomd5_gasset_assets');
    $gasset_obj->clear_cache($cache_cleartag);
    $gasset_msg .= '<b>' . GOLD_ASSET_C_05 . '</b>';
}
$gasset_data = unserialize($GOLD_ASSET_PREF['gasset_assets']);
// print_a($gasset_data);
$gasset_text .= '
<form method="post" action="' . e_SELF . '" id="gasset_assets" >
	<table class="fborder" style="' . ADMIN_WIDTH . '" >
		<tr>
			<td class="fcaption" colspan="2">' . GOLD_ASSET_O_01 . '</td>
		</tr>';
$gasset_even = true;
foreach($gasset_list as $gasset_assetmain)
{
    if ($gasset_even)
    {
        $gasset_text .= '
		<tr>';
    }
    require_once(e_PLUGIN . 'gold_asset/' . $gasset_assetmain['path'] . '/' . $gasset_assetmain['fname']);
    $gasset_text .= '
			<td class="forumheader3" style="width:50%">
			<input type="hidden" name="gasset_folder[]" value="' . $gasset_folder . '" />
				<table style="width:100%">
					<tr>
						<td class="fcaption" colspan="2">' . $gasset[$gasset_folder]['title'] . '</td>
					</tr>
					<tr>
						<td class="forumheader3"  style="text-align:center;width:20%">
						<img src="' . e_PLUGIN . 'gold_asset/assets/' . $gasset_folder . '/' . $gasset[$gasset_folder]['icon_64'] . '" alt="" /></td>
						<td class="forumheader3">' . $gasset[$gasset_folder]['description'] . '</td>
					</tr>
					<tr>
						<td class="forumheader3" style="width:20%" >' . GOLD_ASSET_O_02 . '</td>
						<td class="forumheader3"> <input class="tbox" name="gasset_cost[]" value="' . $gasset_data[$gasset_folder]['cost'] . '" /></td>
					</tr>
					<tr>
						<td class="forumheader3" style="width:20%" >' . GOLD_ASSET_O_07 . '</td>
						<td class="forumheader3"> <input class="tbox" name="gasset_maxnum[]" value="' . $gasset_data[$gasset_folder]['maxnum'] . '" /></td>
					</tr>
					<tr>
						<td class="forumheader3" style="width:20%">' . GOLD_ASSET_O_03 . '</td>
						<td class="forumheader3"> ' . r_userclass('gasset_class[]', $gasset_data[$gasset_folder]['class'], 'off', 'nobody,member,admin,main,classes') . ' </td>
					</tr>
					<tr>
						<td class="forumheader3" style="width:20%">' . GOLD_ASSET_O_06 . '</td>
						<td class="forumheader3"> ' . gasset_cat('gasset_cat[]', $gasset_data[$gasset_folder]['category']) . ' </td>
					</tr>
				</table>
			</td>
	';
    if (!$gasset_even)
    {
        $gasset_text .= '
		</tr>';
    }
    $gasset_even = !$gasset_even;
}
if (!$gasset_even)
{
    $gasset_text .= '
			<td class="forumheader3" style="width:50%">
				&nbsp;
			</td>
		</tr>';
}
$gasset_text .= '
		<tr>
			<td class="forumheader2" colspan="2"><input type="submit" class="button" name="gasset_sub" value="' . GOLD_ASSET_O_05 . '" /></td>
		</tr>
		<tr>
			<td class="forumheader2" colspan="2">&nbsp;</td>
		</tr>
	</table>
</form>';
// print_a($gasset);
$ns->tablerender(GOLD_ASSET_C_01, $gasset_text);

require_once(e_ADMIN . "footer.php");

function gasset_cat($fieldname, $current_value)
{
    global $catlist;

    $retval = '<select class="tbox" name="' . $fieldname . '" >';
    foreach($catlist as $key => $value)
    {
        $retval .= '<option value="' . $key . '" ' . ($current_value == $key?'selected="selected"':'') . '>' . $value . '</option>';
    }
    $retval .= '</select>';
    return $retval;
}
