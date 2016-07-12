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
error_reporting(E_ALL);
if (!defined('e107_INIT'))
{
    exit;
}
error_reporting(E_ALL);
include_lan(e_PLUGIN . "gold_asset/languages/" . e_LANGUAGE . "_goldasset.php");
if (substr($pref['plug_installed']['gold_system'], 0, 1) < 4)
{
    require_once(HEADERF);
    print GOLD_ASSET_115;
    require_once(FOOTERF);
    exit;
}
if (!is_object($gold_obj))
{
    require_once(e_PLUGIN . 'gold_system/includes/gold_class.php');
    $gold_obj = new gold;
}
if (!$gold_obj->plugin_active('gold_asset'))
{
    require_once(HEADERF);
    print GOLD_ASSET_116;
    require_once(FOOTERF);
    exit;
}
require_once(e_HANDLER . 'userclass_class.php');
require_once(e_HANDLER . 'file_class.php');
$gasset_fclass = new e_file;

if (!is_object($gasset_obj))
{
    require_once(e_PLUGIN . 'gold_asset/includes/gold_asset_class.php');
    $gasset_obj = new gold_asset;
}
if (e_QUERY)
{
    $gold_buyfor = intval(e_QUERY);
}
else
{
    $gold_buyfor = 0;
}
require_once(HEADERF);

if (!defined('USER_WIDTH'))
{
    define(USER_WIDTH, 'width:100%;');
}
if (file_exists(THEME . 'gold_asset_template.php'))
{
    define(GASSET_THEME, THEME . 'gold_asset_template.php');
}
else
{
    define(GASSET_THEME, e_PLUGIN . 'gold_asset/templates/gold_asset_template.php');
}
if (file_exists(THEME . '/images/gold_asset_logo.png'))
{
    define(GASSET_LOGO, THEME . '/images/gold_asset_logo.png');
} elseif (file_exists(e_PLUGIN . 'gold_asset/images/gold_asset_logo.png'))
{
    define(GASSET_LOGO, e_PLUGIN . 'gold_asset/images/gold_asset_logo.png');
}
require_once(GASSET_THEME);

