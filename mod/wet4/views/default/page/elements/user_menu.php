<?php
/**
 * User Menu
 * Access profile/messages/colleagues/settings
 */
/*
// Elgg logo
echo elgg_view_menu('topbar', array('sort_by' => 'priority', array('elgg-menu-hz')));

// elgg tools menu
// need to echo this empty view for backward compatibility.
echo elgg_view_deprecated("navigation/topbar_tools", array(), "Extend the topbar menus or the page/elements/topbar view directly", 1.8);
*/

$site_url = elgg_get_site_url();
$user = get_loggedin_user()->username;
$displayName = get_loggedin_user()->name;
$user_avatar = get_loggedin_user()->geticonURL('medium');
$email = get_loggedin_user()->email;

//create dropdown menu
/*
elgg_register_menu_item('user_menu_subMenu', array(
    'name' => 'Dashboard',
    'href' => 'dashboard',
    'text' => 'Dashboard',
    'title' => 'My Dashboard',
    'class' => 'brdr-bttm',
    ));

elgg_register_menu_item('user_menu_subMenu', array(
    'name' => 'Account Settings',
    'href' => 'settings',
    'text' => 'Account Settings',
    'title' => 'Account Settings',
    'class' => 'brdr-bttm mrgn-bttm-sm',
    ));

elgg_register_menu_item('user_menu_subMenu', array(
    'name' => 'Log out',
    'href' => $site_url . 'action/logout',
    'text' => 'Log out',
    'title' => 'Log out',
    ));
*/
elgg_register_menu_item('user_menu_subMenu', array(
    'name' => 'profile_card',
    
    'text' => elgg_view('page/elements/profile_card'),
    ));

$dropdown = elgg_view_menu('user_menu_subMenu', array('class' => 'dropdown-menu user-menu pull-right subMenu'));




//admin link
//check to see if user is an admin
if(elgg_is_admin_logged_in()){
    elgg_register_menu_item('user_menu', array(
        'name' => 'Admin',
        'href' => $site_url . 'admin',
        'text' => '<i class="fa fa-wrench fa-lg mrgn-rght-sm"></i>' . 'Admin',
        'title' => 'Admin',
        'item_class' => 'brdr-rght',
        'class' => '',
        'priority' => '0',
        ));
}


//create initial badge

$breakup = explode('.', $email);
$initials = substr($breakup[0], 0, 1) . substr($breakup[1], 0, 1);

//create user menu
elgg_register_menu_item('user_menu', array(
    'name' => 'Profile',
    'text' => '<span class="init-badge">' . strtoupper($initials) . '</span>' . $displayName . $dropdown,
    'title' => elgg_echo('userMenu:profile'),
    'item_class' => 'brdr-lft dropdown',
    'data-toggle' => 'dropdown',
    'class' => 'dropdown-toggle  dropdownToggle',
    'priority' => '3',
    ));




//display new message badge on messages
if(elgg_is_active_plugin('messages')){
    $unread = messages_count_unread();
    
    $msgbadge = "<span class='notif-badge'>" . $unread . "</span>";
    
    $title = ' - ' . $unread . ' ' . elgg_echo('messages:unreadmessages');
    
    if($unread == 0){
        $msgbadge = '';
        $title = '';
    }
} 
elgg_register_menu_item('user_menu', array(
    'name' => 'messages',
    'href' => 'messages/inbox/' . $user,
    'text' => '<i class="fa fa-envelope mrgn-rght-sm mrgn-tp-sm fa-lg"></i>' . elgg_echo('messages') . $msgbadge,
    'title' => elgg_echo('userMenu:messages') . $title,
    'item_class' => 'brdr-lft ',
    'class' => '',
    'priority' => '2',
    ));


/*

Colleague menu item runs in start.php - sorry

elgg_register_menu_item('user_menu', array(
    'name' => 'Colleagues',
    'href' => 'friends/' . $user,
    'text' => 'Colleagues',
    'title' => 'My Colleagues',
    'item_class' => 'brdr-rght',
    'class' => 'friend-icon',
    'priority' => '3',
    ));*/
/*
elgg_register_menu_item('user_menu', array(
    'name' => elgg_echo('user_menu:settings'),

    'text' => 'Settings<b class="caret"></b>' . $dropdown,
    'title' => 'My Settings Menu',
    'item_class' => 'dropdown',
    'data-toggle' => 'dropdown',
    'class' => ' dropdown-toggle settings-icon dropdownToggle',
    'priority' => '1',
    ));
*/


echo elgg_view_menu('user_menu', array('sort_by' => 'priority', 'id' => 'userMenu', 'class' => 'list-inline visited-link'));
?>

