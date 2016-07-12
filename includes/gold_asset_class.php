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
class gold_asset
{
    function gold_asset()
    {
        global $GOLD_ASSET_PREF, $pref, $tp, $gold_sql;
        // get all the details
        $this->load_prefs();
    }
    // ********************************************************************************************
    // *
    // * Gold Asset Load and Save prefs
    // *
    // ********************************************************************************************
    function getdefaultprefs()
    {
        global $GOLD_ASSET_PREF;

        $GOLD_ASSET_PREF = array('gasset_buyclass' => 0);
    }
    function save_prefs()
    {
        global $sql, $eArrayStorage, $GOLD_ASSET_PREF;
        // save preferences to database
        if (!is_object($sql))
        {
            $sql = new db;
        }
        $tmp = $eArrayStorage->WriteArray($GOLD_ASSET_PREF);
        $sql->db_Update('core', "e107_value='$tmp' where e107_name='gold_asset'", false);
        return ;
    }
    function load_prefs()
    {
        global $sql, $eArrayStorage, $GOLD_ASSET_PREF;
        // get preferences from database
        if (!is_object($sql))
        {
            $sql = new db;
        }
        $num_rows = $sql->db_Select('core', '*', "e107_name='gold_asset' ");
        $row = $sql->db_Fetch();

        if (empty($row['e107_value']))
        {
            // insert default preferences if none exist
            $this->getDefaultPrefs();
            $tmp = $eArrayStorage->WriteArray($GOLD_ASSET_PREF);
            $sql->db_Insert('core', "'gold_asset', '$tmp' ");
            $sql->db_Select('core', '*', "e107_name='gold_asset' ");
        }
        else
        {
            $GOLD_ASSET_PREF = $eArrayStorage->ReadArray($row['e107_value']);
        }
        return;
    }
    // ***************************************************************************
    // *
    // *	method 		: 	clear_cache($tags)
    // *
    // *	Parameters	:	$tags array of tags to clear
    // *
    // *	Returns		:
    // *
    // ***************************************************************************
    function clear_cache($tags)
    {
        global $e107cache;
        foreach($tags as $cache_tag)
        {
            $e107cache->clear($cache_tag);
        }
    }
    // ***************************************************************************
    // *
    // *	method 		: 	current_asset($gold_uid)
    // *
    // *	Parameters	:	$gold_uid id of user to write
    // *
    // *	Returns		:	name of the current asset for selected user
    // *
    // ***************************************************************************
    // ***************************************************************************
    // *
    // *	method 		: 	show_asset($uid, $uname)
    // *
    // *	Parameters	: 	$uid as integer for user
    // *				:	$uname as string for user name
    // *
    // *	Returns		:	username or the asseted name as a string
    // *				:
    // *
    // ***************************************************************************
    function show_asset($uid, $uname)
    {
        global $gold_obj;
        if (!array_key_exists($uid))
        {
            $gold_obj->load_gold($uid);
        }

        if ($gold_obj->gold_member[$uid]['gold_asset'] == '')
        {
            return $gold_obj->gold_member[$uid]['user_name'];
        }
        else
        {
            if (!file_exists(e_PLUGIN . 'gold_asset/wield/' . $uid . '.png'))
            {
                $gold_uname = $gold_obj->gold_member[$uid]['user_name'];
                // get the asset we are going to generate
                $gasset_location = $gold_obj->gold_member[$uid]['gold_asset'];
                // print $gasset_location;
                if (file_exists(e_PLUGIN . 'gold_asset/assets/' . $gasset_location . '/asset.php'))
                {
                    require_once(e_PLUGIN . 'gold_asset/assets/' . $gasset_location . '/asset.php');
                    $asset = $gasset[$gasset_location];
                    // print_a($asset);
                    $this->gen_asset($uid, $gold_uname, $asset);
                }
                else
                {
                    print 'missing asset at ' . $gasset_location;
                }
            }
            return "<img src='" . e_PLUGIN . "gold_asset/wield/{$uid}.png' id='gold{$uid}" . filemtime(e_PLUGIN . "gold_asset/wield/{$uid}.png") . "' style='border:0px;' title='" . $gold_uname . "' alt='asset " . $gold_uname . "' />";
        }
    }
    // ***************************************************************************
    // *
    // *	method 		: 	asset_exists($item)
    // *
    // *	Parameters	: 	$item as string for asset
    // *
    // *	Returns		:	true if user posesses
    // *				:	FALSE in not
    // *
    // ***************************************************************************
    function asset_exists($item)
    {
        global $gold_obj;
        global $gold_sql, $GOLD_ASSET_PREF;
        $gold_userid = USERID;
        if (!array_key_exists($gold_userid, $gold_obj->gold_member))
        {
            $this->load_gold($gold_userid);
        }
        $inv = $gold_obj->gold_member[$gold_userid]['gold_inv'];

        $asset_array = unserialize($inv);
        if (array_key_exists($item, $asset_array))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    // ***************************************************************************
    // *
    // *	method 		: 	buy_asset($item )
    // *
    // *	Parameters	: 	$item as string for asset Item's name
    // *
    // *	Returns		:	True if OK else false
    // *
    // ***************************************************************************
    function buy_asset($item)
    {
        global $sql, $tp;

        if (empty($item))
        {
            return false;
        }
        else
        {
            if ($sql->db_Insert('gold_asset', "
			0,
			" . USERID . ",
			'" . $tp->toDB($item) . "',
			'" . time() . "'
			", false))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }
    // ***************************************************************************
    // *
    // *	method 		: 	sell_asset($item )
    // *
    // *	Parameters	: 	$item as string for asset Item's name
    // *
    // *	Returns		:	True if OK else false
    // *
    // ***************************************************************************
    function sell_asset($item)
    {
        global $sql, $tp;

        if (empty($item))
        {
            return false;
        }
        else
        {
            if ($sql->db_Delete('gold_asset', "gasset_user_id= " . USERID . " and gasset_asset='" . $tp->toDB($item) . "'", false))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }
}
