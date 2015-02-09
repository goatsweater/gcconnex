$(window).load(function() {
    $(".gcconnex-basic-profile-edit").fancybox({
        autoDimensions: false,
        width: '60%',
        height: '80%',
        onComplete : function(){ $.fancybox.resize();}
    })
});