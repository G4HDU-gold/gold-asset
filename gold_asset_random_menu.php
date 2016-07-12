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
global $gold_obj, $tp,$sql;
if (!USER)
{
    // not a logged in user so don't display the menu
    return;
}
else
{

    if ($gold_obj->plugin_active('gold_asset'))
    {
    // get a random user and an asset
    $sql->db_Select_gen('select gasset_asset,user_name,user_id from #gold_asset left join #user on user_id=gasset_user_id order by rand() limit 1',false);
    extract($sql->db_Fetch());

        // asset plugin is active
        $gasset_text = '<div style="text-align:center;"><b>' .$tp->toHTML($user_name,false).' ' .GOLD_ASSET_MEN05 . '</b><br /><a href="' . e_PLUGIN . 'gold_asset/viewassets.php?'.$user_id.'">' . $tp->parsetemplate('{GOLD_ASSET_SPECIFIC='.$gasset_asset.',64}') . '</a><br />
		<a href="' . e_PLUGIN . 'gold_asset/viewassets.php?'.$user_id.'">' . GOLD_ASSET_MEN06 . '</a></div>';
        if (file_exists(e_PLUGIN . 'gold_asset/images/gold_asset_menu.png'))
        {
            $gasset_caption = '<img src="' . e_PLUGIN . 'gold_asset/images/gold_asset_menu.png" style="border:0px;" alt="' . $GOLD_PREF['gold_currency_name'] . '" /> ' . GOLD_ASSET_MEN04;
        }
        else
        {
            $gasset_caption = GOLD_ASSET_MEN01;
        }

        $ns->tablerender($gasset_caption , $gasset_text, 'gasset_randmenu'); // Render the menu
    }
}
