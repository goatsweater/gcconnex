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
$publication_guid = $user->publications;

if ($publication_guid == NULL || empty($publication_guid)) {
    echo elgg_echo('gcconnex_profile:publications:empty');
}
else {
    if (!(is_array($publication_guid))) {
        $publication_guid = array($publication_guid);
    }
}


if (is_array($publication_guid)) {

    foreach ($publication_guid as $guid) {

        $publication = get_entity($guid);

        echo '<div class="gcconnex-profile-publication-display gcconnex-publication-' . $publication->guid . '">';
        echo '<div class="gcconnex-profile-label publication-pubdate">' . $publication->pubdate . '</div>';
        echo '<div class="gcconnex-profile-label publication-description">' . $publication->description . '</div>';
        echo '<div class="gcconnex-profile-label publication-link"><ul><li>' . $publication->link . '</li></ul></div>';
        echo '</div>';
    }
}
