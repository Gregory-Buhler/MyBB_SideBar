<?php
// Only myBB can access this
if(!defined("IN_MYBB")) {
  die ("Dave, stop. Stop, will you? Stop, Dave. Will you stop Dave? Stop, Dave.<br><br>
  <span style='color:red; font-weight:bold; font-size: 2em;'>An error has occured, make sure IN_MYBB is defined. If this issue persists, please contact the developer at gregthedreamer@gmail.com.");
}

//Hooks
$plugins->add_hook('global_start', 'MyBB_SideBar_global_start');

function MyBB_SideBar_info(){
  return array(
    "name"              => "MyBB_SideBar",
    "description"       => "This plugin creates a MyBB_SideBar for main forum index page, and inner forums.",
    "website"           => "gregBBplugs.tech",
    "author"            => "Gregory Buhler",
    "authorsite"        => "gregbwebdev.tech",
    "version"           => "0.0.1",
    "guid"              => "",
    "compatibility"     => "*",
  );
}

function MyBB_SideBar_is_installed() {
  global $db;
  $query = $db->write_query("SELECT COUNT(*) as count FROM " . TABLE_PREFIX . "settinggroups WHERE name='MyBB_SideBar'");
  $count = $db->fetch_field($query, "count");
  if($count == 1) {
    return true;
  }
};

function MyBB_SideBar_install() {
  global $db;

  $MyBB_SideBar_group = array(
    'gid'             => 'NULL',
    'name'            => 'MyBB_SideBar',
    'title'           => 'MyBB_SideBar Plugin',
    'description'     => 'MyBB_SideBar plugin that inserts a MyBB_SideBar on either the left/right/both side(s) of the forum.',
    'disporder'       => "1",
    'isdefault'       => "0",
  );

  $db->insert_query('settinggroups', $MyBB_SideBar_group);
  $gid = $db->insert_id();

  $MyBB_SideBar_setting = array(
      'sid'             => 'NULL',
      'name'            => 'MyBB_SideBar_plugin_enable',
      'title'           => 'Enable the MyBB_SideBar(s)?',
      'description'     => 'This will enable the MyBB_SideBar plugin.',
      'optionscode'     => 'yesno',
      'value'           => '1',
      'disporder'       => 1,
      'gid'             => intval($gid),
  );

  $db->insert_query('settings', $MyBB_SideBar_setting);

  $MyBB_Sidebar_setting_side = array(
    'sid'             => 'NULL',
    'name'            => 'MyBB_SideBar_plugin_side',
    'title'           => 'Which side for the SideBar?',
    'description'     => 'This option chooses which side the sidebar shows on.',
    'optionscode'     => 'select \n 1=Right \n 2=Left \n 3=Both',
    'value'           => '1',
    'disporder'       => 2,
    'gid'             => intval($gid),
  );

  $db->insert_query('settings', $MyBB_Sidebar_setting_side);
  rebuild_settings();

  //Add stylesheet to the master template so it becomes inherited.
  $stylesheet = file_get_contents(MYBB_ROOT."inc/plugins/MyBB_SideBar/MyBB_SideBar.css");
  $MyBB_SideBar_stylesheet= array(
    "name"        => "MyBB_SideBar.css",
    "tid"         => 1,
    "stylesheet"  => $db->escape_string($stylesheet),
    "cachefile"   => $db->escape_string(str_replace('/', '', MyBB_SideBar.css)),
    "lastmodified" => TIME_NOW
  );
  require_once MYBB_ADMIN_DIR."inc/functions_themes.php";
  $sid = $db->insert_query("themestylesheets", $MyBB_SideBar_stylesheet);
  $db->update_query('themestylesheets', array("cachefile" => "css.php?stylesheet=".$sid), "sid = '".$sid."'", 1);
  $tids = $db->simple_select("themes", "tid");
  while($theme = $db->fetch_array($tids))
  {
    update_theme_stylesheet_list($theme['tid']);
  }
}


function MyBB_SideBar_activate() {
  $mybb->settings['MyBB_SideBar_plugin_enable'] = 1;
}

function MyBB_SideBar_deactivate() {
  $mybb->settings['MyBB_SideBar_plugin_enable'] = 0;
}

function MyBB_SideBar_uninstall() {
  global $db;

  $db->query("DELETE FROM " . TABLE_PREFIX . "settings WHERE name IN ('MyBB_SideBar_plugin_enable')");
  $db->query("DELETE FROM " . TABLE_PREFIX . "settings WHERE name IN ('MyBB_SideBar_plugin_side')");
  $db->query("DELETE FROM " . TABLE_PREFIX . "settinggroups WHERE name='MyBB_SideBar'");
  rebuild_settings();

  // Remove MyBB_SideBar.css from the theme cache directories if it exists.
  require_once MYBB_ADMIN_DIR."inc/functions_themes.php";
  $db->delete_query("themestylesheets", "name = 'MyBB_SideBar.css'");
  $query = $db->simple_select("themes", "tid");
  while($theme = $db->fetch_array($query))
  {
    update_theme_stylesheet_list($theme['tid']);
  }
}

function MyBB_SideBar_global_start(){
  global $mybb;

  if ($mybb->settings['MyBB_SideBar_plugin_enable'] == 1) {
    echo "MyBB_SideBar plugin enabled! It Works! HOORAH";
    include 'MyBB_SideBar/forum_resize.js';
    echo "<script type='text/javascript'>
      addMainDiv(" . $mybb->settings['MyBB_SideBar_plugin_side'] . ");
      </script>";
  }
}
?>
