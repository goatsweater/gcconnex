<?php
/**
 * Elgg user display (details)
 * @uses $vars['entity'] The user entity
 */

$user = elgg_get_page_owner_entity();

$profile_fields = elgg_get_config('profile_fields');

// username, title, phone, mobile, email, website
echo '<div id="profile-details" class="elgg-body pll">';
echo "<h1>{$user->name}</h1>";
echo '<h3>Consultant (false field)</h3><br>';
echo 'TBS-SCT (false field)<br>';
echo '<i class="fa fa-phone"></i>' . $user->phone . '<br>';
echo '<i class="fa fa-mobile-phone"></i>' . $user->mobile . '<br>';
echo '<i class="fa fa-envelope"></i>' . $user->email . '<br>';
echo '<i class="fa fa-globe"></i><a href=' . $user->website . ">{$user->website}</a><br><br>";

echo '<i class="fa fa-lg fa-facebook"></i>';
echo '<i class="fa fa-lg fa-google-plus"></i>';
echo '<i class="fa fa-lg fa-github"></i>';
echo '<i class="fa fa-lg fa-twitter"></i>';
echo '<i class="fa fa-lg fa-linkedin"></i>';
echo '<i class="fa fa-lg fa-pinterest"></i>';
echo '<i class="fa fa-lg fa-tumblr"></i>';
echo '<i class="fa fa-lg fa-instagram"></i>';
echo '<i class="fa fa-lg fa-flickr"></i>';
echo '<i class="fa fa-lg fa-youtube"></i>';


echo elgg_view("profile/status", array("entity" => $user));


/*
$even_odd = null;
if (is_array($profile_fields) && sizeof($profile_fields) > 0) {
    foreach ($profile_fields as $shortname => $valtype) {
        if ($shortname == "description") {
            // skip about me and put at bottom
            continue;
        }
        $value = $user->$shortname;

        if (!empty($value)) {

            // fix profile URLs populated by https://github.com/Elgg/Elgg/issues/5232
            // @todo Replace with upgrade script, only need to alter users with last_update after 1.8.13
            if ($valtype == 'url' && $value == 'http://') {
                $user->$shortname = '';
                continue;
            }

            // validate urls
            if ($valtype == 'url' && !preg_match('~^https?\://~i', $value)) {
                $value = "http://$value";
            }

            // this controls the alternating class
            $even_odd = ( 'odd' != $even_odd ) ? 'odd' : 'even';
            ?>
            <div class="<?php echo $even_odd; ?>">
                <b><?php echo elgg_echo("profile:{$shortname}"); ?>: </b>
                <?php
                echo elgg_view("output/{$valtype}", array('value' => $value));
                ?>
            </div>
        <?php
        }
    }
}


*/

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
$content_menu = elgg_view_menu('owner_block', array(
    'entity' => elgg_get_page_owner_entity(),
    'class' => 'profile-content-menu',
));

echo '</div>';
//echo '<div class="b-user-menu">' . $content_menu . '</div>';

