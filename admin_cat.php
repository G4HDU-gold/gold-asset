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
    header("location:" . e_BASE . "index.php");
    exit;
}
include_lan(e_PLUGIN . "gold_asset/languages/" . e_LANGUAGE . "_goldasset.php");
require_once(e_ADMIN . "auth.php");
if (!defined("ADMIN_WIDTH"))
{
    define(ADMIN_WIDTH, "width:100%;");
}
require_once(e_HANDLER.'userclass_class.php');

$gasset_action = $_POST['gasset_action'];
$gasset_edit = false;
// * If we are updating then update or insert the record
if ($gasset_action == 'update')
{
    $gasset_id = $_POST['gasset_id'];
    if ($gasset_id == 0)
    {
        // New record so add it
        $gasset_args = "
		'0',
		'" . $tp->toDB($_POST['gasset_cat_name']) . "',
		'0'";
        if ($sql->db_Insert("gold_asset_cat", $gasset_args))
        {
            $gasset_msg .=  GOLD_ASSET_CAT18 ;
        }
        else
        {
            $gasset_msg .=  GOLD_ASSET_CAT17 ;
        }
    }
    else
    {
        // Update existing
        $gasset_args = "
		gasset_cat_name='" . $tp->toDB($_POST['gasset_cat_name']) . "'
		where gasset_cat_id='" . intval($gasset_id) . "'";
        if ($sql->db_Update("gold_asset_cat", $gasset_args))
        {
            // Changes saved
            $gasset_msg .=  GOLD_ASSET_CAT18 ;
        }
        else
        {
            $gasset_msg .=  GOLD_ASSET_CAT17;
        }
    }
}
// We are creating, editing or deleting a record
if ($gasset_action == 'dothings')
{
    $gasset_id = $_POST['gasset_selcat'];
    $gasset_do = $_POST['gasset_recdel'];
    $gasset_dodel = false;

    switch ($gasset_do)
    {
        case '1': // Edit existing record
            {
                // We edit the record
                $sql->db_Select("gold_asset_cat", "*", "gasset_cat_id='" . intval($gasset_id) . "'");
                $gasset_row = $sql->db_Fetch() ;
                extract($gasset_row);
                $gasset_cap1 = GOLD_ASSET_CAT13;
                $gasset_edit = true;
                break;
            }
        case '2': // New category
            {
                // Create new record
                $gasset_id = 0;
                // set all fields to zero/blank
                $gasset_cat_name = "";
                $gasset_category_description = "";
                $gasset_cap1 = GOLD_ASSET_CAT14;
                $gasset_edit = true;
                break;
            }
        case '3':
            {
                // delete the record
                if ($_POST['gasset_okdel'] == '1')
                {
                    $sql->db_Delete("gold_asset_cat", " gasset_cat_id='" . intval($gasset_id) . "'");

                    $gasset_msg .=  GOLD_ASSET_CAT15;
                }
                else
                {
                    $gasset_msg .=  GOLD_ASSET_CAT16 ;
                }
                $gasset_dodel = true;
                $gasset_edit = false;
            }
    }

    if (!$gasset_dodel)
    {
        $gasset_text .= "
<form id='deptformupdate' method='post' action='" . e_SELF . "'>
	<div>
		<input type='hidden' value='$gasset_id' name='gasset_id' />
		<input type='hidden' value='update' name='gasset_action' />
	</div>
	<table style='" . ADMIN_WIDTH . "' class='fborder'>
		<tr>
			<td colspan='2' class='fcaption'>$gasset_cap1</td>
		</tr>
		<tr>
			<td colspan='2' class='forumheader3'><b>{$gasset_msg}</b>&nbsp;</td>
		</tr>
		<tr>
			<td style='width:20%;vertical-align:top;' class='forumheader3'>" . GOLD_ASSET_CAT11 . "</td>
			<td  class='forumheader3'>
				<input type='text' class='tbox' name='gasset_cat_name' value='" . $tp->toFORM($gasset_cat_name) . "' />
			</td>
		</tr>
		<tr>
			<td colspan='2' class='forumheader2'><input type='submit' name='submits' value='" . GOLD_ASSET_CAT07 . "' class='tbox' /></td>
		</tr>
		<tr>
			<td colspan='2' class='fcaption'>&nbsp;</td>
		</tr>
	</table>
</form>";
    }
}
if (!$gasset_edit)
{
    // Get the category names to display in combo box
    // then display actions available
    $gasset_new = false;
    if ($sql->db_Select("gold_asset_cat", "gasset_cat_id,gasset_cat_name", " order by gasset_cat_name", "nowhere"))
    {
        $gasset_new = true;
        while ($gasset_row = $sql->db_Fetch())
        {
            extract($gasset_row);
            $gasset_catopt .= "<option value='$gasset_cat_id'" .
            ($gasset_id == $gasset_cat_id?" selected='selected'":"") . ">" . $tp->toFORM($gasset_cat_name) . "</option>";
        }
    }
    else
    {
        $gasset_catopt .= "<option value='0'>" . GOLD_ASSET_CAT10 . "</option>";
    }

    $gasset_text .= "
<form id='deptform' method='post' action='" . e_SELF . "'>
	<div>
		<input type='hidden' value='dothings' name='gasset_action' />
	</div>
	<table style='" . ADMIN_WIDTH . "' class='fborder'>
		<tr>
			<td colspan='2' class='fcaption'>" . GOLD_ASSET_CAT01 . "	</td>
		</tr>
		<tr>
			<td colspan='2' class='forumheader2'><b>" . $gasset_msg . "</b>&nbsp;</td>
		</tr>
		<tr>
			<td style='width:20%;' class='forumheader3'>" . GOLD_ASSET_CAT08 . "</td>
			<td  class='forumheader3'><select name='gasset_selcat' class='tbox'>$gasset_catopt</select></td>
		</tr>
		<tr>
			<td style='width:20%;' class='forumheader3'>" . GOLD_ASSET_CAT09 . "</td>
			<td  class='forumheader3'>
				<input type='radio' name='gasset_recdel' value='1' " . ($gasset_new?"checked='checked'":"disabled='disabled'") . " /> " . GOLD_ASSET_CAT02 . "<br />
				<input type='radio' name='gasset_recdel' value='2' " . (!$gasset_new?"checked='checked'":"") . " /> " . GOLD_ASSET_CAT03 . "<br />
				<input type='radio' name='gasset_recdel' value='3' /> " . GOLD_ASSET_CAT04 . "
				<input type='checkbox' name='gasset_okdel' value='1' />" . GOLD_ASSET_CAT05 . "
			</td>
		</tr>
		<tr>
			<td colspan='2' class='forumheader2'>
				<input type='submit' name='submits' value='" . GOLD_ASSET_CAT06 . "' class='tbox' />
			</td>
		</tr>
		<tr>
			<td colspan='2' class='fcaption'>&nbsp;</td>
		</tr>
	</table>
</form>";
}

$ns->tablerender(GOLD_ASSET_CAT01, $gasset_text,'gasset_cat');

require_once(e_ADMIN . 'footer.php');
