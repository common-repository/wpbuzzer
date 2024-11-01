<?php
/*
Plugin Name: WPBuzzer
Plugin URI: http://hameedullah.com/wordpress/wpbuzzer
Description: Adds a button to Buzz your blog posts
Version: 0.9.1
Author: Hameedullah Khan
Author URI: http://hameedullah.com
*/

/*  Copyright 2010  Hameedullah Khan  (email : h@hameedullah.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// display button on all posts and pages
function wpbuzzer_get_button($content) {
    $location = get_option('wpbuzzer-location');
    $showposts = get_option('wpbuzzer-showposts');
    $showpages = get_option('wpbuzzer-showpages');
    $showhome = get_option('wpbuzzer-showhome');

    // return the content without changing if we can't display the button
    if (is_home() && !$showhome) {
       return $content;
    }
    if (is_single() && !$showposts) {
       return $content;
    }
    if (is_page() && !$showpages) {
       return $content;
    }

    $button_code = wpbuzzer_create_button();
    if ($location == 'before') {
        $content = $button_code. $content;
    } else {
        $content = $content . $button_code;
    }
    return $content;
}

function wpbuzzer_create_button($css=null, $size=null, $show_count=null) {
    global $post;

    $post_id = $post->ID;

    // get the post url
    $url = '';
    if (get_post_status($post_id) == 'publish') {
        $permalink = $url = get_permalink($post_id);
    } 

    // get the css
    if ($css===null) $css = get_option('wpbuzzer-css');

    // get the size
    if ($size===null) $size = get_option('wpbuzzer-size');

    // show share count
    if ($show_count===null) $show_count = get_option('wpbuzzer-showcount');


    if ($size == "big") {
        if ($show_count) $button_style = "normal-count";
        else $button_style = "normal-button";
 
    } else {
        if ($show_count) $button_style = "small-count";
        else $button_style = "small-button";
    }

    if ( function_exists('has_post_thumbnail') && has_post_thumbnail() )  {
       $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'medium', false, '' );
       $thumbnail_url = $thumbnail[0];
    } else {
       $thumbnail_url = "";
    }

    $anchor_tag = '<a title="Post on Google Buzz" class="google-buzz-button" href="http://www.google.com/buzz/post" data-button-style="'.$button_style.'" data-url="'.$url.'" data-imageurl="'.$thumbnail_url.'"></a><script type="text/javascript" src="http://www.google.com/buzz/api/button.js"></script>';
    $code = '<div class="wpbuzzer_button" style="' . $css . '">'. $anchor_tag .'</div>';
    return $code;
}

function wpbuzzer($css=null, $size=null, $show_count=null) {
    echo wpbuzzer_create_button($css, $size, $show_count);
}



function wpbuzzer_settings_page() {
?>
    <div class="wrap">
    <h2>WPBuzzer Settings</h2>
    <form method="post" action="options.php">
    <?php
        if (function_exists('settings_field')) {
            settings_field("wpbuzzer-options");
        } else { 
            wp_nonce_field('update-options'); 
        }
    ?>
    <?php
     echo get_option('wpbuzzer-location');
    ?>
    <table class="form-table">
    <tr valign="top">
      <th scope="row">Show On</th>
      <td><input type="checkbox" name="wpbuzzer-showposts" value="1" <?php if (get_option('wpbuzzer-showposts') == '1') { ?>checked="checked"<?php } ?>/>Posts
          <input type="checkbox" name="wpbuzzer-showpages" value="1" <?php if (get_option('wpbuzzer-showpages') == '1') { ?>checked="checked"<?php } ?>/>Pages
          <input type="checkbox" name="wpbuzzer-showhome" value="1" <?php if (get_option('wpbuzzer-showhome') == '1') { ?>checked="checked"<?php } ?>/>Home
      </td>
    <tr valign="top">
      <th scope="row">Location</th>
      <td><input type="radio" name="wpbuzzer-location" value="before" <?php if (get_option('wpbuzzer-location') == 'before') { ?>checked="checked"<?php } ?>/>Before
          <input type="radio" name="wpbuzzer-location" value="after" <?php if (get_option('wpbuzzer-location') == 'after') { ?>checked="checked"<?php } ?>/>After</td>
    </tr>

    <tr valign="top">
      <th scope="row">CSS Style</th>
      <td><input type="text" name="wpbuzzer-css" value="<?php echo get_option('wpbuzzer-css'); ?>" /></td>
    </tr>
    <tr valign="top">
      <th scope="row">Size</th>
      <td><select name="wpbuzzer-size">
          <option value="big" <?php if (get_option('wpbuzzer-size') == 'big') { ?>selected="selected"<?php } ?>>Large</option>
          <option value="small" <?php if (get_option('wpbuzzer-size') == 'small') { ?>selected="selected"<?php }?>>Small</option>
          </select>
      </td>
    </tr>
    <tr valign="top">
      <th scope="row">Show Share Counts</th>
      <td>
          <input type="checkbox" name="wpbuzzer-showcount" value="1" <?php if (get_option('wpbuzzer-showcount') == '1' && get_option('wpbuzzer-showcount') && get_option('wpbuzzer-showcount')) { ?>checked="checked"<?php } ?>/>show share count
      </td>
    </tr>

   </div>
    </table>
    <input type="hidden" name="action" value="update" />
    <input type="hidden" name="page_options" value="wpbuzzer-location,wpbuzzer-showposts,wpbuzzer-showpages,wpbuzzer-showhome,wpbuzzer-showfeed,wpbuzzer-css,wpbuzzer-size,wpbuzzer-showcount" />
    <p class="submit">
    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>
    </form>
    </div>


<?
}


function wpbuzzer_activate() {
    add_option('wpbuzzer-location', 'before');
    add_option('wpbuzzer-css', 'float: right');
    add_option('wpbuzzer-size', 'big');
    add_option('wpbuzzer-showposts', 1);
    add_option('wpbuzzer-showpages', 1);
    add_option('wpbuzzer-showhome', 1);
    add_option('wpbuzzer-showcount', 1);
}

function wpbuzzer_register_settings() {
    if (function_exists('register_settings')) {
        register_settings('wpbuzzer-options', 'wpbuzzer-location');
        register_settings('wpbuzzer-options', 'wpbuzzer-css');
        register_settings('wpbuzzer-options', 'wpbuzzer-size');
        register_settings('wpbuzzer-options', 'wpbuzzer-showposts');
        register_settings('wpbuzzer-options', 'wpbuzzer-showpages');
        register_settings('wpbuzzer-options', 'wpbuzzer-showhome');
        register_settings('wpbuzzer-options', 'wpbuzzer-showcount');
    }
}

/* add the settings page */
function wpbuzzer_menu() {
    if (function_exists('add_options_page')) {
        add_options_page('WPBuzzer', 'WPBuzzer', 'administrator', basename(__FILE__), 'wpbuzzer_settings_page');
    }
}


if ( is_admin() ){ // admin actions
    add_action( 'admin_init', 'wpbuzzer_register_settings' );
    add_action( 'admin_menu', 'wpbuzzer_menu' );
} 

add_filter('the_content', 'wpbuzzer_get_button', 100);

register_activation_hook( __FILE__, 'wpbuzzer_activate');
?>
