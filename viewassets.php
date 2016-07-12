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
if (!is_object($gasset_obj))
{
    require_once(e_PLUGIN . 'gold_asset/includes/gold_asset_class.php');
    $gasset_obj = new gold_asset;
}
$cache_tag = 'gasset_viewlist';
if (1 == 2 && $cacheData = $e107cache->retrieve($cache_tag))
{
    // yes so display the asset
    $gasset_text = $cacheData;
}
else
{
    require_once(e_HANDLER . 'userclass_class.php');
    if (!is_object($gasset_conv))
    {
        require_once(e_HANDLER . 'date_handler.php');
        $gasset_conv = new convert;
    }

    require_once(e_HANDLER . 'file_class.php');
    $gasset_fclass = new e_file;

    $gasset_userid = intval(e_QUERY);

    require_once(e_PLUGIN . 'gold_asset/includes/gold_asset_shortcodes.php');
    // get all the assets
    $gasset_data = unserialize($GOLD_ASSET_PREF['gasset_assets']);
    // start of form to show all received assets
    // select all assets for this user.
    $sql2->db_Select('user','user_name','where user_id='.$gasset_userid,'nowhere',false);
    extract($sql2->db_Fetch());
                    $gasset_uname=$user_name;
    $gasset_text .= $tp->parsetemplate($GOLD_ASSET_VIEWHEADER, true, $gasset_shortcodes);
    if ($sql2->db_Select_gen('select * from #gold_asset where gasset_user_id = ' . $gasset_userid . ' order by gasset_bought desc', false))
    {
        while ($gasset_row = $sql2->db_Fetch())
        {
            extract($gasset_row);

            if (!empty($gasset_asset) && is_readable(e_PLUGIN . 'gold_asset/assets/' . $gasset_asset . '/asset.php'))
            {

                require(e_PLUGIN . 'gold_asset/assets/' . $gasset_asset . '/asset.php');
                $gasset_pic = '<img src="' . e_PLUGIN . 'gold_asset/assets/' . $gasset_asset . '/' . $gasset[$gasset_asset]['icon_64'] . '" style="border:0px" alt="" title="" />';
                $gasset_title = $gasset[$gasset_asset]['title'];
                $gasset_desc = $gasset[$gasset_asset]['description'];

                $gasset_text .= $tp->parsetemplate($GOLD_ASSET_VIEWDETAIL, true, $gasset_shortcodes);
            }
        }
    }
    $gasset_text .= $tp->parsetemplate($GOLD_ASSET_VIEWFOOTER, true, $gasset_shortcodes);
    $gasset_text .= '</form>';
  #  $e107cache->set($cache_tag, $gasset_text); // Save to cache
}
$ns->tablerender(GOLD_ASSET_MOD07, $gasset_text, 'gasset_view');
require_once(FOOTERF);
