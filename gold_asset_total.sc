
// Parameter 0 - userid
global $gold_sql,$post_info;
include_lan(e_PLUGIN . "gold_asset/languages/" . e_LANGUAGE . "_goldasset.php");
$tmp=explode(',',$parm);
$gasset_userid=intval($tmp[0]);
global $post_info;
if (e_PAGE == 'user.php')
{
    // if the page is the user display page then get the user's id
    $tmp = explode('.', e_QUERY);
    $gasset_userid = intval($tmp[1]);
}
if(e_PAGE=='forum_viewtopic.php')
{
	$gasset_userid=$post_info['user_id'];
}
$gasset_count=$gold_sql->db_Count('gold_asset','(*)','where gasset_user_id='.$gasset_userid,false);

return '<a href="'.e_PLUGIN.'gold_asset/viewassets.php?'.$gasset_userid.'">'. GOLD_ASSET_137.' '.intval($gasset_count).' '.GOLD_ASSET_138.'</a>';