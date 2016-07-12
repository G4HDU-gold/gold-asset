global $sql, $gasset, $PLUGINS_DIRECTORY,$tp;
// Parameter 1 - assetname
// parameter 2 - size (64,32,16 px)
$gasset_parmlist=explode(',',$parm);
include_lan(e_PLUGIN . "gold_asset/languages/" . e_LANGUAGE . "_goldasset.php");
if(empty($gasset_parmlist[0]))
{
	return;
}
else
{
	$gasset_asset=$gasset_parmlist[0];
}


switch(intval($gasset_parmlist[1]))
{
case 16:
	$gasset_icon='icon_16';
	break;
	case 64:
		$gasset_icon='icon_64';
	break;
	default:
			$gasset_icon='icon_32';
	break;
}

require_once(e_HANDLER.'date_handler.php');
$gasset_conv=new CONVERT;
#print $gasset_icon.'<br />';

	if(!empty($gasset_asset) && is_readable(e_PLUGIN.'gold_asset/assets/'.$gasset_asset.'/asset.php') )
	{
		require(e_PLUGIN.'gold_asset/assets/'.$gasset_asset.'/asset.php');
		$gasset_imagesrc=e_PLUGIN.'gold_asset/assets/'.$gasset_asset.'/'.$gasset[$gasset_asset][$gasset_icon];
		$gasset_title=htmlentities('<b>'.$tp->toJS($gasset[$gasset_asset]['title']).'</b><br />'.$tp->toJS($gasset[$gasset_asset]['description']));
		if ($gasset_userid==USERID)
		{
			// users looking at own
			$gasset_title.=htmlentities('<br /><br /><i>'.GOLD_ASSET_145.' '.$gasset_conv->convert_date($gasset_row['gasset_bought'],'short').'</i>');
		}

	return '<span class="tooltip_text"  onmouseover="showToolTip(event,\''.htmlentities($gasset_title).'\');return true" onmouseout="hideToolTip()"><img src="'.$gasset_imagesrc.'" style="border:0px" alt="'.$gasset[$gasset_asset]['title'].'" title="'.$gasset[$gasset_asset]['title'].'" />&nbsp;</span>';
	}
