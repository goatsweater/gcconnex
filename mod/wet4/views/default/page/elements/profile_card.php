<?php 
$site_url = elgg_get_site_url();
$user = get_loggedin_user()->username;
$displayName = get_loggedin_user()->name;
$user_avatar = get_loggedin_user()->geticonURL('medium');
$email = get_loggedin_user()->email;
?>


<div class="clearfix mrgn-bttm-sm">
    
    <div class="pull-left">
        <a href="<?php echo $site_url ?>profile/<?php echo $user ?>" title="<?php echo elgg_echo('userMenu:profile') ?>"><img class="mrgn-tp-md mrgn-lft-md" src="<?php echo $user_avatar?>" alt="<?php echo $displayName ?> Profile Picture"></a>
    </div>

    <div class="pull-left mrgn-lft-md">
        <h4><?php echo $displayName?></h4>
        <div><?php echo  $email ?></div>
        <div>Department</div>
        <a href="<?php echo  $site_url ?>profile/<?php echo  $user ?>" class="btn btn-default mrgn-tp-sm"><?php echo elgg_echo('userMenu:profile') ?></a>
    </div>
    
</div>

<div class="panel-footer clearfix">
    <a href="<?php echo  $site_url ?>settings" class="btn btn-default mrgn-tp-sm pull-left"><?php echo elgg_echo('userMenu:account') ?></a>
    <a href="<?php echo  $site_url ?>action/logout" class="btn btn-default mrgn-tp-sm pull-right"><?php echo elgg_echo('logout') ?></a>
</div>