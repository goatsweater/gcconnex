<?php
/**
 * Profile owner block
 */
?>
    <style>
        .c_table {
            border:1px solid #ccc;
            background-color:;
        }

        .table th,td {
            padding:10px;
        }

    </style>

<?php
$user = elgg_get_page_owner_entity();

if (!$user) {
    // no user so we quit view
    echo elgg_echo('viewfailure', array(__FILE__));
    return TRUE;
}

$icon = elgg_view_entity_icon($user, 'large', array(
    'use_hover' => false,
    'use_link' => false,
));



//$profile_actions
echo <<<HTML

<div id="profile-owner-block">
	$icon

	$admin_links
</div>

HTML;
