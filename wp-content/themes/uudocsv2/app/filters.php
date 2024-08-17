<?php

/**
 * Theme filters.
 */

namespace App;

/**
 * Cleanup excerpt.
 *
 * @return string
 */
add_filter(
    'excerpt_more',
    function () {
        return sprintf('&hellip;');
    }
);

/**
 *  Excerpt length.
 *
 * @return string
 */
add_filter(
    'excerpt_length',
    function ($lenght) {
        return 20;
    }
);

/**
 *  Excerpt replace keywords.
 *
 * @return string
 */
add_filter(
    'the_excerpt',
    function ($text) {
        $replace = array(
            // 'WORD TO REPLACE' => 'REPLACE WORD WITH THIS'
            'What\'s Changed?'      => '',
            'What’s Changed?'        => '',
            'What&#8217;s Changed?' => ''
        );
        $text = str_replace(array_keys($replace), $replace, $text);
        return $text;
    }, 40
);

add_filter(
    'get_the_excerpt',
    function ($text) {
        $replace = array(
            // 'WORD TO REPLACE' => 'REPLACE WORD WITH THIS'
            'What\'s Changed?'      => '',
            'What’s Changed?'        => '',
            'What&#8217;s Changed?' => ''
        );
        $text = str_replace(array_keys($replace), $replace, $text);
        return $text;
    }, 40
);

/**
 * Disable Gutenberg on the back end.
 *
 * @return boolean
 */
add_filter(
    'use_block_editor_for_post',
    function () {
        return false;
    },
);

/**
 * Disable Gutenberg for widgets.
 *
 * @return boolean
 */
add_filter(
    'use_widgets_blog_editor',
    function () {
        return false;
    }
);

/* ACF Icon Picker */
function wp_admin_post_type()
{
    global $post, $parent_file, $typenow, $current_screen, $pagenow;

    $post_type = null;

    if ($post && (property_exists($post, 'post_type') || method_exists($post, 'post_type'))) {
        $post_type = $post->post_type;
    }

    if (empty($post_type) && !empty($current_screen) && (property_exists($current_screen, 'post_type') || method_exists($current_screen, 'post_type')) && !empty($current_screen->post_type)) {
        $post_type = $current_screen->post_type;
    }

    if (empty($post_type) && !empty($typenow)) {
        $post_type = $typenow;
    }

    if (empty($post_type) && function_exists('get_current_screen')) {
        $post_type = get_current_screen();
    }

    if (empty($post_type) && isset($_REQUEST['post']) && !empty($_REQUEST['post']) && function_exists('get_post_type') && $get_post_type = get_post_type((int)$_REQUEST['post'])) {
        $post_type = $get_post_type;
    }

    if (empty($post_type) && isset($_REQUEST['post_type']) && !empty($_REQUEST['post_type'])) {
        $post_type = sanitize_key($_REQUEST['post_type']);
    }

    if (empty($post_type) && 'edit.php' == $pagenow) {
        $post_type = 'post';
    }

    return $post_type;
}

// modify the path to the icons directory
add_filter(
    'acf_icon_path_suffix',
    function ( $path_suffix ) {
        $dir = 'acf';
        $post_type = wp_admin_post_type();
        $is_global_options = (isset($_GET["page"]) && $_GET["page"] == 'global-options' ) ? true : false;
        if ($post_type === 'network_team' OR $post_type === 'team' OR $post_type === 'presenter' OR $is_global_options) {
            $dir = 'social';
        }
        return '/icons/' . $dir . '/'; // After assets folder you can define folder structure
    }
);

// modify the path to the above prefix
add_filter(
    'acf_icon_path',
    function ($path_suffix) {
        return $_SERVER["DOCUMENT_ROOT"] . '/wp-content/themes/uudocsv2/resources';
    }
);

// modify the URL to the icons directory to display on the page
add_filter(
    'acf_icon_url',
    function ($path_suffix) {
        return get_stylesheet_directory_uri() . '/resources';
    }
);

// Add class to nav menu links
add_filter(
    'nav_menu_link_attributes',
    function ($classes, $item, $args) {

        if (isset($args->link_class)) {
            $classes['class'] = $args->link_class;
        }

        if (!$item->has_children && $item->menu_item_parent > 0) {
            $classes['class'] = $args->sub_link_class;
        }
        return $classes;
    }, 1, 3
);

// RESET PASSWORD
add_action(
    'acfe/form/validation/email/form=reset-password',
    function ($form) {

        // Get field input value
        $email = get_field('user_login');

        $user = get_user_by('email', $email);

        if ($user) {
            return;
        }

        // check for valid email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            acfe_add_validation_error('user_login', 'Please enter a valid email');

            return false;
        }

        // email is not registered
        acfe_add_validation_error('user_login', 'There is no user with the provided email');

    }, 10, 3
);

add_filter(
    'acfe/form/submit/user_login_args/action=reset-password',
    function ($args) {
        /*
         * Replace Email
         */
        $email = get_field('user_login');

        /* Create set password link */
        $user = get_user_by('email', $email);
        if ($user) {
            $reset_key = get_password_reset_key($user);
            $user_login = $user->user_login;

            $rp_link = '<a href="' . network_site_url("wp-login.php?action=rp&key=$reset_key&login=" . rawurlencode($user_login), 'login') . '">Set password link</a>';

            $args['content'] = str_replace('{{email}}', $rp_link, $args['content']);

            // return
            return $args;
        }

        return false;
    }
);

add_action('login_enqueue_scripts', function () {
    wp_enqueue_style(
        'uudocs/login.css',
        get_template_directory_uri() . '/resources/styles/login.css',
        false,
        null
    );
}, 100);

