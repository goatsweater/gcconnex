<?php
/**
 * Created by PhpStorm.
 * User: barndt
 * Date: 18/02/15
 * Time: 11:45 AM
 */
if (elgg_is_xhr()) {
    $user_guid = $_GET["colleague"];
    $user = get_user($user_guid);

    $icon = elgg_view_entity_icon($user, 'small', array(
        'use_hover' => true,
    ));

    echo $icon;
}
