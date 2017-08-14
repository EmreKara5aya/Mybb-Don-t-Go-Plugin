<?php

/* 
			@Emre Karakaya
			@www.emrekarakaya.com.tr
*/

if (!defined("IN_MYBB")) {
	die("Direct initialization of this file is not allowed.<br /><br />Please make sure IN_MYBB is defined.<br />Mybb Dışı Bağlanmak Yasaktır.");
}
$plugins->add_hook("global_start", "dontgo_degisken");
function dontgo_info()
{
	 global $lang;
     $lang->load("dontgo");
// Eklentiyi Tanıtıyoruz
	return array(
	'name' => $lang->eklentiad ,
	'description' => $lang->eklentiac ,
	'website' => "https://www.emrekarakaya.com.tr" ,
	'author' => "Emre Karakaya" ,
	'authorsite' => "https://www.emrekarakaya.com.tr" ,
	'version' => "1.0" ,
	'guid' => "" , 
	'compatibility' => "18*",
);
}
function dontgo_activate()
{
	global $mybb, $db, $lang;
	$lang->load("dontgo");
	$ayar_group = array(
        'name'         => 'dontgo_ayarlari',
        'title'        => $lang->aygrtitle,
        'description'  => $lang->aygrdes,
        'disporder'    => '1',
    );
    $db->insert_query('settinggroups', $ayar_group);
    $ayar_grup_id = $db->insert_id();

	$ayar1 = array(
        'name'         => 'dontgomesaj',
        'title'        => $lang->dontgomesajtit,
        'description'  => $lang->dontgomesajdes,
        'optionscode'  => 'text',
        'value'        => $lang->dontgomesaj,
        'disporder'    => '1',
        'gid'          => intval( $ayar_grup_id )
    );
    $db->insert_query("settings", $ayar1);
    	$ayar2 = array(
        'name'         => 'dontgofav',
        'title'        => $lang->dontgofavtit,
        'description'  => $lang->dontgofavdes,
        'optionscode'  => 'text',
        'value'        => 'images/favicon.ico',
        'disporder'    => '2',
        'gid'          => intval( $ayar_grup_id )
    );
    $db->insert_query("settings", $ayar2);
        	$ayar3 = array(
        'name'         => 'dontgoza',
        'title'        => $lang->dontgozatit,
        'description'  => $lang->dontgozades,
        'optionscode'  => 'text',
        'value'        => '5',
        'disporder'    => '3',
        'gid'          => intval( $ayar_grup_id )
    );
    $db->insert_query("settings", $ayar3);
require_once MYBB_ROOT."/inc/adminfunctions_templates.php";
    find_replace_templatesets("headerinclude", "#".preg_quote("{\$stylesheets}")."#i", "{\$stylesheets}\n{\$dontgo}");
}
function dontgo_deactivate()
{
	global $mybb, $db;
	$db->query("DELETE FROM ".TABLE_PREFIX."settinggroups WHERE name='dontgo_ayarlari'");
	$db->query("DELETE FROM ".TABLE_PREFIX."settings WHERE name='dontgomesaj'");
	$db->query("DELETE FROM ".TABLE_PREFIX."settings WHERE name='dontgofav'");
	$db->query("DELETE FROM ".TABLE_PREFIX."settings WHERE name='dontgoza'");
	rebuild_settings();
	     require_once MYBB_ROOT."/inc/adminfunctions_templates.php";
    find_replace_templatesets("headerinclude", "#".preg_quote("{\$dontgo}")."#i", "", 0);
}
function dontgo_degisken()
{
	global $mybb, $db, $time, $dontgo;
	$time = $mybb->settings['dontgoza'] * 1000;
	$dontgo = "<script type=\"text/javascript\" src=\"{$mybb->asset_url}/jscripts/dont-go.min.js\"></script>
	<script>
      dontGo({
        title: \"{$mybb->settings['dontgomesaj']}\",
        faviconSrc: \"{$mybb->settings['dontgofav']}\",
        timeout: 2000
      })
    </script>";
}
?>