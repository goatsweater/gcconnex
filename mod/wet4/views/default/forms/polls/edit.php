<?php
$poll = elgg_extract('entity', $vars);
if ($poll) {
	$guid = $poll->guid;
} else  {
	$guid = 0;
}

$question = $vars['fd']['question'];
$tags = $vars['fd']['tags'];
$access_id = $vars['fd']['access_id'];

$question_label = elgg_echo('polls:question');
$question_textbox = elgg_view('input/text', array('name' => 'question', 'id' => 'question', 'value' => $question));

$responses_label = elgg_echo('polls:responses');
$responses_control = elgg_view('polls/input/choices',array('poll'=>$poll));

$tag_label = elgg_echo('tags');
$tag_input = elgg_view('input/tags', array('name' => 'tags', 'id' => 'tags', 'value' => $tags));

$access_label = elgg_echo('access');
$access_input = elgg_view('input/access', array('name' => 'access_id', 'id' => 'access_id', 'value' => $access_id));

$submit_input = elgg_view('input/submit', array('name' => 'submit', 'value' => elgg_echo('save')));
$submit_input .= ' '.elgg_view('input/button', array('name' => 'cancel', 'id' => 'polls_edit_cancel', 'type'=> 'button', 'value' => elgg_echo('cancel')));

if (isset($vars['entity'])) {
	$entity_hidden = elgg_view('input/hidden', array('name' => 'guid', 'value' => $guid));
} else {
	$entity_hidden = '';
}

$entity_hidden .= elgg_view('input/hidden', array('name' => 'container_guid', 'value' => elgg_get_page_owner_guid()));

echo <<<__HTML
		<p>
			<label for="question">$question_label</label><br />
			$question_textbox
		</p>
		<p>
			<label>$responses_label</label><br />
			$responses_control
		</p>
		<p>
			<label for="tags">$tag_label</label><br />
			$tag_input
		</p>
		<p>
			<label for="access_id">$access_label</label><br />
			$access_input
		</p>
		<p>
		$entity_hidden
		$submit_input
		</p>
__HTML;

		// TODO - move this JS
		?>
<div></div>
<script type="text/javascript">
$('#polls_edit_cancel').click(
	function() {
		window.location.href="<?php echo $vars['url'].'pg/polls/list/'.(elgg_get_page_owner_entity()->username); ?>";
	}
);
</script>