require_once(e_PLUGIN . 'gold_asset/includes/gold_asset_shortcodes.php');
unset($gasset_data);
$gasset_data = unserialize($GOLD_ASSET_PREF['gasset_assets']);
// *****************************************************************************
// * get count of how many assets in use
// *****************************************************************************
$sql->db_Select_gen('select count(gasset_asset) as numinuse, gasset_asset from #gold_asset group by gasset_asset', false);
while ($gasset_row = $sql->db_Fetch())
{
    $gasset_inuse[$gasset_row['gasset_asset']] = intval($gasset_row['numinuse']);
}
// *****************************************************************************
// * Buy a asset
// *****************************************************************************
if (isset($_POST['gasset_sell']))
{
    $gasset_assetfolder = key($_POST['gasset_sell']);
    // get the asset details
    require(e_PLUGIN . 'gold_asset/assets/' . $gasset_assetfolder . '/asset.php');
    $gasset_title = $gasset[$gasset_assetfolder]['title'];
    // make the message
    $sender = USERID;
    $item = $gasset_assetfolder;
    $recipient = USERID;
    $comment = $_POST['gasset_comment'];
    if ($gasset_obj->sell_asset($item))
    {
        $gasset_message = GOLD_ASSET_119 . ' <b>' . $gasset_title . '</b>';
        // $gasset_showasset = '<div><img src="' . SITEURL . $PLUGINS_DIRECTORY . 'gold_asset/assets/' . $gasset_assetfolder . '/' . $gasset[$gasset_assetfolder ]['icon_64'] . '" style="border:0px;" alt="' . $gasset_title . '" title="' . $gasset_title . '" /></div>';
        // charge the user
        $gasset_gross = $gasset_data[$gasset_assetfolder ]['cost'];
        $gold_param['gold_user_id'] = USERID;
        $gold_param['gold_who_id'] = USERID;
        $gold_param['gold_amount'] = $gasset_gross - intval($gasset_gross * $GOLD_ASSET_PREF['gasset_sell'] / 100);
        $gold_param['gold_type'] = GOLD_ASSET_119;
        $gold_param['gold_action'] = 'credit';
        $gold_param['gold_plugin'] = 'gold_asset';
        $gold_param['gold_log'] = GOLD_ASSET_124 . ' ' . $gasset_title ;
        $gold_param['gold_forum'] = 0;
        $gold_obj->gold_modify($gold_param, false);
        // clear the menu cache for all users - not the most efficient (should be just the specific user) but close enough for now
        $cache_cleartag = array('nq_gasset_menu');
        $gasset_obj->clear_cache($cache_cleartag);
    }
}
if (isset($_POST['gasset_buy']))
{
    $gasset_assetfolder = key($_POST['gasset_buy']);
    // get the asset details
    require(e_PLUGIN . 'gold_asset/assets/' . $gasset_assetfolder . '/asset.php');
    $gasset_title = $gasset[$gasset_assetfolder]['title'];
    // make the message
    $sender = USERID;
    $item = $gasset_assetfolder;
    $recipient = USERID;
    $comment = $_POST['gasset_comment'];

    if ($gold_obj->gold_balance() > $gasset_data[$gasset_assetfolder ]['cost'])
    {
        if ($gasset_obj->buy_asset($item))
        {
            $gasset_message = GOLD_ASSET_118 . ' <b>' . $gasset_title . '</b>';
            // $gasset_showasset = '<div><img src="' . SITEURL . $PLUGINS_DIRECTORY . 'gold_asset/assets/' . $gasset_assetfolder . '/' . $gasset[$gasset_assetfolder ]['icon_64'] . '" style="border:0px;" alt="' . $gasset_title . '" title="' . $gasset_title . '" /></div>';
            // charge the user
            $gold_param['gold_user_id'] = USERID;
            $gold_param['gold_who_id'] = USERID;
            $gold_param['gold_amount'] = $gasset_data[$gasset_assetfolder ]['cost'];
            $gold_param['gold_type'] = GOLD_ASSET_120;
            $gold_param['gold_action'] = 'debit';
            $gold_param['gold_plugin'] = 'gold_asset';
            $gold_param['gold_log'] = GOLD_ASSET_121 . ' ' . $gasset_title ;
            $gold_param['gold_forum'] = 0;
            $gold_obj->gold_modify($gold_param, false);
            // clear the menu cache for all users - not the most efficient (should be just the specific user) but close enough for now
            $cache_cleartag = array('nq_gasset_menu');
            $gasset_obj->clear_cache($cache_cleartag);
        }
    }
    else
    {
        $gasset_message = GOLD_ASSET_129;
    }
}
// print_a($gasset_inuse);
// get this users list of assets
$sql->db_Select('gold_asset', 'gasset_asset', 'where gasset_user_id =' . USERID, 'nowhere', false);
while ($gasset_row = $sql->db_Fetch())
{
    $gasset_myassets[] = $gasset_row['gasset_asset'];
}
// get all the current assets from the cached list of assets if possible
$cache_tag = 'nomd5_gasset_plist';
if ($cacheData = $e107cache->retrieve($cache_tag))
{
    $gasset_list = $eArrayStorage->ReadArray($cacheData);
}
else
{
    $gasset_omit = array('^\.$', '^\.\.$', '^\/$', '^CVS$', 'thumbs\.db', '.*\._$', '^\.htaccess$', 'index\.html', 'null\.txt', '\.LCK');
    // scan the asset directories for all assets
    $gasset_list = $gasset_fclass->get_files('assets/', 'asset.php', $gasset_omit, 1);
    $tmp = $eArrayStorage->WriteArray($gasset_list, false);
    $e107cache->set($cache_tag, $tmp);
}
$cache_tag = 'nomd5_gasset_assets';
if ($cacheData = $e107cache->retrieve($cache_tag))
{
    $gasset = $eArrayStorage->ReadArray($cacheData);
}
else
{
    foreach($gasset_list as $key => $gasset_foldername)
    {
        if (file_exists(e_PLUGIN . 'gold_asset/' . $gasset_foldername['path'] . 'asset.php'))
        {
            require(e_PLUGIN . 'gold_asset/' . $gasset_foldername['path'] . 'asset.php');
        }
    }
    $tmp = $eArrayStorage->WriteArray($gasset, false);
    $e107cache->set($cache_tag, $tmp);
}
$gasset_text .= '
<script type="text/javascript">
	function gasset_ConfirmPurchase(item,cost)
	{
		return confirm("' . GOLD_ASSET_107 . ' - " +item + " ' . GOLD_ASSET_117 . ' " + cost);
	}
	function gasset_ConfirmSale(item,cost,premium)
	{
		return confirm("' . GOLD_ASSET_141 . ' - " +item + " ' . GOLD_ASSET_142 . ' " + cost + " ' . GOLD_ASSET_143 . ' " + premium + " ' . GOLD_ASSET_144 . ' ");
	}
