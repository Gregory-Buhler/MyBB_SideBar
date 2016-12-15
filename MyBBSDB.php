<?php
// Only myBB can access this
if(!defined("IN_MYBB")) {
  die ("Dave, stop. Stop, will you? Stop, Dave. Will you stop Dave? Stop, Dave.<br><br>
  <span style='color:red; font-weight:bold; font-size: 2em;'>An error has occured, make sure IN_MYBB is defined. If this issue persists, please contact the developer at gregthedreamer@gmail.com.");
}

//Hooks
$plugins->add_hook('global_start', 'sidebar_global_start');

function sidebar_info(){
  return array(
    "name"              => "Sidebar",
    "description"       => "This plugin creates a sidebar for main forum index page, and inner forums.",
    "website"           => "gregBBplugs.tech",
    "author"            => "Gregory Buhler",
    "authorsite"        => "gregbwebdev.tech",
    "version"           => "0.0.1",
    "guid"              => "",
    "compatibility"     => "*",
  );
}

/**
  *
  *
  *
**/
function sidebar_activate() {
  global $db;

  $sidebar_group = array(
    'gid'             => 'NULL',
    'name'            => 'MyBBSDB',
    'title'           => 'Sidebar Plugin',
    'description'     => 'Sidebar plugin that inserts a sidebar on either the left/right/both side(s) of the forum.',
    'disporder'       => "1",
    'isdefault'       => "0",
  );

  $db->insert_query('settinggroups', $sidebar_group);
  $gid = $db->insert_id();

  $sidebar_setting = array(
      'sid'             => 'NULL',
      'name'            => 'sidebar_plugin_enable',
      'title'           => 'Enable the sidebar(s)?',
      'description'     => 'This will enable the sidebar plugin.',
      'optionscode'     => 'yesno',
      'value'           => '1',
      'disporder'       => 1,
      'gid'             => intval($gid),
  );

  $db->insert_query('settings', $sidebar_setting);
  rebuild_settings();
}

function sidebar_deactivate() {
  global $db;
  $db->query("DELETE FROM " . TABLE_PREFIX . "settings WHERE name IN ('sidebar_plugin_enable')");
  $db->query("DELETE FROM " . TABLE_PREFIX . "settinggroups WHERE name='sidebar'");
  rebuild_settings();
}

function sidebar_global_start(){
  global $mybb;

  if ($mybb->settings['sidebar_plugin_enable'] == 1) {
    echo "Sidebar plugin enabled! It Works! HOORAH";
  }
}
?>
