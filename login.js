

jQuery(document).ready(function($) {


    // Perform AJAX login on form submit
    $('form#login').on('submit', function(e){
        $('form#login p.status').show().text(super_loadingmessage);
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: super_ajaxurl,
            data: { 
                'action': 'superloginajaxlogin', //calls wp_ajax_nopriv_ajaxlogin
                'log': $('form#login #username').val(), 
                'pwd': $('form#login #password').val(), 
                'security': $('form#login #security').val() },
            success: function(data){
                $('form#login p.status').text(data.message);
                if (data.loggedin == true){
                    document.location.href = super_redirecturl;
                }
            }
        });
        e.preventDefault();
    });

});
