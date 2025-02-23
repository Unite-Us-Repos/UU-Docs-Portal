<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class App extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        '*',
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'siteName'          => $this->siteName(),
            'currentUrl'        => $this->getCurrentUrl(),
            'loginForm' => $this->loginForm(),
            'isLoggedIn' => $this->isLoggedIn(),
            'logoutUrl' => $this->logoutUrl(),
            'currentPage' => $this->currentPage(),
            'query_string'      => $this->getUrlQueryArg(),
            'currentYear'       => $this->currentYear(),
            'acf'               => $this->getAcfFields(),
            'mainMenuItems'     => $this->getMenuItems('Main Nav'),
            'socialMediaIcons'  => $this->getSocialMediaIcons(),
        ];
    }

    /**
     * Returns the site name.
     *
     * @return string
     */
    public function siteName()
    {
        return get_bloginfo('name', 'display');
    }

    /**
     * Returns the full current URL path, including query parameters.
     *
     * @return string
     */
    public function getCurrentUrl()
    {
        global $wp;
        $current_url = home_url(add_query_arg(array($_GET), $wp->request));

        return $current_url;
    }

    public function isLoggedIn()
    {
        global $post;
    
        if (!isset($post)) {
            return false;
        }
    
        $current_page = $post->post_name;
        $exclude_pages = ['register', 'reset-password'];
    
        // Allow articles inside "Public Resource Center Help Center" to be visible
        $isPublicGuide = is_singular('guide') && has_term('public-resource-center-help-center', 'guide_section');
    
        // Always allow Public Resource Directory and guides from Public Resource Center Help Center
        if ($isPublicGuide || is_tax('product', 'public-resource-directory') || in_array($current_page, $exclude_pages)) {
            return true;
        }
    
        // Default: Only logged-in users get full access
        return is_user_logged_in();
    }
    

    public function loginForm()
    {
        global $wp;
        $current_page = home_url($wp->request);
        $login  = (isset($_GET['login']) ) ? $_GET['login'] : 0;
        $redirect_to  = (isset($_GET['redirect_to']) ) ? $_GET['redirect_to'] : $current_page;

        $content = '<input type="hidden" value="hello" />';

        $args = [
            'echo' => false,
            'redirect' => $redirect_to,
            'label_log_in' => 'Login',
            'label_password' => 'Password:',
            'label_username' => 'Email:',
            'remember' => false,
        ];

        $form = wp_login_form($args);
        $hidden_field = '<input type="hidden" name="custom-login" value="1" />';
        $form = str_replace('</form>', $hidden_field . '</form>', $form);

        if ( $login === "failed" ) {
            $form .= '<p class="login-msg"><strong>ERROR:</strong> Invalid username and/or password.</p>';
          } elseif ( $login === "empty" ) {
            $form .= '<p class="login-msg"><strong>ERROR:</strong> Username and/or Password is empty.</p>';
          } elseif ( $login === "false" ) {
            $form .= '<p class="login-msg"><strong>ERROR:</strong> You are logged out.</p>';
          }

        return $form;
    }

    public function logoutUrl()
    {
        $logout_url = wp_logout_url();
        $is_user_logged_in = is_user_logged_in();

        if ($is_user_logged_in) {
            return $logout_url;
        }
    }

    public function currentPage()
    {
        global $post;

        if (!isset($post)) {
            return false;
        }

        $current_page = $post->post_name;

        return $current_page;
    }

    public function getUrlQueryArg()
    {
        $url = $this->getCurrentUrl();
        $query = explode('?', $url);
        $query_string = '';

        if (isset($query[1])) {
            $query_string = $query[1];
        }
        return $query_string;
    }

    /**
     * Returns the current year.
     *
     * @return string
     */
    public function currentYear()
    {
        return date('Y');
    }

    public function getAcfFields()
    {
        $fields = get_fields(get_queried_object());

        if (isset($fields["components"]) && is_array($fields["components"])) {
            foreach ($fields["components"] as $index => $field) {
                if (isset($field["layout_settings"])) {
                    foreach ($field["layout_settings"] as $index => $settings) {
                        $fields[$index] = $settings;
                    }
                }
            }
        }

        return $fields;
    }

    function getMenuItems($current_menu = 'Main Menu') {
        $array_menu = wp_get_nav_menu_items($current_menu);
        $menu = array();
        if (!is_array($array_menu)) {
            return [];
        }
        foreach ($array_menu as $m) {
            if (empty($m->menu_item_parent)) {
                $menu[$m->ID] = array();
                $anchor = get_field('anchor', $m->ID);
                $menu[$m->ID]['anchor']     = '';
                $menu[$m->ID]['ID']         = $m->ID;
                $menu[$m->ID]['title']      = $m->title;
                $menu[$m->ID]['url']        = $m->url;
                $menu[$m->ID]['children']   = false;

                if ($anchor) {
                    $menu[$m->ID]['anchor'] = $anchor;
                    $menu[$m->ID]['url'] = $menu[$m->ID]['url']
                        . '#'
                        . $anchor;
                }
            }
        }
        $submenu = array();
        foreach ($array_menu as $m) {
            if ($m->menu_item_parent) {
                $submenu[$m->ID] = array();
                $anchor = get_field('anchor', $m->ID);
                $submenu[$m->ID]['anchor']  = '';
                $submenu[$m->ID]['ID']      = $m->ID;
                $submenu[$m->ID]['title']   = $m->title;
                $submenu[$m->ID]['url']     = $m->url;

                if (isset($menu[$m->menu_item_parent])) {
                    $menu[$m->menu_item_parent]['children'][$m->ID] = $submenu[$m->ID];
                }

                if ($anchor) {
                    $submenu[$m->ID]['anchor'] = $anchor;
                    $submenu[$m->ID]['url']    = $submenu[$m->ID]['url']
                        . '#'
                        . $anchor;
                }

                $sub_submenu = array();
                foreach ($array_menu as $mm) {
                    if ($mm->menu_item_parent == $m->ID) {
                        $sub_submenu[$mm->ID] = array();
                        $anchor = get_field('anchor', $mm->ID);
                        $sub_submenu[$mm->ID]['ID']      = $mm->ID;
                        $sub_submenu[$mm->ID]['title']   = $mm->title;
                        $sub_submenu[$mm->ID]['url']     = $mm->url;
                        $sub_submenu[$mm->ID]['parent']     = $mm->menu_item_parent;

                        if ($anchor) {
                            $sub_submenu[$mm->ID]['anchor'] = $anchor;
                            $sub_submenu[$mm->ID]['url'] = $sub_submenu[$mm->ID]['url']
                                . '#'
                                . $anchor;
                        }

                        $menu[$m->menu_item_parent]['children'][$m->ID]['children'][$mm->ID] = $sub_submenu[$mm->ID];
                    }
                }
            }
        }

        return $menu;
    }

    public function getSocialMediaIcons()
    {
        $items = get_field('social_media_link', 'options');
        $path = get_template_directory_uri() . '/resources/icons/social/';
        $links = [];

        if ($items) {
            foreach ($items as $index => $item) {
                $label = str_replace('-', ' ', $item['icon']);
                $label = ucwords($label);

                $links[$index]['url'] = $item['url'];
                $links[$index]['label'] = $label;
                $links[$index]['icon'] = $item['icon'];
            }
        }
        return $links;
    }

}