</script>
<form method="post" action="' . e_SELF . '" id="gasset_buyassets" >';
$gasset_text .= $tp->parsetemplate($GOLD_ASSET_HEADER, true, $gasset_shortcodes);
$sql->db_Select('gold_asset_cat', '*', 'order by gasset_cat_name', 'nowhere', false);
while ($gasset_catrow = $sql->db_Fetch())
{
    $gasset_catlist[$gasset_catrow['gasset_cat_id']] = $tp->toFORM($gasset_catrow['gasset_cat_name']);
    $gasset_tabs .= "'" . $tp->toFORM($gasset_catrow['gasset_cat_name']) . "',";
}
$gasset_tabs = substr($gasset_tabs, 0, -1);
$gasset_ctext .= '
	<table style="' . USER_WIDTH . '">
		<tr>
			<td>
				<div id="gold_asset" style="width:100%">';
foreach($gasset_list as $gasset_assetmain)
{
    require(e_PLUGIN . 'gold_asset/' . $gasset_assetmain['path'] . '/' . $gasset_assetmain['fname']);
    if ($gasset_data[$gasset_folder]['maxnum'] == 0)
    {
        // unlimited number available
        $gasset_unlimited = true;
    }
    else
    {
        // restricted number
        $gasset_numavail = $gasset_data[$gasset_folder]['maxnum'] - $gasset_inuse[$gasset_folder];

        $gasset_unlimited = false;
    }
    $gasset_button = '';
    if (check_class($gasset_data[$gasset_folder]['class']))
    {
        if (in_array($gasset_folder, $gasset_myassets))
        {
            $gasset_button .= '<input type="submit" class="button" onclick="return gasset_ConfirmSale(\'' . $gasset[$gasset_folder]['title'] . '\',' . $gasset_data[$gasset_folder]['cost'] . ',' . $GOLD_ASSET_PREF['gasset_sell'] . ')" name="gasset_sell[' . $gasset_folder . ']" value="' . GOLD_ASSET_112 . '" /> ';;
        } elseif ($gasset_data[$gasset_folder]['cost'] > $gold_obj->gold_balance(USERID))
        {
            $gasset_button .= GOLD_ASSET_113;
        }
        else
        {
            if ($gasset_unlimited)
            {
                $gasset_button .= '<input type="submit" class="button" onclick="return gasset_ConfirmPurchase(\'' . $gasset[$gasset_folder]['title'] . '\',' . $gasset_data[$gasset_folder]['cost'] . ')" name="gasset_buy[' . $gasset_folder . ']" value="' . GOLD_ASSET_110 . '" /> ';
            }
            else
            {
                $gasset_button .= '<input type="submit" class="button" onclick="return gasset_ConfirmPurchase(\'' . $gasset[$gasset_folder]['title'] . '\',' . $gasset_data[$gasset_folder]['cost'] . ')" name="gasset_buy[' . $gasset_folder . ']" value="' . GOLD_ASSET_110 . '" /> (' . $gasset_numavail . ' ' . GOLD_ASSET_146 . ')';
            }
        }
    }
    else
    {
        $gasset_button .= GOLD_ASSET_114;
    }
    if (($GOLD_ASSET_PREF['gasset_showall'] != 1 && check_class($gasset_data[$gasset_folder]['class'])) || $GOLD_ASSET_PREF['gasset_showall'] == 1)
    {
        $gasset_content[$gasset_catlist[$gasset_data[$gasset_folder]['category']]] .= $tp->parsetemplate($GOLD_ASSET_PRESENT, true, $gasset_shortcodes);
    }
}
ksort($gasset_content);
foreach($gasset_catlist as $value)
{
    $row = $gasset_content[$value];
    if (empty($row))
    {
        $row = GOLD_ASSET_130;
    }
    $gasset_ctext .= '
  <div class="dhtmlgoodies_aTab">' . $row . '
  </div>';
}

$gasset_ctext .= $tp->parsetemplate($GOLD_ASSET_FOOTER, true, $gasset_shortcodes);
$gasset_ctext .= '
				</div>
			</td>
		</tr>
	</table>
</form>';
$gasset_ctext .= '
<script type="text/javascript">
var tabviewfolder="' . SITEURL . $PLUGINS_DIRECTORY . 'gold_system/includes/tabview/"
initTabs(\'gold_asset\',Array(' . $gasset_tabs . '),0,\'100%\',\'\');
</script>';
$gasset_text .= $gasset_ctext;
$ns->tablerender($page_title, $gasset_text, 'gasset_main'); // Render the menu
require_once(FOOTERF);
