<?php
/**
 * WP Reset
 * https://wpreset.com/
 * (c) WebFactory Ltd, 2017-2018
 */


// include only file
if (!defined('ABSPATH')) {
	wp_die(__('Do not open this file directly.', 'wp-error'));
}


/**
 * Resets the site to the default values without modifying any files.
 */
class WP_Reset_CLI extends WP_CLI_Command {

    /**
     * Reset the site database to default values. No files are modified.
     *
     * ## OPTIONS
     * 
     * [--reactivate-theme]
     * : Reactivate currently active theme after reset.
     * 
     * [--reactivate-plugins]
     * : Reactivate all currently active plugins after reset.
     * 
     * [--deactivate-wp-reset]
     * : Deactivate WP Reset plugin after reset. By default it will stay active after reset.
     * 
     * [--yes]
     * : Answer yes to the confirmation message.
     *
     * ## EXAMPLES
     *
     * $ wp reset reset --yes
     * Success: Database has been reset.
     *
     * @when after_wp_load
     */
    function reset( $args, $assoc_args ) {
      WP_CLI::confirm( 'Are you sure you want to reset the site? There is NO UNDO!', $assoc_args );
      
      global $wp_reset;
      $params = array();

      if ( !empty( $assoc_args['reactivate-theme'] ) ) {
        $params['reactivate_theme'] = true;
      }
      if ( !empty( $assoc_args['disable-wp-reset'] ) ) {
        $params['reactivate_wpreset'] = false;
      } else {
        $params['reactivate_wpreset'] = true;
      }
      if ( !empty( $assoc_args['reactivate-plugins'] ) ) {
        $params['reactivate_plugins'] = true;
      }

      $result = $wp_reset->do_reinstall( $params );
      if (is_wp_error($result)) {
        WP_CLI::error( $result->get_error_message );
      } else {
        WP_CLI::success( 'Database has been reset.' );
      }
    } // reset


    /**
     * Display WP Reset version.
     * 
     * @when after_wp_load
     */
    function version( $args, $assoc_args ) {
      global $wp_reset;
      
      WP_CLI::line( 'WP Reset v' . $wp_reset->version );
    } // version


    /**
     * Delete selected WordPress objects.
     * 
     * ## OPTIONS
     * 
     * <plugins|themes|transients|uploads>
     * : WP objects to delete.
     * 
     * [--yes]
     * : Answer yes to the confirmation message.
     * 
     * ## EXAMPLES
     *
     * $ wp reset delete themes --yes
     * Success: 3 themes have been deleted.
     * 
     * @when after_wp_load
     */
    function delete( $args, $assoc_args ) {
      global $wp_reset;
      
      if ( empty( $args[0] ) ) {
        WP_CLI::error( 'Please choose a subcommand: plugins, themes, transients or uploads.' );
        return;
      } elseif ( false == in_array( $args[0], array( 'themes', 'plugins', 'transients', 'uploads' ) ) ) {
        WP_CLI::error( 'Unknown subcommand. Please choose from: plugins, themes, transients or uploads.' );
      } else {
        $subcommand = $args[0];
      }

      switch ($subcommand) {
        case 'themes':
          WP_CLI::confirm( 'Are you sure you want to delete all themes?', $assoc_args );
          $cnt = $wp_reset->do_delete_themes( false );
          WP_CLI::success( $cnt . ' themes have been deleted.' );
        break;
        case 'plugins':
          WP_CLI::confirm( 'Are you sure you want to delete all plugins?', $assoc_args );
          $cnt = $wp_reset->do_delete_plugins( true, false );
          WP_CLI::success( $cnt . ' plugins have been deleted.' );
        break;
        case 'transients':
          WP_CLI::confirm( 'Are you sure you want to delete all transients?', $assoc_args );
          $cnt = $wp_reset->do_delete_transients();
          WP_CLI::success( $cnt . ' transient database entries have been deleted.' );
        break;
        case 'uploads':
          WP_CLI::confirm( 'Are you sure you want to delete all files & folders in /uploads/ folder?', $assoc_args );
          $cnt = $wp_reset->do_delete_uploads();
          WP_CLI::success( $cnt . ' files & folders have been deleted.' );
        break;
        default:
          // should never come to this but can't hurt
          WP_CLI::error( 'Unknown subcommand. Please choose from: plugins, themes, transients or uploads.' );
          return;
      }
    } // delete
} // WP_Reset_CLI

WP_CLI::add_command( 'reset', 'WP_Reset_CLI' );
