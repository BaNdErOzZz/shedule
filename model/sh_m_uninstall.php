<?php
/**
 * Delete tables of database.
 * 
 * Delete tables during plugin deactivation
 * @package Shedule
 * @version 1.0.0
 */

global $wpdb;
/*
 * Delete tables if exists
 */
$wpdb->query('DROP TABLE IF EXISTS '.SHEDULE_PRFX.'sh_shedule, '.SHEDULE_PRFX.'sh_shedule_table ;');
?>
