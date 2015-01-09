<?php
/*
 * Author: Bryden Arndt
 * Date: 01/07/2015
 * Purpose: Display the profile details for the user profile in question.
 * Requires: gcconnex-profile.js should already be loaded at this point to handle edit/save/cancel toggles and other ajax requests related to profile sections
 * font-awesome css should be loaded already
 */

elgg_load_js('lightbox'); // overlay for editing the basic profile fields
elgg_load_css('lightbox'); // css for it..
elgg_load_js('basic-profile'); // load js file to init the lightbox overlay (sets the width)

$user = elgg_get_page_owner_entity();

$profile_fields = elgg_get_config('profile_fields');

// display the username, title, phone, mobile, email, website
// fa classes are the font-awesome icons
echo '<div id="profile-details" class="elgg-body pll">';
echo '<h1>' . $user->name . '</h1>';
echo '<h3>' . $user->title . '</h3><br>';
echo $user->department . '<br>';
echo '<i title="Telephone" class="fa fa-fw fa-phone"></i>' . $user->phone . '<br>';
echo '<i class="fa fa-fw fa-mobile-phone"></i>' . $user->mobile . '<br>';
echo '<i class="fa fa-fw fa-envelope"></i><a href="mailto:' . $user->email . '">' . $user->email . '</a><br>';
echo '<i class="fa fa-fw fa-globe"></i><a href=' . $user->website . '>' . $user->website . '</a><br><br>';

// pre-populate the social media links that we may or may not display depending on whether the user has entered anything for each one..
$social = array('facebook', 'google', 'github', 'twitter', 'linkedin', 'pinterest', 'tumblr', 'instagram', 'flickr', 'youtube');

foreach ($social as $media) {

    if ($link = $user->get($media)) {
        if ($media == 'google') { $media = 'google-plus'; } // the google font-awesome class is called "google-plus", so convert "google" to that..
        echo '<a href="' . $link . '"><i class="fa fa-fw fa-lg fa-' . $media . '"></i></a>';
    }
}


echo elgg_view("profile/status", array("entity" => $user));


if (elgg_get_logged_in_user_entity() == elgg_get_page_owner_entity()) {

    $content = elgg_view('output/url', array(
        'href' => 'ajax/view/b_extended_profile/edit_basic',
        'class' => 'elgg-lightbox iframe gcconnex-basic-profile-edit',
        'text' => 'Edit'
    ));

    echo $content;
}



$user = elgg_get_page_owner_entity();

// grab the actions and admin menu items from user hover
$menu = elgg_trigger_plugin_hook('register', "menu:user_hover", array('entity' => $user), array());
$builder = new ElggMenuBuilder($menu);
$menu = $builder->getMenu();
$actions = elgg_extract('action', $menu, array());
$admin = elgg_extract('admin', $menu, array());

$profile_actions = '';
if (elgg_is_logged_in() && $actions) {
    $profile_actions = '<ul class="elgg-menu profile-action-menu mvm">';
    foreach ($actions as $action) {
        $profile_actions .= '<li>' . $action->getContent(array('class' => 'elgg-button elgg-button-action')) . '</li>';
    }
    $profile_actions .= '</ul>';
}

// if admin, display admin links
$admin_links = '';
if (elgg_is_admin_logged_in() && elgg_get_logged_in_user_guid() != elgg_get_page_owner_guid()) {
    $text = elgg_echo('admin:options');

    $admin_links = '<ul class="profile-admin-menu-wrapper">';
    $admin_links .= "<li><a rel=\"toggle\" href=\"#profile-menu-admin\">$text&hellip;</a>";
    $admin_links .= '<ul class="profile-admin-menu" id="profile-menu-admin">';
    foreach ($admin as $menu_item) {
        $admin_links .= elgg_view('navigation/menu/elements/item', array('item' => $menu_item));
    }
    $admin_links .= '</ul>';
    $admin_links .= '</li>';
    $admin_links .= '</ul>';
}

// content links
$content_menu_title = "Personal Content";
$content_menu = elgg_view_menu('owner_block', array(
    'entity' => elgg_get_page_owner_entity(),
    'class' => 'profile-content-menu',
));

echo '</div>';

echo '<div class="b-user-menu">' . $content_menu_title . $content_menu . '</div>';
echo '<div class="b-user-menu2">' . $admin_links . '</div>';
