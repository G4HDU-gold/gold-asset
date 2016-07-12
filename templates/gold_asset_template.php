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
if (!defined("USER_WIDTH"))
{
    define(USER_WIDTH, "width:100%;");
}
global $gold_asset_shortcodes;
// *********************************************************************************************************
// *
// *		Template for assets.php Shop page
// *
// *********************************************************************************************************
if (!isset($GOLD_ASSET_HEADER))
{
    $GOLD_ASSET_HEADER .= '
<table class="fborder" style="' . USER_WIDTH . '" >
		<tr>
			<td class="fcaption" colspan="2">' . GOLD_ASSET_O_01 . '</td>
		</tr>';
    if (defined('GASSET_LOGO'))
    {

        $GOLD_ASSET_HEADER .= '
		<tr>
			<td class="forumheader2" style="text-align:center;" colspan="2">
				<img src="' . GASSET_LOGO . '" alt="" style="border:0px" />
			</td>
		</tr>';
    }
    if(USER)
    {
     $GOLD_ASSET_HEADER .= '
		<tr>
			<td class="forumheader3" style="text-align:center;" colspan="2">'.GOLD_ASSET_122.'<br />{GOLD_ASSET=USERID,1,64}&nbsp;{GOLD_ASSET=USERID,2,64}&nbsp;{GOLD_ASSET=USERID,3,64}&nbsp;{GOLD_ASSET=USERID,4,64}&nbsp;{GOLD_ASSET=USERID,5,64}<br />
			{GOLD_ASSET_LIST=USER_ID,6,32,10}</td>
		</tr>';
		}
    $GOLD_ASSET_HEADER .= '
		<tr>
			<td class="forumheader2" colspan="2" style="text-align:center;" >' . GOLD_ASSET_105 . ' {GASSET_BALANCE}<br />
				{GASSET_MESSAGE}&nbsp;</td>';
				$GOLD_ASSET_HEADER .= '
		</tr>
	</table>';
}

if (!isset($GOLD_ASSET_FOOTER))
{
    $GOLD_ASSET_FOOTER .= '
	<table class="fborder" style="' . USER_WIDTH . '" >
		<tr>
			<td class="forumheader2" colspan="2">&nbsp;</td>
		</tr>
	</table>';
}

if (!isset($GOLD_ASSET_PRESENT))
{
    $GOLD_ASSET_PRESENT .= '
		<table style="width:100%;" >
			<tr>
				<td class="fcaption" colspan="3" onclick="gasset_expandit(\'{GASSET_PRESFOLDER}\')">{GASSET_FOLDER}{GASSET_16} {GASSET_TITLE}</td>
			</tr>
			<tr>
				<td class="forumheader3" style="text-align:center;width:30%;">{GASSET_IMAGE}</td>
				<td class="forumheader3" colspan="2"   >{GASSET_DESCRIPTION}</td>
			</tr>
			<tr>
				<td class="forumheader3" colspan="3" style="text-align:center;" >
				' . GOLD_ASSET_O_02 . ' <b>{GASSET_COST}</b> :&nbsp;&nbsp;
				' . GOLD_ASSET_104 . ' <b>{GASSET_CLASS}</b> :&nbsp;&nbsp;
				' . GOLD_ASSET_101 . ' {GASSET_BUTTON}</td>
			</tr>
		</table>';
}

