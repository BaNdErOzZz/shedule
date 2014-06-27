<?php
/**
 * Generate tables of database.
 * 
 * Creates tables during plugin activation
 * @package Shedule
 * @version 1.0.0
 */

/**
 *Inclding global varialble $wpdb; 
 */
global $wpdb;

/*
 * Creates a table for storing schedules
 */
$wpdb->query("CREATE TABLE ".SHEDULE_PRFX."sh_shedule (
  id int(7) NOT NULL AUTO_INCREMENT,
  title varchar(255) DEFAULT NULL,
  title_tooltip text DEFAULT NULL,
  title_link text DEFAULT NULL,
  description text DEFAULT NULL,
  event_time time DEFAULT NULL,
  event_date date NOT NULL,
  labels text DEFAULT NULL,
  settings text DEFAULT NULL,
  post_id int(7) DEFAULT NULL,
  shedule_table_id int(7) NOT NULL,
  date_create datetime NOT NULL,
  date_update datetime NOT NULL,
  PRIMARY KEY (id)
)
ENGINE = INNODB
AUTO_INCREMENT = 1;");

/*
 * Creates a table for storing calendars
 */
$wpdb->query("CREATE TABLE IF NOT EXISTS ".SHEDULE_PRFX."sh_shedule_table(
id INT(7) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
title TEXT NOT NULL, 
description TEXT NULL, 
labels text DEFAULT NULL,
shortcode VARCHAR(255) NOT NULL, 
date_time_begin DATETIME NOT NULL, 
date_time_end DATETIME NOT NULL,
date_create DATETIME NOT NULL,
date_update DATETIME NOT NULL
);");

?>