add_filter(
    'login_headerurl',
    function () {
	    // Change Logo link if you want user to redirect to other link.
	    return home_url();
    }
);

add_filter(
    'login_url',
        function ($login_url, $redirect, $force_reauth) {
        // Change here your login page url
        $login_url = home_url();
        if ( ! empty( $redirect ) ) {
            $login_url = add_query_arg( 'redirect_to', urlencode( $redirect ), $login_url );
        }
        if ( $force_reauth ) {
            $login_url = add_query_arg( 'reauth', '1', $login_url );
        }
        return $login_url;
    }, 10, 3
);

// Don't allow wp-login.php direct access
// Only to login form submission
add_action(
    'init',
    function () {
        // WP tracks the current page - global the variable to access it
        global $pagenow;
        // Check if a $_GET['action'] is set, and if so, load it into $action variable
        $action = (isset($_GET['action'])) ? $_GET['action'] : '';
        if (!$action) {
            $custom_login = (isset($_POST['custom-login'])) ? $_POST['custom-login'] : false;
            if ($custom_login) {
                $action = 'custom-login';
            }
        }

        // Check if we're on the login page, and ensure the action is not 'logout'
        if( $pagenow == 'wp-login.php' && ( ! $action || ( $action && ! in_array($action, array('custom-login', 'logout', 'lostpassword', 'rp', 'resetpass'))))) {
            // Load the home page url
            $page = get_bloginfo('url');
            // Redirect to the home page
            wp_redirect($page);
            // Stop execution to prevent the page loading for any reason
            exit();
        }
    }
);

// Login error handling
/*
add_filter(
    'login_errors',
    function () {
        $login_page  = home_url();
        global $errors;
        $err_codes = $errors->get_error_codes(); // get WordPress built-in error codes
        $_SESSION["err_codes"] =  $err_codes;

        if (!$err_codes) {
            wp_redirect($login_page); // keep users on the same page
            exit;
        }
    }
);
*/

// restrict admin dashboard to administrator role
// all other roles will be taken to the homepage
add_action(
    'init',
    function () {
        if (is_admin() && ! (current_user_can('administrator') OR current_user_can('editor') OR current_user_can('author')) && ! (defined('DOING_AJAX') && DOING_AJAX)) {
            wp_redirect(home_url());
            exit;
        }
    }
);

/*
add_filter(
    'login_redirect',
    function ($redirect_to) {
        ///$redirect_to = 'https://docsv2.local/product/insights/#get-an-overview-of-the-implementation-process';
        return $redirect_to;
    }
);
*/

add_filter(
    'show_admin_bar',
    function () {
        if (current_user_can('administrator') OR current_user_can('editor') OR current_user_can('author')) {
            return true;
        } else {
            return false;
        }
    }
);

add_action(
    'wp_head',
    function () {
        ?>
        <!-- userway -->
        <script>(function(d){var s = d.createElement("script");s.setAttribute("data-account", "hFkhmq6KhJ");s.setAttribute("src", "https://cdn.userway.org/widget.js");(d.body || d.head).appendChild(s);})(document)</script><noscript>Please ensure Javascript is enabled for purposes of <a href="https://userway.org">website accessibility</a></noscript>

        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-F8R5Q53V0Q"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-F8R5Q53V0Q');
        </script>
    <?php
    }
);

add_action(
    'login_enqueue_scripts',
    function() { ?>
        <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url('https://docs.uniteus.com/wp-content/uploads/2022/06/uudocs-logo.png');
		height:65px;
		width:320px;
		background-size: 320px 65px;
		background-repeat: no-repeat;
        	padding-bottom: 30px;
        }
    </style>
    <?php
    }
)
?>
<?php

add_filter(
    'wp_mail_content_type',
    function () {
        return "text/html";
    }
);

add_filter(
    '_retrieve_password_notification_email',
    function ($defaults, $key, $user_login, $user_data) {
        $defaults['headers'] = 'Content-Type: text/html';

        return $defaults;
    }, 99, 4
);

add_filter(
    'retrieve_password_message',
    function ($message, $key, $user_login) {
        $reset_url = network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login');
        $message = \Roots\view('partials.email-password-change', ['reset_url' => $reset_url])->render();
        return $message;
    }, 20, 3
);

add_action(
    'acfe/form/submit/trigger-forgot-password',
    function () {
        // Get field input value
        $email = get_field('user_login');
        retrieve_password($email);
    }, 10, 2
);

add_filter( 'wp_new_user_notification_email', function( $wp_new_user_notification_email, $user, $blogname ) {

    $message = 'Thank you for registering :)';
    $message = \Roots\view('partials.email-user-registration', ['login_url' => network_site_url(), 'name' => $user->email])->render();


    $wp_new_user_notification_email['subject'] = sprintf( 'Welcome to %s.', $blogname );
    $wp_new_user_notification_email['headers'] = array('Content-Type: text/html; charset=UTF-8');
    $wp_new_user_notification_email['message'] = $message;

    return $wp_new_user_notification_email;

}, $priority = 10, $accepted_args = 3 );

add_action(
    'acfe/form/submit/user/form=registration',
    function ($user_id, $type, $args, $form, $action) {
        $user = get_user_by('ID', $user_id);
        apply_filters( 'wp_send_new_user_notification_to_user', true, $user );

        wp_new_user_notification($user_id, '', 'user');



    }, 10, 5
);


add_filter(
    'aspto/get_orderby',
    function ($new_orderBy, $orderBy, $query) {
        global $wpdb;

        $order_type = apto_get_order_type($query);
        $new_orderBy = "FIELD(".$wpdb->posts.".ID, ". implode(",", $order_list) ."), ".$wpdb->posts.".post_date DESC";

        return $new_orderBy;
    }, 10, 3
);

