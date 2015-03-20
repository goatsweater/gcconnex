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

    // Register vendor js libraries
    $url = 'mod/b_extended_profile/vendors/';
    elgg_register_js('typeahead', $url . 'typeahead/dist/typeahead.bundle.js'); // developer version typeahead js file !!! COMMENT THIS OuT AND ENABLE MINIFIED VERSIoN IN PRODcd
    elgg_register_js('fancybox', 'vendors/jquery/fancybox/jquery.fancybox-1.3.4.pack.js');
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
//    elgg_register_ajax_view('input/autoskill');

    elgg_register_ajax_view('b_extended_profile/edit_basic'); // ajax view for editing the basic profile fields like name, title, department, email, etc.

    // register the action for saving profile fields
    $action_path = elgg_get_plugins_path() . 'b_extended_profile/actions/b_extended_profile/';
    elgg_register_action('b_extended_profile/edit_profile', $action_path . 'edit_profile.php');
    elgg_register_action('b_extended_profile/add_endorsement', $action_path . 'add_endorsement.php');
    elgg_register_action('b_extended_profile/retract_endorsement', $action_path . 'retract_endorsement.php');
    elgg_register_action('b_extended_profile/user_find', $action_path . 'userfind.php', "public");

    //elgg_register_plugin_hook_handler('cron', 'hourly', 'userfind_updatelist');
    elgg_register_page_handler('userfind', 'userfind_page_handler');
}

/*
 * Purpose: return a list of usernames for user-suggest
 */
function userfind_page_handler() {

    //$user_friends = elgg_get_entities_from_relationship(array('guid' => elgg_get_logged_in_user_guid()));

    $user = elgg_get_logged_in_user_entity();
    $user_friends = get_user_friends(elgg_get_logged_in_user_guid());
    //error_log(var_dump($user_friends));


    $query = htmlspecialchars($_GET['query']);

    foreach ($user_friends as $u) {
        //error_log('Friend: ' . var_dump($friend));

        if (strpos(strtolower($u->get('name')), strtolower($query)) !== FALSE) {
            $result[] = array(
                'value' => $u->get('name'),
                'guid' => $u->get('guid'),
                'pic' => elgg_view_entity_icon($u, 'tiny', array(
                    'use_hover' => false,
                    'href' => false)),
                'avatar' => elgg_view_entity_icon($u, 'small', array(
                    'use_hover' => false,
                    'href' => false))
            );
            //error_log('Result: ' . var_dump($result));

        }
    }
    echo json_encode($result);
    return json_encode($result);
}

/*
 * Purpose: To list colleagues' avatars
 * Paramaters:
 * $guids = array of guids of avatars to be listed
 * $size = tiny, small, medium, large, etc.
 * $limit = max number of avatars to display
 * $class = css class for wrapper div
 */

function list_avatars($options) {

    $list = "";
    $list .= '<div class="list-avatars' . $options['class'] . '">';

    if ( $options['limit'] == 0 ) {
        $options['limit'] = 999;
    }
    else {
        $list .= '<div class="gcconnex-avatars-expand btn elgg-button">...</div>';
    }


    if ( $options['use_hover'] === null ) {
        $options['use_hover'] = true;
    }

    if ( $options['guids'] == null ) {
        return false;
    }
    else {
        if (!is_array($options['guids'])) {
            $options['guids'] = array($options['guids']);
        }

        $guids = $options['guids'];

        // display each avatar, up until the limit is reached
        for ( $i=0; $i<$options['limit']; $i++) {
            if( ($user = get_user($guids[$i])) == true ) {
                if ( $options['edit_mode'] == true ) {
                    $list .= '<div class="gcconnex-avatar-in-list" data-guid="' . $guids[$i] . '" onclick="removeColleague(this)">';
                    $list .= '<div class="remove-colleague-from-list">X';
                    $list .= '</div>'; // close div class="remove-colleague-from-list"

                    $list .= elgg_view_entity_icon($user, $options['size'], array(
                        'use_hover' => $options['use_hover'],
                        'href' => false
                    ));
                    $list .= '</div>'; // close div class="gcconnex-avatar-in-list"
                }
                else {
                    $list .= '<div class="gcconnex-avatar-in-list" data-guid="' . $guids[$i] . '">';
                    $list .= elgg_view_entity_icon($user, $options['size'], array(
                        'use_hover' => $options['use_hover'],
                    ));
                    $list .= '</div>'; // close div class="gcconnex-avatar-in-list"
                }
            }
            else {
                break;
            }
        }
    }

    $list .= '</div>'; // close div class="list-avatars"
    return $list;
}

/*
 * Purpose: To sort education and work experience entities by their start date.. called before cmpEndYear so that the list is ordered by both start and end dates.
 */
function cmpStartDate($foo, $bar)
{
    $a = get_entity($foo);
    $b = get_entity($bar);

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
function sortDate($foo, $bar)
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
            return (cmpStartDate($a, $b));
        }
        else if ($a->endyear > $b->endyear) {
            return (-1);
        }
        else if ($a->endyear < $b->endyear) {
            return (1);
        }
    }
}

function userfind_updatelist() {

    $user_entitites = elgg_get_entities(array(
            'types' => 'user',
            'limit' => false,
        ));

    $username = array();

    foreach($user_entitites as $ue) {
        $username[$ue->name] = $ue->guid;
    }
    $fp = fopen(elgg_get_plugins_path() . 'b_extended_profile/actions/b_extended_profile/usernames.json', 'w');
    fwrite($fp, json_encode($username));
    fclose($fp);

}
