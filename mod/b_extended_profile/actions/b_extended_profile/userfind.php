<?php
/*
 * Author: Bryden Arndt
 * Date: February 9, 2015
 * Purpose: Provide search results to usernames auto-suggest
 */


/*
  $user_entitities = elgg_get_entities(array(
    'types' => 'user',
    'callback' => 'my_get_entity_callback',
    'limit' => false,
));
*/

$users = fopen("usernames.json", "r");

$query = htmlspecialchars($_GET['query']);
$result = array();

foreach ($users as $u) {
    if (strpos(strtolower($u), strtolower($query)) !== FALSE) {
        $result[] = array('value' => $u);
    }
}

echo json_encode($result);

