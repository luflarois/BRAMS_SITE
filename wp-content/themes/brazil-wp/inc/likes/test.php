<?php
include_once '../../../../../wp-load.php';

$mylink = $wpdb->get_row("SELECT * FROM $wpdb->options  WHERE option_name = 'siteurl'", ARRAY_N);


var_dump($mylink);
?>