<?php

/*
 * GMO Ad Widget Class
 *
 * @since  0.1.0
 * @param  none
 */
class GMO_Ad_Widget extends WP_Widget {

private $ads;

function __construct()
{
    global $gmoadsmaster;
    $this->ads = $gmoadsmaster->get_option('gmoadsmaster_adcodes');

    parent::__construct(
        false,
        'GMO Ads Master',
        array(
            'description' => __(
                __('Insert Ad', 'gmoadsmaster'),
                'gmoadsmaster-widget'
            )
        ),
        array()
    );
}

public function form($par)
{
    $ad = (isset($par['ad']) && $par['ad']) ? $par['ad'] : '';
    $id = $this->get_field_id('ad');
    $name = $this->get_field_name('ad');

    echo '<p>';

    printf(
        '<select id="%s" name="%s">',
        esc_attr($id),
        esc_attr($name)
    );

    echo '<option value="">Please select advertisement.</option>';

    foreach ($this->ads as $key => $ad) {
        if (isset($ad['html']) && $ad['html']) {
            if (isset($ad['name']) && $ad['name']) {
                $name = $ad['name'];
            } else {
                $n = $key + 1;
                $name = __("Advertisement", "gmoadsmaster"). " ({$n})";
            }
            if (intval($ad) === intval($key)) {
                $selected = 'selected';
            } else {
                $selected = '';
            }
            printf(
                '<option value="%d" %s>%s</option>',
                intval($key),
                $selected,
                esc_html($name)
            );
        }
    }

    echo "</select>";
    echo '</p>';
}

public function update($new_instance, $old_instance)
{
    return $new_instance;
}

public function widget($args, $par)
{
    echo $args['before_widget'];
    $ad = $this->ads[$par['ad']]['html'];
    echo '<div class="gmoadsmaster-ad-wrap">';
    echo $ad;
    echo '</div>';
    echo $args['after_widget'];
}

} // GMO_Ad_Widget

// EOF
