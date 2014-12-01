<?php

if (elgg_is_xhr()) {  //This is an Ajax call!

    //$user_guid = $_GET["user"];

    $user_guid = $_GET["guid"];
    $user = get_user($user_guid);

    $value = $user->description;

    $access_id = ACCESS_DEFAULT;

    $params = array(
        'name' => 'description',
        'class' => 'gcconnex-description',
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
    echo 'ERROR: Tell sys admin to grep for: AFJ367FAXB'; // random alphanumeric string to grep later if needed
}
?>

<script type="text/javascript">
    tinyMCE.init({
		mode : "textareas"
	});
</script>