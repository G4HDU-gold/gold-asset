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
include_once(e_HANDLER . 'shortcode_handler.php');
$gasset_shortcodes = $tp->e_sc->parse_scbatch(__FILE__);
// * start shortcodes
/*
SC_BEGIN GASSET_BALANCE
 global $gold_obj;
 return $gold_obj->formation($gold_obj->gold_balance(USERID));
SC_END

SC_BEGIN GASSET_MESSAGE
global $gasset_message;
return $gasset_message;
SC_END

SC_BEGIN GASSET_FOLDER
global $gasset,$gasset_folder;
return '<input type="hidden" name="gasset_folder[]" value="' . $gasset_folder . '" />';
SC_END

SC_BEGIN GASSET_TITLE
global $gasset,$gasset_folder;
return $gasset[$gasset_folder]['title'];
SC_END

SC_BEGIN GASSET_IMAGE
global $gasset,$gasset_folder;
return '<img src="' . e_PLUGIN . 'gold_asset/assets/' . $gasset_folder . '/' . $gasset[$gasset_folder]['icon_64'] . '"  alt="" title=""/>';
SC_END

SC_BEGIN GASSET_DESCRIPTION
global $gasset,$gasset_folder;
return $gasset[$gasset_folder]['description'] ;
SC_END

SC_BEGIN GASSET_SAMPLE
global $gasset,$gasset_folder;
return '<img id="' . $gasset_folder . time() . '" src="' . e_PLUGIN . 'gold_asset/samples/' . $gasset_folder . '.png" style="border:0px;" title="'.$gasset[$gasset_folder]['title'].'" alt="'.$gasset[$gasset_folder]['title'].'" />';
SC_END

SC_BEGIN GASSET_COST
global $gasset,$gasset_data,$gasset_folder,$gold_obj;
return $gold_obj->formation($gasset_data[$gasset_folder]['cost']);
SC_END

SC_BEGIN GASSET_CLASS
global $gasset,$gasset_data,$gasset_folder;
return  r_userclass_name($gasset_data[$gasset_folder]['class']);
SC_END

SC_BEGIN GASSET_BUTTON
global $gasset_button;
return $gasset_button;
SC_END

SC_BEGIN GASSET_RECIPIENT
global $gold_obj;
return $gold_obj->select_user("gasset_user", $user);;
SC_END

SC_BEGIN GASSET_16

global $gasset,$gasset_folder;
return '<img src="' . e_PLUGIN . 'gold_asset/assets/' . $gasset_folder . '/' . $gasset[$gasset_folder]['icon_16'] . '" alt="" title=""/>';
SC_END

SC_BEGIN GASSET_EXPAND
global $gasset_folder;
return 'id-'.$gasset_folder.$parm;
SC_END

SC_BEGIN GASSET_PRESFOLDER
global $gasset_folder;
return 'id-'.$gasset_folder;
SC_END

SC_BEGIN GPRESSEY_MODERATE

return '<a href="'.e_PLUGIN.'gold_asset/myassets.php" >'.GOLD_ASSET_131.'</a>';
SC_END

SC_BEGIN GASSET_ED_PIC
	global $gasset_pic;
	return $gasset_pic;
SC_END




SC_BEGIN GASSET_ED_SUBMIT
return '<input type="submit" class="button" name="gasset_submit" value="'.GOLD_ASSET_132.'" />';
SC_END

SC_BEGIN GASSET_ED_DESC
global $gasset_desc;
return $gasset_desc;

SC_END

SC_BEGIN GASSET_ED_TITLE
	global $gasset_title;
	return $gasset_title;
SC_END

SC_BEGIN GASSET_OWNER
	global $gasset_uname,$tp;
	return $tp->toHTML($gasset_uname,false);
SC_END








*/