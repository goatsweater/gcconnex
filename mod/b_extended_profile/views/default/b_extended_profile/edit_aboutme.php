<?php

//elgg_load_js('extended_tinymce');
//elgg_load_js('elgg.extended_tinymce');

if (elgg_is_xhr()) {  //This is an Ajax call!

    //$user_guid = $_GET["user"];
    $user_guid = $_GET["param"];
    $user = get_user($user_guid);

    $value = $user->description;

    $access_id = ACCESS_DEFAULT;

    $params = array(
        'name' => 'description',
        'value' => $value,
    );

    echo elgg_view("input/longtext", $params);

    $params = array(
        'name' => "accesslevel['description']",
        'value' => $access_id,
    );

    echo elgg_view('input/access', $params);
}

else {  // In case this view will be called via elgg_view()
    echo 'the other test';
}
?>

<script type="text/javascript">
    tinyMCE.init({
		mode : "textareas"
	});
</script>