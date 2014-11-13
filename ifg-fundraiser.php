<?php
/**
 * @package IFG_FUNDRAISER
 * @version 1.0
 */
/*
Plugin Name: IF:Gathering Fundraiser
Plugin URI: http://ifgathering.com
Description: This plugin is a widget you can use to install on your site and display the fundraiser results
Author: Bryan Monzon
Version: 1.0
Author URI: http://fiftyandfifty.org
*/

// Plugin Folder URL
if ( ! defined( 'IFG_FUNDRAISER_PLUGIN_URL' ) )
  define( 'IFG_FUNDRAISER_PLUGIN_URL', plugin_dir_url( __FILE__ ) );


class IFG_FUNDRAISER_WIDGET extends WP_Widget 
{

    // constructor
    function ifg_fundraiser_widget() 
    {
        /* ... */
        parent::WP_Widget(false, $name = __('IF:Gathering Widget', 'ifg_fundraiser_widget') );
    }

    // widget form creation
    function form( $instance )
    {  
        /* ... */
        // Check values
        if( $instance ) {
             $title   = esc_attr( $instance['title'] );
        } else {
             $title   = '';
             
        }
        ?>
        <p><em>This widget is not responsive and requires the minimum width to be 350px</em></p>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'dntly'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>

        
        <p style="display:block; clear:both;"></p>


        

    <?php
    }

    // widget update
    function update( $new_instance, $old_instance )
    {
        /* ... */
        $instance = $old_instance;
             // Fields
            $instance['title']   = strip_tags( $new_instance['title'] );
      

            return $instance;
    }

    // widget display
    function widget( $args, $instance ) {
        /* ... */
        
        
        extract( $args );
        // these are the widget option
        $title   = apply_filters('widget_title', $instance['title']);


        echo $before_widget;
        // Display the widget
        echo '<div class="widget-text ifg_fundraiser">';

        // Check if title is set
        if ( $title ) {
            echo $before_title . $title . $after_title;
        }

        
        $script = '<script rel="ifg" src="'. IFG_FUNDRAISER_PLUGIN_URL .'assets/js/if-widget.min.js"></script>';
        echo $script;
    
     

        echo '</div>';
        echo $after_widget;

    }
}
// register widget
add_action('widgets_init', create_function('', 'return register_widget("ifg_fundraiser_widget");'));

function ifg_fundraiser_shortcode( $atts, $content=null )
{
    ob_start(); ?>
    <script rel="ifg" src="'. IFG_FUNDRAISER_PLUGIN_URL .'assets/js/if-widget.min.js"></script>
    <?php 
    return ob_get_clean();
}
add_shortcode( 'fundraiser_widget', 'ifg_fundraiser_shortcode' );