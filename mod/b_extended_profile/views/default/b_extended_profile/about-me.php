<?php
elgg_load_js('extended_tinymce');
elgg_load_js('elgg.extended_tinymce');


    $user = elgg_get_page_owner_entity();
    $value = $user->description;

    echo '<div class="gcconnex-profile-aboutme-display">' . $value . '</div>';