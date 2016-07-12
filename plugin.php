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
// ***************************************************************
// *
// *		Title		:	Gold Asset
// *
// *		Author		:	Barry Keal
// *
// *		Date		:	22 July 2008
// *
// *		Version		:	1.1
// *
// *		Description	: 	Gold Asset
// *
// *		Revisions	:	 8 August 2008 Initial Design
// *
// *		Support at	:	www.keal.me.uk
// *
// ***************************************************************
include_lan(e_PLUGIN . 'gold_asset/languages/' . e_LANGUAGE . '_goldasset.php');
// Plugin info -------------------------------------------------------------------------------------------------------
$eplug_name = 'Gold Asset';
$eplug_version = '1.2';
$eplug_author = 'Father Barry';
$eplug_url = 'http://keal.me.uk';
$eplug_email = '';
$eplug_description = GOLD_ASSET_P_02;
$eplug_compatible = 'e107v7.11';
$eplug_readme = 'admin_readme.php'; // leave blank if no readme file
$eplug_compliant = true;
// Name of the plugin's folder -------------------------------------------------------------------------------------
$eplug_folder = 'gold_asset';
// Name of menu item for plugin ----------------------------------------------------------------------------------
$eplug_menu_name = GOLD_ASSET_P_01;
// Name of the admin configuration file --------------------------------------------------------------------------
$eplug_conffile = 'admin_config.php';
// Icon image and caption text ------------------------------------------------------------------------------------
$eplug_icon_small = $eplug_folder . '/images/gold_asset_16.png';
$eplug_icon = $eplug_folder . '/images/gold_asset_32.png';
$eplug_caption = GOLD_ASSET_P_01;
// create tables -----------------------------------------------------------------------------------------------
$eplug_sql = file_get_contents(e_PLUGIN . "{$eplug_folder}/gold_asset_sql.php");
preg_match_all("/CREATE TABLE (.*?)\(/i", $eplug_sql, $matches);
$eplug_table_names = $matches[1];
// List of sql requests to create tables -----------------------------------------------------------------------------
// Apply create instructions for every table you defined in locator_sql.php --------------------------------------
// MPREFIX must be used because database prefix can be customized instead of default e107_
$eplug_tables = explode(";", str_replace("CREATE TABLE ", "CREATE TABLE " . MPREFIX, $eplug_sql));
for ($i = 0; $i < count($eplug_tables); $i++)
{
    $eplug_tables[$i] .= ';';
}
array_pop($eplug_tables); // Get rid of last (empty) entry

// Create a link in main menu (yes=TRUE, no=FALSE) -------------------------------------------------------------
$eplug_link = true;
$eplug_link_name = GOLD_ASSET_P_01;
$eplug_link_url = e_PLUGIN . 'gold_asset/index.php';
// Text to display after plugin successfully installed ------------------------------------------------------------------
$eplug_done = GOLD_ASSET_P_03;
// upgrading ... //
$upgrade_add_prefs = '';

$upgrade_remove_prefs = '';

$upgrade_alter_tables = '';

$eplug_upgrade_done = GOLD_ASSET_P_04;

if (!function_exists('gold_asset_uninstall'))
{
    function gold_asset_uninstall()
    {
        global $sql;
        $sql->db_Delete('core', 'e107_name="gold_asset" ');
    }
}

?>