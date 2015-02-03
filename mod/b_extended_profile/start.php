<?php
/**
 * Author: Bryden Arndt
 * Date: 11/5/14
 * Time: 3:45 PM
 * Purpose: initializes the b_extended_profile plugin.
 *
 * Notes: See views/default/profile/wrapper.php for information on adding a new section to the user profile
 */
elgg_register_event_handler('init', 'system', 'b_extended_profile_init');

function b_extended_profile_init() {
    // Register the endorsements js library
    $url = 'mod/b_extended_profile/js/endorsements/';
    elgg_register_js('gcconnex-profile', $url . "gcconnex-profile.js"); // js file containing code for edit, save, cancel toggles and the events that they trigger, plus more
    elgg_register_js('basic-profile', $url . "basic-profile.js"); // js file containing fancybox initialization mainly to override width of the overlay

    // Register vendor js libraries
    $url = 'mod/b_extended_profile/vendors/';
    elgg_register_js('typeahead', $url . 'typeahead/dist/typeahead.bundle.js'); // developer version typeahead js file !!! COMMENT THIS OuT AND ENABLE MINIFIED VERSIoN IN PRODcd
    // elgg_register_js('typeahead', $url . 'typeahead/dist/typeahead.bundle.min.js'); // minified typeahead js file


    // Register the gcconnex profile css libraries
    $css_url = 'mod/b_extended_profile/css/gcconnex-profile.css';
    elgg_register_css('gcconnex-css', $css_url);
    elgg_register_css('font-awesome', 'mod/b_extended_profile/vendors/font-awesome/css/font-awesome.min.css'); // font-awesome icons used for social media and some profile fields

    // register ajax views for all profile sections that are allowed to be edited and displayed via ajax

    // display views
    // see views/default/profile/wrapper.php for information on adding a new section to the user profile
    elgg_register_ajax_view('b_extended_profile/about-me');
    elgg_register_ajax_view('b_extended_profile/education');
    elgg_register_ajax_view('b_extended_profile/work-experience');
    elgg_register_ajax_view('b_extended_profile/endorsements');

    // edit views
    elgg_register_ajax_view('b_extended_profile/edit_about-me');
    elgg_register_ajax_view('b_extended_profile/edit_education');
    elgg_register_ajax_view('b_extended_profile/edit_work-experience');

    // input views
    elgg_register_ajax_view('input/education');
    elgg_register_ajax_view('input/work-experience');

    // auto-complete
    elgg_register_ajax_view('input/autoskill');

    elgg_register_ajax_view('b_extended_profile/edit_basic'); // ajax view for editing the basic profile fields like name, title, department, email, etc.

    // register the action for saving profile fields
    $action_path = elgg_get_plugins_path() . 'b_extended_profile/actions/b_extended_profile/';
    elgg_register_action('b_extended_profile/edit_profile', $action_path . 'edit_profile.php');
    elgg_register_action('b_extended_profile/add_endorsement', $action_path . 'add_endorsement.php');
    elgg_register_action('b_extended_profile/retract_endorsement', $action_path . 'retract_endorsement.php');

}

/*
 * Purpose: To sort education and work experience entities by their start date.. called before cmpEndYear so that the list is ordered by both start and end dates.
 */
function cmpStartDate($foo, $bar)
{
    $a = get_entity($foo);
    $b = get_entity($bar);
error_log("hi mom");
    if ($a->startyear == $b->startyear) {
        return (0);
    }
    else if ($a->startyear > $b->startyear) {
        error_log($a->startyear . " is more than " . $b->startyear);
        return (-1);
    }
    else if ($a->startyear < $b->startyear) {
        error_log($a->startyear . " is less than " . $b->startyear);
        return (1);
    }
}

/*
 * Purpose: To sort education and work experience entities by their end date.. called after cmpStartYear so that the list is ordered by both start and end dates.
 */
function cmpEndDate($foo, $bar)
{

    $a = get_entity($foo);
    $b = get_entity($bar);

    if ($a->ongoing == "true" && $b->ongoing == "true") {
        return (0);
    }
    else if ($a->ongoing == "true" && $b->ongoing != "true") {
        return (-1);
    }
    else if ($a->ongoing != "true" && $b->ongoing == "true") {
        return (1);
    }
    else {
        if ($a->endyear == $b->endyear) {
            // @todo: sort by enddate entry (months, saved as strings..)
            return (0);
        }
        else if ($a->endyear > $b->endyear) {
            return (-1);
        }
        else if ($a->endyear < $b->endyear) {
            return (1);
        }
    }
}

