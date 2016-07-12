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
include_lan(e_PLUGIN . 'gold_system/languages/' . e_LANGUAGE . '_gold_system.php');
include_lan(e_PLUGIN . "gold_asset/languages/" . e_LANGUAGE . "_goldasset.php");

if (!defined('e107_INIT'))
{
    exit;
}
global $gold_obj, $tp, $e107cache;
if (!USER)
{
    // not a logged in user so don't display the menu
    return;
}
else
{
    // user is logged in so see if their asset is in the cache
    // $cache_tag = 'nq_gasset_menu';
    // if (1==2 && $cacheData = $e107cache->retrieve($cache_tag))
    // {
    // yes so display the asset
    // echo $cacheData;
    // return;
    // }
    if ($gold_obj->plugin_active('gold_asset'))
    {
        // asset plugin is active
        $gasset_text = '<div style="text-align:center;"><b>' . GOLD_ASSET_MEN02 . '</b><br /><a href="' . e_PLUGIN . 'gold_asset/viewassets.php?'.USERID.'">' . $tp->parsetemplate('{GOLD_ASSET_LATEST=,,64}') . '</a><br />
		<a href="' . e_PLUGIN . 'gold_asset/viewassets.php?'.USERID.'">' . GOLD_ASSET_MEN03 . '</a></div>';
        if (file_exists(e_PLUGIN . 'gold_asset/images/gold_asset_menu.png'))
        {
            $gasset_caption = '<img src="' . e_PLUGIN . 'gold_asset/images/gold_asset_menu.png" style="border:0px;" alt="' . $GOLD_PREF['gold_currency_name'] . '" /> ' . GOLD_ASSET_MEN01;
        }
        else
        {
            $gasset_caption = GOLD_ASSET_MEN01;
        }
        // ob_start(); // Set up a new output buffer
        $ns->tablerender($gasset_caption , $gasset_text, 'gasset_menu'); // Render the menu
        // $cache_data = ob_get_flush(); // Get the menu content, and display it
        // $e107cache->set($cache_tag, $cache_data); // Save to cache
    }
    // else
    // {
    // return ;
    // }
}
