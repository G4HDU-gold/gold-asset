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

if (!defined('e107_INIT'))
{
    exit;
}

global $sql, $gasset_obj, $GLOTTO_PREF, $gold_obj, $pref;
if (substr($pref['plug_installed']['gold_system'], 0, 1) >= 4 )
{
    include_lan(e_PLUGIN . "gold_asset/languages/" . e_LANGUAGE . "_goldasset.php");
    if (!is_object($gold_obj))
    {
        require_once(e_PLUGIN . 'gold_system/includes/gold_class.php');
        if (!is_object($gold_obj))
        {
            $gold_obj = new gold;
        }
    }
    if (is_object($gold_obj) && $gold_obj->plugin_active('gold_asset'))
    {
        require_once(e_PLUGIN . 'gold_asset/includes/gold_asset_class.php');
        if (!is_object($gasset_obj))
        {
            $gasset_obj = new gold_asset;
        }
    }
}

?>