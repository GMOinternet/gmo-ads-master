<?php

//if uninstall not called from WordPress exit
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}


$gmoadsmaster_options = array(
    'gmoadsmaster-adcodes',
);

foreach ($gmoadsmaster_options as $op) {
    delete_option($op);
}

