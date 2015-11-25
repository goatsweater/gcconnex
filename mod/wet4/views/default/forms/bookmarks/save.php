<?php
/**
 * Edit / add a bookmark
 *
 * @package Bookmarks
 */

$title = elgg_extract('title', $vars, '');
$desc = elgg_extract('description', $vars, '');
$address = elgg_extract('address', $vars, '');
$tags = elgg_extract('tags', $vars, '');
$access_id = elgg_extract('access_id', $vars, ACCESS_DEFAULT);
$container_guid = elgg_extract('container_guid', $vars);
$guid = elgg_extract('guid', $vars, null);
$shares = elgg_extract('shares', $vars, array());

?>
<div class="mrgn-bttm-md">
	<label for="title"><?php echo elgg_echo('title'); ?></label><br />
	<?php echo elgg_view('input/text', array('name' => 'title', 'value' => $title, 'id' => 'title')); ?>
</div>
<div class="mrgn-bttm-md">
	<label for="address"><?php echo elgg_echo('bookmarks:address'); ?></label><br />
	<?php echo elgg_view('input/text', array('name' => 'address', 'value' => $address, 'id' =>'address')); ?>
</div>
<div class="mrgn-bttm-md">
	<label for="description"><?php echo elgg_echo('description'); ?></label>
	<?php echo elgg_view('input/longtext', array('name' => 'description', 'value' => $desc, 'id' => 'description')); ?>
</div>
<div class="mrgn-bttm-md">
	<label for="tags"><?php echo elgg_echo('tags'); ?></label>
	<?php echo elgg_view('input/tags', array('name' => 'tags', 'value' => $tags, 'id' => 'tags')); ?>
</div>
<?php

$categories = elgg_view('input/categories', $vars);
if ($categories) {
	echo $categories;
}

?>
<div class="mrgn-bttm-md">
	<label for="access_id"><?php echo elgg_echo('access'); ?></label><br />
	<?php echo elgg_view('input/access', array(
		'name' => 'access_id',
		'value' => $access_id,
        'id' => 'access_id',
		'entity' => get_entity($guid),
		'entity_type' => 'object',
		'entity_subtype' => 'bookmarks',
	)); ?>
</div>
<div class="elgg-foot">
<?php

echo elgg_view('input/hidden', array('name' => 'container_guid', 'value' => $container_guid));

if ($guid) {
	echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $guid));
}

echo elgg_view('input/submit', array('value' => 'Add Bookmark'));

?>
</div>