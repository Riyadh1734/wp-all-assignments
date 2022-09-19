<?php

namespace Riyadh1734\DevAcademy;

/**
 * Installer class
 */
class Installer
{

  /**
   * Run the installer
   *
   * @return void
   */
  public function run()
  {
    $this->add_version();
    $this->create_tables();
  }

  public function add_version()
  {
    $installed = get_option('dv_academy_installed');

    if (!$installed) {
      update_option('dv_academy_installed', time());
    }

    update_option('dv_academy_version', DV_ACADEMY_VERSION);
  }

  /**
   * Create database tables by given
   * 
   * @return void
   */
  public function create_tables()
  {
    global $wpdb;

    $charset_collate = $wpdb->get_charset_collate();

    $schema = "CREATE TABLE IF NOT EXISTS`{$wpdb->prefix}ac_addresses` (
            `id` int(15) NOT NULL AUTO_INCREMENT,
            `name` varchar(100) NOT NULL,
            `address` varchar(255) DEFAULT NULL,
            `phone` varchar(30) DEFAULT NULL,
            `created_by` bigint(20) unsigned NOT NULL,
            `created_at` datetime NOT NULL,
            PRIMARY Key(`id`)
          ) $charset_collate";

    if (!function_exists('dbDelta')) {
      require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    }
    dbDelta($schema);
  }
}