if (!isset($GOLD_ASSET_MODHEADER))
{
    $GOLD_ASSET_MODHEADER .= '
<table class="fborder" style="' . USER_WIDTH . '" >
		<tr>
			<td class="fcaption" colspan="5">' . GOLD_ASSET_MOD06 . '</td>
		</tr>';
    if (defined('GASSET_LOGO'))
    {

        $GOLD_ASSET_MODHEADER .= '
		<tr>
			<td class="forumheader2" style="text-align:center;" colspan="5"><img src="' . GASSET_LOGO . '" alt="" style="border:0px" /></td>
		</tr>';
    }
        $GOLD_ASSET_MODHEADER .= '
		<tr>
			<td class="forumheader2" style="width:10%;text-align:center;" >' . GOLD_ASSET_MOD01 . '</td>
			<td class="forumheader2"  style="width:20%;text-align:left;">' . GOLD_ASSET_MOD02 . '</td>
			<td class="forumheader2"  style="width:20%;text-align:left;">' . GOLD_ASSET_MOD03 . '</td>
			<td class="forumheader2"  style="width:40%;text-align:left;">' . GOLD_ASSET_MOD04 . '</td>
			<td class="forumheader2" style="width:10%;text-align:center;" >' . GOLD_ASSET_MOD05 . '</td>
		</tr>';
}
if (!isset($GOLD_ASSET_MODDETAIL))
{
    $GOLD_ASSET_MODDETAIL .= '
		<tr>
			<td class="forumheader3" style="width:10%;text-align:center;vertical-align:top;" >{GASSET_ED_PIC}</td>
			<td class="forumheader3"  style="width:20%;text-align:left;vertical-align:top;">{GASSET_ED_FROM}</td>
			<td class="forumheader3"  style="width:20%;text-align:left;vertical-align:top;">{GASSET_ED_SENT}</td>
			<td class="forumheader3"  style="width:40%;text-align:left;vertical-align:top;"><span class="smalltext">{GASSET_ED_COMMENT}</span></td>
			<td class="forumheader3" style="width:10%;text-align:center;vertical-align:top;" >{GASSET_ED_DELETE}</td>
		</tr>';
}
if (!isset($GOLD_ASSET_MODFOOTER))
{
    $GOLD_ASSET_MODFOOTER .= '
    	<tr>
			<td class="forumheader2" colspan="5" style="text-align:right;">{GASSET_ED_SUBMIT}</td>
		</tr>
		<tr>
			<td class="fcaption" colspan="5">&nbsp</td>
		</tr>
</table>';
}

if (!isset($GOLD_ASSET_VIEWHEADER))
{
    $GOLD_ASSET_VIEWHEADER .= '
<table class="fborder" style="' . USER_WIDTH . '" >
		<tr>
			<td class="fcaption" colspan="3">' . GOLD_ASSET_MOD07 . '</td>
		</tr>';
    if (defined('GASSET_LOGO'))
    {

        $GOLD_ASSET_VIEWHEADER .= '
		<tr>
			<td class="forumheader2" style="text-align:center;" colspan="3">
				<img src="' . GASSET_LOGO . '" alt="" style="border:0px" />
			</td>
		</tr>';
    }
        $GOLD_ASSET_VIEWHEADER .= '
		<tr>
			<td class="forumheader3" style="text-align:center;" colspan="3">
				' . GOLD_ASSET_128 . ' {GASSET_OWNER}
			</td>
		</tr>
		<tr>
			<td class="forumheader2" style="width:20%;text-align:center;" >' . GOLD_ASSET_MOD01 . '</td>
			<td class="forumheader2"  style="width:30%;text-align:center;">' . GOLD_ASSET_140 . '</td>
			<td class="forumheader2"  style="width:50%;text-align:left;">' . GOLD_ASSET_139 . '</td>
		</tr>';
}
if (!isset($GOLD_ASSET_VIEWDETAIL))
{
    $GOLD_ASSET_VIEWDETAIL .= '
		<tr>
			<td class="forumheader3" style="width:20%;text-align:center;vertical-align:top;" >{GASSET_ED_PIC}</td>
			<td class="forumheader3"  style="width:30%;text-align:center;vertical-align:top;">{GASSET_ED_TITLE}</td>
			<td class="forumheader3"  style="width:50%;text-align:left;vertical-align:top;">{GASSET_ED_DESC}</td>
		</tr>';
}
if (!isset($GOLD_ASSET_VIEWFOOTER))
{
    $GOLD_ASSET_VIEWFOOTER .= '
		<tr>
			<td class="fcaption" colspan="3">&nbsp</td>
		</tr>
</table>';
}
