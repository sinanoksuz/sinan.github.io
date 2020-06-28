<?php

/**
 * @package Ripple
 */
 
 require get_template_directory() . '/inc/ripple-faw-icons.php';
 
function ripple_widgets_show_widget_field($instance = '', $widget_field = '', $athm_field_value = '') {
    // Store Posts in array
    $ripple_postlist[0] = array(
        'value' => 0,
        'label' => esc_attr__('-- Choose --','ripple')
    );
    $arg = array('posts_per_page' => -1);
    $ripple_posts = get_posts($arg);
    foreach ($ripple_posts as $ripple_post) :
        $ripple_postlist[$ripple_post->ID] = array(
            'value' => $ripple_post->ID,
            'label' => $ripple_post->post_title
        );
    endforeach;

    extract($widget_field);

    switch ($ripple_widgets_field_type) {

        // Standard text field
        case 'text' :
            ?>
            <p>
                <label for="<?php echo esc_attr($instance->get_field_id($ripple_widgets_name)); ?>"><?php echo esc_html($ripple_widgets_title); ?>:</label>
                <input class="widefat" id="<?php echo esc_attr($instance->get_field_id($ripple_widgets_name)); ?>" name="<?php echo esc_attr($instance->get_field_name($ripple_widgets_name)); ?>" type="text" value="<?php echo esc_attr($athm_field_value); ?>" />

                <?php if (isset($ripple_widgets_description)) { ?>
                    <br />
                    <small><?php echo esc_html($ripple_widgets_description); ?></small>
                <?php } ?>
            </p>
            <?php
            break;

        // Standard url field
        case 'url' :
            ?>
            <p>
                <label for="<?php echo esc_attr($instance->get_field_id($ripple_widgets_name)); ?>"><?php echo esc_html($ripple_widgets_title); ?>:</label>
                <input class="widefat" id="<?php echo esc_attr($instance->get_field_id($ripple_widgets_name)); ?>" name="<?php echo esc_attr($instance->get_field_name($ripple_widgets_name)); ?>" type="text" value="<?php echo esc_attr($athm_field_value); ?>" />

                <?php if (isset($ripple_widgets_description)) { ?>
                    <br />
                    <small><?php echo esc_html($ripple_widgets_description); ?></small>
                <?php } ?>
            </p>
            <?php
            break;

        // Textarea field
        case 'textarea' :
            ?>
            <p>
                <label for="<?php echo esc_attr($instance->get_field_id($ripple_widgets_name)); ?>"><?php echo esc_html($ripple_widgets_title); ?>:</label>
                <textarea class="widefat" rows="<?php echo esc_attr($ripple_widgets_row); ?>" id="<?php echo esc_attr($instance->get_field_id($ripple_widgets_name)); ?>" name="<?php echo esc_attr($instance->get_field_name($ripple_widgets_name)); ?>"><?php echo wp_kses_post($athm_field_value); ?></textarea>
            </p>
            <?php
            break;

        // Checkbox field
        case 'checkbox' :
            ?>
            <p>
                <input id="<?php echo esc_attr($instance->get_field_id($ripple_widgets_name)); ?>" name="<?php echo esc_attr($instance->get_field_name($ripple_widgets_name)); ?>" type="checkbox" value="1" <?php checked('1', $athm_field_value); ?>/>
                <label for="<?php echo esc_attr($instance->get_field_id($ripple_widgets_name)); ?>"><?php echo esc_html($ripple_widgets_title); ?></label>

                <?php if (isset($ripple_widgets_description)) { ?>
                    <br />
                    <small><?php echo esc_html($ripple_widgets_description); ?></small>
                <?php } ?>
            </p>
            <?php
            break;

        case 'number' :
            ?>
            <p>
                <label for="<?php echo esc_attr($instance->get_field_id($ripple_widgets_name)); ?>"><?php echo esc_html($ripple_widgets_title); ?>:</label><br />
                <input name="<?php echo esc_attr($instance->get_field_name($ripple_widgets_name)); ?>" type="number" step="1" min="1" id="<?php echo esc_attr($instance->get_field_id($ripple_widgets_name)); ?>" value="<?php echo esc_attr($athm_field_value); ?>" class="small-text" />

                <?php if (isset($ripple_widgets_description)) { ?>
                    <br />
                    <small><?php echo esc_html($ripple_widgets_description); ?></small>
                <?php } ?>
            </p>
            <?php
            break;
    }
}

function ripple_widgets_updated_field_value($widget_field, $new_field_value) {

    extract($widget_field);

    // Allow only integers in number fields
    if ($ripple_widgets_field_type == 'number') {
        return absint($new_field_value);

        // Allow some tags in textareas
    } elseif ($ripple_widgets_field_type == 'textarea') {
        
        return wp_kses_post($new_field_value);

        // No allowed tags for all other fields
    } elseif ($ripple_widgets_field_type == 'url') {
        return esc_url_raw($new_field_value);
    } else {
        return sanitize_text_field($new_field_value);
    }
}


