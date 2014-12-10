<?php
/**
 * Author: Bryden Arndt
 * Date: 11/5/14
 * Time: 3:45 PM
 */
elgg_register_event_handler('init', 'system', 'b_extended_profile_init');

function b_extended_profile_init() {
    // Register the endorsements js library
    $url = 'mod/b_extended_profile/js/endorsements/gcconnex-endorsements.js';
    //$url = elgg_get_simplecache_url('js', 'b_extended_profile/gcconnex-endorsements');
    elgg_register_js('endorsements-js', $url);

    // Register the gcconnex profile css libraries
    $css_url = 'mod/b_extended_profile/css/gcconnex-profile.css';
    elgg_register_css('gcconnex-css', $css_url);
    elgg_register_css('font-awesome', 'mod/b_extended_profile/vendors/font-awesome/css/font-awesome.min.css');

    // register ajax views
    elgg_register_ajax_view('b_extended_profile/about-me');
    elgg_register_ajax_view('b_extended_profile/education');
    elgg_register_ajax_view('b_extended_profile/work-experience');
    elgg_register_ajax_view('b_extended_profile/endorsements');

    elgg_register_ajax_view('b_extended_profile/edit_about-me');
    elgg_register_ajax_view('b_extended_profile/edit_education');
    elgg_register_ajax_view('b_extended_profile/edit_work-experience');

    elgg_register_ajax_view('b_extended_profile/edit_basic');

    // register, set, action!
    $action_path = elgg_get_plugins_path() . 'b_extended_profile/actions/b_extended_profile/';
    elgg_register_action('b_extended_profile/edit_profile', $action_path . 'edit_profile.php');
}