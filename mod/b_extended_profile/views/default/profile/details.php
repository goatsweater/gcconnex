<?php
/*
 * Author: Bryden Arndt
 * Date: 01/07/2015
 * Purpose: Display the profile details for the user profile in question.
 * Requires: gcconnex-profile.js should already be loaded at this point to handle edit/save/cancel toggles and other ajax requests related to profile sections
 * font-awesome css should be loaded already
 */


?>
<script>
    $(window).load(function() {
        $(".gcconnex-basic-profile-edit").fancybox({
            autoDimensions: false,
            width: '800',
            height: '580',
            onComplete : initFancyProfileBox
        })
    });
</script>
<?php

$user = elgg_get_page_owner_entity();

$profile_fields = elgg_get_config('profile_fields');

// display the username, title, phone, mobile, email, website
// fa classes are the font-awesome icons
echo '<div id="profile-details" class="elgg-body pll">';
echo '<div class="gcconnex-profile-name">';
echo '<h1><span>' . $user->name . '</span></h1>';

if ($user->canEdit()) {

    $content = elgg_view('output/url', array(
        'href' => 'ajax/view/b_extended_profile/edit_basic',
        'class' => 'elgg-lightbox gcconnex-basic-profile-edit elgg-button',
        'text' => elgg_echo('gcconnex_profile:edit_profile')
    ));

    echo $content;
}
if (elgg_get_page_owner_guid() != elgg_get_logged_in_user_guid()) {
    $menu = elgg_trigger_plugin_hook('register', "menu:user_hover", array('entity' => $user), array());
    $builder = new ElggMenuBuilder($menu);
    $menu = $builder->getMenu();
    $actions = elgg_extract('action', $menu, array());
    $admin = elgg_extract('admin', $menu, array());

    $profile_actions = '';
    if (elgg_is_logged_in() && $actions) {
        foreach ($actions as $action) {
            $profile_actions .= $action->getContent(array('class' => 'gcconnex-basic-profile-actions elgg-button'));
        }
    }
    echo $profile_actions;
}

echo '</div>'; // close div class="gcconnex-profile-name"
echo '<h3>' . $user->title . '</h3>';
echo '<div class="gcconnex-profile-dept">' . $user->department . '</div>';
echo '<div class="gcconnex-profile-contact-info">';

if ($user->phone != null) {
    echo '<img class="profile-icons profile-detail-icon" src="' . elgg_get_site_url() . 'mod/b_extended_profile/img/telephone.png">' . $user->phone . '<br>';
}

if ($user->mobile != null) {
    echo '<img class="profile-icons profile-detail-icon" src="' . elgg_get_site_url() . 'mod/b_extended_profile/img/mobile.png">' . $user->mobile . '<br>';
}

if ($user->email != null) {
    echo '<img class="profile-icons profile-detail-icon" src="' . elgg_get_site_url() . 'mod/b_extended_profile/img/envelope.png"><a href="mailto:' . $user->email . '">' . $user->email . '</a><br>';
}

if ($user->website != null) {
    echo '<img class="profile-icons profile-detail-icon" src="' . elgg_get_site_url() . 'mod/b_extended_profile/img/globe.png">';
    echo elgg_view('output/url', array(
        'href' => $user->website,
        'text' => $user->website
    ));
    echo '<br>';
}

echo '</div>'; // close div class="gcconnex-profile-contact-info"

// pre-populate the social media links that we may or may not display depending on whether the user has entered anything for each one..
$social = array('facebook', 'google', 'github', 'twitter', 'linkedin', 'pinterest', 'tumblr', 'instagram', 'flickr', 'youtube');

echo '<div class="gcconnex-profile-social-media-links">';
foreach ($social as $media) {

    if ($link = $user->get($media)) {
        if ($media == 'facebook') { $link = "http://www.facebook.com/" . $link; }
        if ($media == 'google') { $link = "http://plus.google.com/" . $link; }
        if ($media == 'github') { $link = "https://github.com/" . $link; }
        if ($media == 'twitter') { $link = "https://twitter.com/" . $link; }
        if ($media == 'linkedin') { $link = "http://ca.linkedin.com/in/" . $link; }
        if ($media == 'pinterest') { $link = "http://www.pinterest.com/" . $link; }
        if ($media == 'tumblr') { $link = "https://www.tumblr.com/blog/" . $link; }
        if ($media == 'instagram') { $link = "http://instagram.com/" . $link; }
        if ($media == 'flickr') { $link = "http://flickr.com/" . $link; }
        if ($media == 'youtube') { $link = "http://www.youtube.com/" . $link; }

        if ($media == 'google') { $media = 'google-plus'; } // the google font-awesome class is called "google-plus", so convert "google" to that..
        echo '<a href="' . $link . '" target="_blank"><img class="profile-icons social-media-icons" src="' . elgg_get_site_url() . 'mod/b_extended_profile/img/social-media/' . $media . '.png"></a>';
    }
}
echo '</div>'; // close div class="gcconnex-profile-social-media-links"








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
$content_menu_title = elgg_echo('gcconnex_profile:user_content');
$content_menu = elgg_view_menu('owner_block', array(
    'entity' => elgg_get_page_owner_entity(),
    'class' => 'profile-content-menu',
));

echo '</div>';

echo '<div class="b-user-menu"><div class="b-user-menu-title">' . $content_menu_title . '</div>' . $content_menu . '</div>';
echo '<div class="b-admin-menu">' . $admin_links . '</div>';
