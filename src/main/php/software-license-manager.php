<?php
/*
Plugin Name: @plugin.name@
Version: @plugin.build_version@-@build.number@
Plugin URI: @plugin.github_repo@
Author: Michel Velis
Author URI: http://www.epikly.com/
Description: Software license management solution for your web applications (WordPress plugins, Themes, Applications, PHP based license software script etc.). Supports WooCommerce.
Author2: <a href="https://www.tipsandtricks-hq.com/">Tips and Tricks HQ</a>
Text Domain: softwarelicensemanager
Domain Path: /i18n/languages/
WC tested up to: @plugin.wp_version_tested@
*/

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die();
}
global $wpdb, $slm_debug_logger;


//Short name/slug "SLM" or "slm"
define('SLM_VERSION',               '@plugin.build_version@-@build.number@');
define('SLM_GITHUB_LINK',             '@plugin.github_repo@');
define('SLM_DB_VERSION',            '4.3.5');
define('SLM_REWRITE_VERSION',       '2.4.5');
define('SLM_FOLDER',                dirname(plugin_basename(__FILE__)));
define('SLM_URL',                   plugins_url('', __FILE__));
define('SLM_ASSETS_URL',            SLM_URL   . '/public/assets/');
define('SLM_PATH',                  plugin_dir_path(__FILE__));
define('SLM_LIB',                   SLM_PATH  . 'includes/');
define('SLM_WOO',                   SLM_PATH  . 'woocommerce/');
define('SLM_ADDONS',                SLM_PATH  . 'addons/');
define('SLM_ADMIN',                 SLM_PATH  . 'admin/');
define('SLM_ADMIN_ADDONS',          SLM_ADMIN . 'includes/');
define('SLM_CRONS',                 SLM_ADMIN_ADDONS . 'cronjobs/');
define('SLM_PUBLIC',                SLM_PATH  . 'public/');
define('SLM_TEAMPLATES',            SLM_PATH  . 'templates/');
define('SLM_SITE_HOME_URL',         get_home_url());
define('SLM_SITE_URL',              get_site_url() . '/');
define('SLM_TBL_LICENSE_KEYS',      $wpdb->prefix . "lic_key_tbl");
define('SLM_TBL_EMAILS',            $wpdb->prefix . "lic_emails_tbl");
define('SLM_TBL_LIC_DOMAIN',        $wpdb->prefix . "lic_reg_domain_tbl");
define('SLM_TBL_LIC_DEVICES',       $wpdb->prefix . "lic_reg_devices_tbl");
define('SLM_TBL_LIC_LOG',           $wpdb->prefix . "lic_log_tbl");
define('SLM_MANAGEMENT_PERMISSION', 'manage_options');
define('SLM_MAIN_MENU_SLUG',        'slm_overview');
define('SLM_MENU_ICON',             'dashicons-lock');


if (file_exists(SLM_LIB .  'slm-plugin-core.php')) {
    include_once SLM_LIB . 'slm-plugin-core.php';
}

// Options and filters
define('WOO_SLM_API_SECRET',    SLM_Helper_Class::slm_get_option('lic_creation_secret'));
define('KEY_API',               SLM_Helper_Class::slm_get_option('lic_creation_secret'));
define('KEY_API_PREFIX',        SLM_Helper_Class::slm_get_option('lic_prefix'));

add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'slm_settings_link');
$updaterEnabled = false;
if (file_exists(SLM_FOLDER.'/plugin-update-checker/plugin-update-checker.php')) {
    require SLM_FOLDER.'/plugin-update-checker/plugin-update-checker.php';
    $updaterEnabled = true;
} else {
    $slm_debug_logger->log_debug("Updater is disabled - could not find file: ".SLM_FOLDER.'/plugin-update-checker/plugin-update-checker.php',4,true);
}
// plugin auto updater helper
if ($updaterEnabled) {
    $myUpdateChecker = YahnisElsts\PluginUpdateChecker\v5\PucFactory::buildUpdateChecker(SLM_GITHUB_LINK . "/releases/latest/download/info.json",__FILE__);
    //$api = new YahnisElsts\PluginUpdateChecker\v5p1\Vcs\GitHubApi(SLM_GITHUB_LINK . "/releases/latest/download/info.json");
    //$api->enableReleaseAssets();
    //$myUpdateChecker = new YahnisElsts\PluginUpdateChecker\v5p1\Vcs\PluginUpdateChecker($api, __FILE__, '/@plugin.slug@', 12);
}
