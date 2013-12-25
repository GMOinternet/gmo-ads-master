<?php

//if uninstall not called from WordPress exit
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}


$gmoadsmaster_options = array(
    'gmoadsmaster_verification',
    'gmoadsmaster_analytics',
    'gmoadsmaster_adcodes',
);

foreach ($gmoadsmaster_options as $op) {
    delete_option($op);
}

