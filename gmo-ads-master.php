<?php
/**
 * Plugin Name: GMO Ads Master
 * Plugin URI:  https://digitalcube.jp/
 * Description: This is a awesome cool plugin.
 * Version:     0.1.0
 * Author:      Digitalcube Co,.Ltd
 * Author URI:  https://digitalcube.jp/
 * License:     GPLv2
 * Text Domain: gmoadsmaster
 * Domain Path: /languages
 */

/**
 * Copyright (c) 2013 Digitalcube Co,.Ltd (https://digitalcube.jp/)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2 or, at
 * your discretion, any later version, as published by the Free
 * Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */



define('GMOADSMASTER_URL',  plugins_url('', __FILE__));
define('GMOADSMASTER_PATH', dirname(__FILE__));

$gmoadsmaster = new GMOAdsMaster();
$gmoadsmaster->register();

class GMOAdsMaster {

private $version = '';
private $langs   = '';

function __construct()
{
    $data = get_file_data(
        __FILE__,
        array('ver' => 'Version', 'langs' => 'Domain Path')
    );
    $this->version = $data['ver'];
    $this->langs   = $data['langs'];
}

public function register()
{
    add_action('plugins_loaded', array($this, 'plugins_loaded'));
    add_action('wp_enqueue_scripts', array($this, 'wp_enqueue_scripts'));

    register_sidebar(array(
        'name'          => __('Before Contents', 'gmoadsmaster'),
        'id'            => 'before-contents',
        'description'   => '',
        'class'         => '',
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget'  => '</li>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>',
    ));

    register_sidebar(array(
        'name'          => __('After Contents', 'gmoadsmaster'),
        'id'            => 'after-contents',
        'description'   => '',
        'class'         => '',
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget'  => '</li>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>',
    ));
}

public function plugins_loaded()
{
    load_plugin_textdomain(
        'gmoadsmaster',
        false,
        dirname(plugin_basename(__FILE__)).$this->langs
    );

    add_action('admin_menu', array($this, 'admin_menu'));
}

public function admin_menu()
{
    add_options_page(
        __('GMO Ads Master', 'gmoadsmaster'),
        __('GMO Ads Master', 'gmoadsmaster'),
        'publish_posts',
        'gmoadsmaster',
        array($this, 'options_page')
    );
}

public function options_page()
{
?>
<div class="wrap">
<h2>GMO Ads Master</h2>

<h3>Stats Settings</h3>

<table class="form-table">
<tbody>
    <tr>
        <th><?php _e('Verification', 'gmoadsmaster'); ?></th>
        <td><input type="text" id="verification" name="verification" value="<?php echo get_option('gmoadsmaster_verification'); ?>" style="width:100%;"><br /><?php _e('Enter your meta key "content" value to verify your blog with <a href="https://www.google.com/webmasters/tools/home?hl=ja">Google Webmaster Tools</a>.', 'gmoadsmaster'); ?></td>
    </tr>
    <tr>
        <th><?php _e('Google Analytics Code', 'gmoadsmaster'); ?></th>
        <td><textarea style="width:100%;height:10em;"></textarea></td>
    </tr>
</tbody>
</table>

</div>
<?
}

Public function wp_enqueue_scripts()
{
    wp_enqueue_style(
        'gmo-ads-master-style',
        plugins_url('css/gmo-ads-master.min.css', __FILE__),
        array(),
        $this->version,
        'all'
    );

    wp_enqueue_script(
        'gmo-ads-master-script',
        plugins_url('js/gmo-ads-master.min.js', __FILE__),
        array('jquery'),
        $this->version,
        true
    );
}

} // end TestPlugin

// EOF
