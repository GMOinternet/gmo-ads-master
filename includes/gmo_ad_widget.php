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
    $selected_ad = (isset($par['ad']) && $par['ad']) ? $par['ad'] : '';
    $selected_style = (isset($par['style']) && $par['style']) ? $par['style'] : '';
    $id = $this->get_field_id('ad');
    $style_id = $this->get_field_id('style');
    $name = $this->get_field_name('ad');
    $style_name = $this->get_field_name('style');

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
            if (intval($selected_ad) === intval($key)) {
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

    echo '<p>';

    printf(
        '<select id="%s" name="%s">',
        esc_attr($style_id),
        esc_attr($style_name)
    );

    foreach ($this->get_styles() as $key => $style) {
        if ($selected_style === $key) {
            $selected = 'selected';
        } else {
            $selected = '';
        }
        printf(
            '<option value="%s" %s>%s</option>',
            esc_attr($key),
            $selected,
            esc_html($key)
        );
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
    printf(
        '<div class="gmoadsmaster-ad-wrap" style="%s">',
        $this->get_styles($par['style'])
    );
    echo $ad;
    echo '</div>';
    echo $args['after_widget'];
}

private function get_styles($style = null)
{
    $styles = apply_filters(
        'gmoadsmaster_styles',
        array(
            'left'   => 'text-align: left;',
            'center' => 'text-align: center;',
            'right'  => 'text-align: right;',
        )
    );

    if ($style) {
        if (isset($styles[$style])) {
            return $styles[$style];
        } else {
            return 'text-align: left;';
        }
    } else {
       return $styles;
    }
}

} // GMO_Ad_Widget

// EOF
