<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => 'NRMS',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => '<b>NRMS</b>',
    'logo_img' => 'assets/icon.jpeg',
    'logo_img_class' => 'brand-image img-circle elevation-5',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'RMS',

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => false,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-dark',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => null,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-dark bg-dark',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => true,
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => 'dashboard',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => null,
    'password_reset_url' => null,
    'password_email_url' => 'password/email',
    'profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For detailed instructions you can look the laravel mix section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'enabled_laravel_mix' => false,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'menu' => [


         /*
        *********************************
            ADMIN MENU LINKS
        *********************************
        */
        [
            'text' => 'Dashboard',
            'route'  => 'dashboard',
            'icon' => 'fas fa-tachometer-alt',
            'can' => [
                'Super Admin', 'Result Compiler', 'Checking Officer', 'Registry','Dispatching Officer',
                'Recommending Officer', 'Approving Officer', 'School Admin', 'Result Uploader',
            ],
        ],
        [
            'text' => 'Assign Tasks',
            'route'  => 'tasks',
            'icon' => 'fa fa-folder-open',
            'can' => [
                'Super Admin', 'Result Compiler', 'Checking Officer', 'Registry','Dispatching Officer',
                'Recommending Officer', 'Approving Officer', 'School Admin', 'Result Uploader',
            ],
        ],
        [
            'text' => 'Transcripts Requests',
            'route'  => 'list.transcript-requests',
            'icon' => 'fa fa-briefcase',
            'can' => [
                'Super Admin', 'Registry',
            ],
        ],
        [
            'text' => 'Verification Requests',
            'route'  => 'verification-requests',
            'icon' => 'fas fa-wallet',
            'can' => [
                'Super Admin', 'Registry',
            ],
        ],
        [
            'text' => 'System Feedback',
            'route'  => 'feedback',
            'icon' => 'fas fa-comments',
            'can' => [
                'Super Admin', 'Registry',
            ],
        ],
        [
            'text' => 'Schools',
            'route'  => 'schools',
            'icon' => 'fas fa-school',
            'can' => ['Super Admin'],
            'active' => ['schools', 'regex:@^schools/[0-9]+$@']
        ],
        [
            'text' => 'Students',
            'route'  => 'students',
            'icon' => 'fas fa-users',
            'can'  => ['School Admin'],
        ],
        [
            'text' => 'Staffs',
            'route'  => 'staffs',
            'icon' => 'fas fa-user-friends',
            'can'  => ['School Admin'],
        ],
        [
            'text' => 'Courses',
            'route'  => 'courses',
            'icon' => 'fas fa-book-open',
            'can'  => ['School Admin'],
        ],
        [
            'text' => 'Semesters',
            'route'  => 'semesters',
            'icon' => 'fas fa-cubes',
            'can'  => ['School Admin'],
        ],
        [
            'text' => 'Grade Setting',
            'route'  => 'grades',
            'icon' => 'fas fa-wrench',
            'can'  => ['School Admin'],
        ],
        [
            'header' => 'account_settings',
            'can'  => [
                        'Super Admin', 'Result Compiler', 'Checking Officer', 'Registry','Dispatching Officer',
                        'Recommending Officer', 'Approving Officer', 'School Admin', 'Result Uploader',
                    ],
        ],
        [
            'text' => 'profile',
            'route'  => 'users.profile',
            'icon' => 'fas fa-fw fa-user',
            'can' => [
                'Super Admin', 'Result Compiler', 'Checking Officer', 'Registry','Dispatching Officer',
                'Recommending Officer', 'Approving Officer', 'School Admin', 'Result Uploader',
            ],
        ],
        [
            'text' => 'change_password',
            'route'  => 'change.password',
            'icon' => 'fas fa-fw fa-lock',
            'can' => [
                'Super Admin', 'Result Compiler', 'Checking Officer', 'Registry','Dispatching Officer',
                'Recommending Officer', 'Approving Officer', 'School Admin', 'Result Uploader',
            ],
        ],
        [
            'text' => 'System Users',
            'icon' => 'fas fa-users-cog',
            'can' => [
                'Super Admin'
            ],
            'submenu' => [
                [
                    'text' => 'Students',
                    'route'  => 'users.students',
                    'icon' => 'fas fa-users',
                    'can'  => ['Super Admin'],
                ],
                [
                    'text' => 'Staffs',
                    'route'  => 'users.staffs',
                    'icon' => 'fas fa-user-friends',
                    'can'  => ['Super Admin'],
                ],
                [
                    'text' => 'Result Enquirers',
                    'route'  => 'users.result.enquirers',
                    'icon' => 'fas fa-chalkboard-teacher',
                    'can'  => ['Super Admin'],
                ],
            ],
        ],

        /*
        *********************************
            Student MENU LINKS
        *********************************
        */
        [
            'text' => 'Dashboard',
            'route'  => 'student.dashboard',
            'icon' => 'fas fa-tachometer-alt',
            'can' => 'student',
        ],
        [
            'header' => 'account_settings',
            'can'  => ['student'],
        ],
        [
            'text' => 'profile',
            'route'  => 'student.users.profile',
            'icon' => 'fas fa-fw fa-user',
            'can' => ['student'],
        ],
        [
            'text' => 'change_password',
            'route'  => 'student.change.password',
            'icon' => 'fas fa-fw fa-lock',
            'can' => ['student'],
        ],

                 /*
        *********************************
            Student MENU LINKS
        *********************************
        */
        [
            'text' => 'Dashboard',
            'route'  => 'verify.result.dashboard',
            'icon' => 'fas fa-tachometer-alt',
            'can' => 'result-verifier',
        ],
        [
            'header' => 'account_settings',
            'can'  => ['result-verifier'],
        ],
        [
            'text' => 'profile',
            'route'  => 'verify.result.users.profile',
            'icon' => 'fas fa-fw fa-user',
            'can' => ['result-verifier'],
        ],
        [
            'text' => 'change_password',
            'route'  => 'verify.result.change.password',
            'icon' => 'fas fa-fw fa-lock',
            'can' => ['result-verifier'],
        ],

    ],
    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'plugins' => [
        [
            'name' => 'Datatables',
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        [
            'name' => 'Select2',
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        [
            'name' => 'Chartjs',
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        [
            'name' => 'Sweetalert2',
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        [
            'name' => 'Pace',
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    */

    'livewire' => false,
];
