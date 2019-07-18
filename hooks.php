// Execute the action only if the user isn't logged in
if (!get_current_user_id()) {
    add_action('init', 'super_login_ajax_login_init');
}


function super_login_ajax_login_init(){
    // Enable the user with no privileges to run ajax_login() in AJAX
    add_action( 'wp_ajax_nopriv_superloginajaxlogin', 'super_login_form_ajax_login' );
}

function super_login_form_ajax_login(){

    // First check the nonce, if it fails the function will break
    check_ajax_referer( 'ajax-login-nonce', 'security' );

    // Nonce is checked, get the POST data and sign user on
    $info = array();
    $info['user_login'] = $_POST['log'];
    $info['user_password'] = $_POST['pwd'];
    $info['remember'] = true;


    $user_signon = wp_signon( $info, false );
    if ( is_wp_error($user_signon) ){
        echo json_encode(array('loggedin'=>false, 'message'=>__('Wrong username or password.')));
    } else {
        echo json_encode(array('loggedin'=>true, 'message'=>__('Login successful, redirecting...')));
    }

    die();
}



add_action('init','super_login_possibly_redirect');

function super_login_possibly_redirect(){
 global $pagenow;
 if( 'wp-login.php' == $pagenow && !isset( $_GET['action']) ) {
    wp_redirect('login');
    exit();
 }
}
