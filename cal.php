<?php
/*
Plugin Name: Calendar Addition
Description: Adding the possibility to dynamically add new Events with a class
Author: Brandon Kroes
Version: 1.0
*/

add_action( 'admin_init', 'allInOneEventCheck' );
function allInOneEventCheck() {
    if ( is_admin() && current_user_can( 'activate_plugins' ) &&  !is_plugin_active( 'all-in-one-event-calendar/all-in-one-event-calendar.php' ) ) {
        add_action( 'admin_notices', 'childPluginNotice' );

        deactivate_plugins( plugin_basename( __FILE__ ) );

        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }
    }
}

function childPluginNotice()
{
    echo '<div class="error"><p>' . __('Sorry, All In One Event Calendar should be activated', 'cal') . '</p></div>';
}


