<?php
// get the language file for the plugin
// This can be used to make the links and descriptions etc language
// independent
include_lan(e_PLUGIN . "gold_asset/languages/" . e_LANGUAGE . "_goldasset.php");
// Define an element in the array $e_gold
$e_gold[] = array(
    'plug_name' => 'Gold Asset', // the name of this plugin - can be a language constant
    'plug_folder' => 'gold_asset', // the folder name for this plugin
    'add' => true, // Is gold added by this plugin
    'deduct' => true, // is gold deducted by this plugin
    'gold_menu' => true, // Does it have a link to go in the gold menu
    'gold_link' => '{e_PLUGIN}gold_asset/index.php', // the link for the gold menu to the main plugin file
    'gold_title' => GOLD_ASSET_BUY, // The title for the plugin in the menu
    'gold_shop' => true, // Does this plugin integrate into the gold shop
    'gold_shop_title' => GOLD_ASSET_TITLE, // title to appear in the gold shop
    'gold_shop_name' => GOLD_ASSET_NAME, // The name to go in the gold shop
    'gold_shop_desc' => GOLD_ASSET_DESC, // A full text description of the shop entry
    'gold_shop_icon' => e_PLUGIN . 'gold_asset/images/gold_asset_64.png', // the Icon for the shop (64 x 64px)
    'gold_shop_url' => e_PLUGIN . 'gold_asset/index.php' // the url to the main plugin
    );

if (!function_exists('gold_asset_configure_edit'))
{
    // Function for setting any parameters for this plugin
    // this is displayed in the main gold system Plugins configuration
    // not essential to do this, just return a message saying to use the main config
    // for the plugin
    function gold_asset_configure_edit()
    {
        $retval = "
<form method='post' action='" . e_SELF . "' id='gold_asset' >
	<div>
		<input type='hidden' name='gold_plugin' value='gold_asset' />
	</div>
	<table class='fborder' style='" . ADMIN_WIDTH . "'>
		<tr>
			<td class='fcaption' colspan='2' style='text-align:left'>" . GOLD_ASSET_G01 . "</td>
		</tr>
		<tr>
			<td class='forumheader2' colspan='2' style='text-align:left'>" . GOLD_ASSET_G02 . "&nbsp;</td>
		</tr>
		<tr>
			<td class='forumheader2' colspan='2' style='text-align:left'>
				<input type='submit' class='button' name='gold_save' value='" . GOLD_ASSET_G03 . "' />
			</td>
		</tr>
		<tr>
			<td class='fcaption' colspan='2' style='text-align:left'>&nbsp;</td>
		</tr>
	</table>
</form>";
        // contents of $retval displayed in gold plugin manager
        return $retval;
    }
}
if (!function_exists('gold_asset_configure_save'))
{
    function gold_asset_configure_save()
    {
        // perform any saving of settings then return success fail message as appropriate.
        return GOLD_ASSET_G04;
    }
}

?>