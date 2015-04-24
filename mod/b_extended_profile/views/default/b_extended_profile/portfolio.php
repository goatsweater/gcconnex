<?php
/**
 * Created by PhpStorm.
 * User: barndt
 * Date: 23/03/15
 * Time: 2:02 PM
 */

if (elgg_is_xhr()) {
    $user_guid = $_GET["guid"];
}
else {
    $user_guid = elgg_get_page_owner_guid();
}

$user = get_user($user_guid);
$portfolio_guid = $user->portfolio;

if ($portfolio_guid == NULL || empty($portfolio_guid)) {
    echo elgg_echo('gcconnex_profile:portfolio:empty');
}
else {
    if (!(is_array($portfolio_guid))) {
        $portfolio_guid = array($portfolio_guid);
    }
}


if (is_array($portfolio_guid)) {

    foreach ($portfolio_guid as $guid) {

        $entry = get_entity($guid);

        echo '<div class="gcconnex-profile-publication-display gcconnex-publication-' . $entry->guid . '">';
        echo '<div class="gcconnex-profile-label publication-pubdate">' . $entry->pubdate . '</div>';
        echo '<div class="gcconnex-profile-label publication-description">' . $entry->description . '</div>';
        echo '<div class="gcconnex-profile-label publication-link"><ul><li>' . $entry->link . '</li></ul></div>';
        echo '</div>';
    }
}

echo '</div>'; // close div class="gcconnex-profile-section-wrapper gcconnex-portfolio
