<?php
    /**
     * Profile info box
     */
    elgg_load_js('endorsements-js');
    elgg_load_css('endorsements-css');
?>

<div class="profile elgg-col-3of3">
    <div class="elgg-inner clearfix">
        <?php echo elgg_view('profile/owner_block'); ?>
        <?php echo elgg_view('profile/details'); ?>
    </div>
    <div class="b_extended_profile">
        <?php echo elgg_view('b_extended_profile/aboutme'); ?>
        <?php echo elgg_view('b_extended_profile/education'); ?>
        <?php echo elgg_view('b_extended_profile/experience'); ?>
        <?php echo elgg_view('b_extended_profile/endorsements'); ?>
    </div>
</div>