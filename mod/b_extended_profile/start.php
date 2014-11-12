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

    // Register the endorsements css library
    $css_url = 'mod/b_extended_profile/css/gcconnex-endorsements.css';
    elgg_register_css('endorsements-css', $css_url);
}

/*
function extended_profile_handler($page) {

    if (isset($page[0])) {
        $username = $page[0];
        $user = get_user_by_username($username);
        elgg_set_page_owner_guid($user->guid);
    } elseif (elgg_is_logged_in()) {
        forward(elgg_get_logged_in_user_entity()->getURL());
    }

    // short circuit if invalid or banned username
    if (!$user || ($user->isBanned() && !elgg_is_admin_logged_in())) {
        register_error(elgg_echo('profile:notfound'));
        forward();
    }

    $action = NULL;
    if (isset($page[1])) {
        $action = $page[1];
    }

    if ($action == 'edit') {
        // use the core profile edit page
        $base_dir = elgg_get_root_path();
        require "{$base_dir}pages/profile/edit.php";
        return true;
    }

    // main profile page
    $params = array(
        'content' => elgg_view('profile/wrapper'),
        'num_columns' => 3,
    );
    $content = elgg_view_layout('widgets', $params);

    $body = elgg_view_layout('one_column', array('content' => $content));
    echo elgg_view_page($user->name, $body);
    return true;
}*/