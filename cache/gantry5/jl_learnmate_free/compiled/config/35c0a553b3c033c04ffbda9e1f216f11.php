<?php
return [
    '@class' => 'Gantry\\Component\\Config\\CompiledConfig',
    'timestamp' => 1616906049,
    'checksum' => 'fb3722c486fc800f62fee508cc5521f7',
    'files' => [
        'templates/jl_learnmate_free/custom/config/default' => [
            'index' => [
                'file' => 'templates/jl_learnmate_free/custom/config/default/index.yaml',
                'modified' => 1616905108
            ],
            'layout' => [
                'file' => 'templates/jl_learnmate_free/custom/config/default/layout.yaml',
                'modified' => 1616905108
            ]
        ],
        'templates/jl_learnmate_free/config/default' => [
            'page/body' => [
                'file' => 'templates/jl_learnmate_free/config/default/page/body.yaml',
                'modified' => 1615825436
            ],
            'page/head' => [
                'file' => 'templates/jl_learnmate_free/config/default/page/head.yaml',
                'modified' => 1615825436
            ],
            'particles/branding' => [
                'file' => 'templates/jl_learnmate_free/config/default/particles/branding.yaml',
                'modified' => 1615825436
            ],
            'particles/copyright' => [
                'file' => 'templates/jl_learnmate_free/config/default/particles/copyright.yaml',
                'modified' => 1615825436
            ],
            'particles/logo' => [
                'file' => 'templates/jl_learnmate_free/config/default/particles/logo.yaml',
                'modified' => 1615825436
            ],
            'particles/social' => [
                'file' => 'templates/jl_learnmate_free/config/default/particles/social.yaml',
                'modified' => 1615825436
            ],
            'particles/totop' => [
                'file' => 'templates/jl_learnmate_free/config/default/particles/totop.yaml',
                'modified' => 1615825436
            ],
            'styles' => [
                'file' => 'templates/jl_learnmate_free/config/default/styles.yaml',
                'modified' => 1615825436
            ]
        ]
    ],
    'data' => [
        'particles' => [
            'contentcubes' => [
                'caching' => [
                    'type' => 'static'
                ],
                'enabled' => true
            ],
            'contenttabs' => [
                'caching' => [
                    'type' => 'static'
                ],
                'enabled' => true,
                'animation' => 'slide'
            ],
            'copyright' => [
                'caching' => [
                    'type' => 'static'
                ],
                'enabled' => '1',
                'date' => [
                    'start' => '2016',
                    'end' => 'now'
                ],
                'target' => '_blank',
                'owner' => 'JoomLead',
                'link' => '',
                'additional' => [
                    'text' => 'Developed by JoomLead Team'
                ],
                'css' => [
                    'class' => ''
                ]
            ],
            'horizontalmenu' => [
                'caching' => [
                    'type' => 'static'
                ],
                'enabled' => true,
                'target' => '_blank'
            ],
            'owlcarousel' => [
                'caching' => [
                    'type' => 'static'
                ],
                'enabled' => true,
                'nav' => 'disable',
                'dots' => 'enable',
                'autoplay' => 'disable',
                'imageOverlay' => 'enable'
            ],
            'branding' => [
                'caching' => [
                    'type' => 'static'
                ],
                'enabled' => '1',
                'content' => 'Powered by <a href="https://www.joomlead.com/" title="JoomLead" class="g-powered-by">JoomLead<span class="hidden-tablet"> </span></a>',
                'css' => [
                    'class' => 'g-branding'
                ]
            ],
            'custom' => [
                'caching' => [
                    'type' => 'config_matches',
                    'values' => [
                        'twig' => '0',
                        'filter' => '0'
                    ]
                ],
                'enabled' => true,
                'twig' => '0',
                'filter' => '0'
            ],
            'logo' => [
                'caching' => [
                    'type' => 'static'
                ],
                'enabled' => '1',
                'target' => '_self',
                'link' => true,
                'url' => '',
                'image' => 'gantry-media://logo/logo.png',
                'text' => '',
                'class' => 'g-logo g-logo-learnmate'
            ],
            'menu' => [
                'caching' => [
                    'type' => 'menu'
                ],
                'enabled' => true,
                'menu' => '',
                'base' => '/',
                'startLevel' => 1,
                'maxLevels' => 0,
                'renderTitles' => 0,
                'hoverExpand' => 1,
                'mobileTarget' => 0,
                'forceTarget' => 0
            ],
            'mobile-menu' => [
                'caching' => [
                    'type' => 'static'
                ],
                'enabled' => true
            ],
            'social' => [
                'caching' => [
                    'type' => 'static'
                ],
                'enabled' => '1',
                'css' => [
                    'class' => ''
                ],
                'target' => '_blank',
                'display' => 'both',
                'title' => '',
                'items' => [
                    0 => [
                        'icon' => 'fa fa-twitter fa-fw',
                        'text' => '',
                        'link' => 'http://www.twitter.com/joomlead',
                        'name' => 'Twitter'
                    ],
                    1 => [
                        'icon' => 'fa fa-facebook fa-fw',
                        'text' => '',
                        'link' => 'http://www.facebook.com/joomlead',
                        'name' => 'Facebook'
                    ],
                    2 => [
                        'icon' => 'fa fa-google-plus fa-fw',
                        'text' => '',
                        'link' => 'https://plus.google.com/+joomlead',
                        'name' => 'Google+'
                    ]
                ]
            ],
            'spacer' => [
                'caching' => [
                    'type' => 'static'
                ],
                'enabled' => true
            ],
            'totop' => [
                'caching' => [
                    'type' => 'static'
                ],
                'enabled' => '1',
                'css' => [
                    'class' => ''
                ],
                'icon' => 'fa fa-chevron-up fa-fw',
                'content' => 'Back to top'
            ],
            'backtotop' => [
                'enabled' => true,
                'icon' => 'fa fa-angle-double-up'
            ],
            'sticky' => [
                'enabled' => true,
                'spacing' => 0
            ],
            'analytics' => [
                'enabled' => true,
                'ua' => [
                    'anonym' => false
                ]
            ],
            'assets' => [
                'enabled' => true
            ],
            'content' => [
                'enabled' => true
            ],
            'contentarray' => [
                'enabled' => true,
                'article' => [
                    'filter' => [
                        'featured' => ''
                    ],
                    'limit' => [
                        'total' => 2,
                        'columns' => 2,
                        'start' => 0
                    ],
                    'display' => [
                        'pagination_buttons' => '',
                        'image' => [
                            'enabled' => 'intro'
                        ],
                        'text' => [
                            'type' => 'intro',
                            'limit' => '',
                            'formatting' => 'text',
                            'prepare' => false
                        ],
                        'edit' => false,
                        'title' => [
                            'enabled' => 'show'
                        ],
                        'date' => [
                            'enabled' => 'published',
                            'format' => 'l, F d, Y'
                        ],
                        'read_more' => [
                            'enabled' => 'show'
                        ],
                        'author' => [
                            'enabled' => 'show'
                        ],
                        'category' => [
                            'enabled' => 'link'
                        ],
                        'hits' => [
                            'enabled' => 'show'
                        ]
                    ],
                    'sort' => [
                        'orderby' => 'publish_up',
                        'ordering' => 'ASC'
                    ]
                ]
            ],
            'date' => [
                'enabled' => true,
                'css' => [
                    'class' => 'date'
                ],
                'date' => [
                    'formats' => 'l, F d, Y'
                ]
            ],
            'frameworks' => [
                'enabled' => true,
                'jquery' => [
                    'enabled' => 0,
                    'ui_core' => 0,
                    'ui_sortable' => 0
                ],
                'bootstrap' => [
                    'enabled' => 0
                ],
                'mootools' => [
                    'enabled' => 0,
                    'more' => 0
                ]
            ],
            'lightcase' => [
                'enabled' => true
            ],
            'messages' => [
                'enabled' => true
            ],
            'module' => [
                'enabled' => true
            ],
            'position' => [
                'enabled' => true
            ]
        ],
        'styles' => [
            'above-slideshow' => [
                'background' => '#ffffff',
                'text-color' => '#424753'
            ],
            'accent' => [
                'color-1' => '#3f51b5',
                'color-2' => '#8ec549',
                'color-3' => '#46a5e5'
            ],
            'base' => [
                'background' => '#ffffff',
                'text-color' => '#767779'
            ],
            'breakpoints' => [
                'large-desktop-container' => '75rem',
                'desktop-container' => '60rem',
                'tablet-container' => '51rem',
                'large-mobile-container' => '30rem',
                'mobile-menu-breakpoint' => '51rem'
            ],
            'font' => [
                'family-default' => 'family=Roboto:300,400',
                'family-title' => 'family=Fira+Sans:700'
            ],
            'footer' => [
                'background' => '#f2f2f2',
                'text-color' => '#000000'
            ],
            'header' => [
                'background' => '#ffffff',
                'text-color' => '#424753'
            ],
            'menu' => [
                'col-width' => '180px',
                'animation' => 'g-zoom'
            ],
            'navigation' => [
                'background' => 'rgba(0,0,0,0)',
                'text-color' => '#ffffff'
            ],
            'offcanvas' => [
                'background' => '#ffffff',
                'text-color' => '#3f51b5',
                'toggle-color' => '#949494',
                'toggle-visibility' => '1',
                'width' => '14rem'
            ],
            'slideshow' => [
                'background' => '#ffffff',
                'background-overlay' => 'enabled',
                'text-color' => '#000000',
                'background-image' => ''
            ],
            'preset' => 'preset1'
        ],
        'page' => [
            'body' => [
                'attribs' => [
                    'class' => 'gantry g-learnmate-style',
                    'id' => '',
                    'extra' => [
                        
                    ]
                ],
                'layout' => [
                    'sections' => '3'
                ],
                'body_top' => '',
                'body_bottom' => ''
            ],
            'fontawesome' => [
                'enable' => 1
            ],
            'head' => [
                'meta' => [
                    
                ],
                'head_bottom' => '',
                'atoms' => [
                    0 => [
                        'id' => 'sticky-7641',
                        'type' => 'sticky',
                        'title' => 'Sticky',
                        'attributes' => [
                            'enabled' => '1',
                            'id' => 'g-navigation',
                            'spacing' => '0'
                        ]
                    ],
                    1 => [
                        'id' => 'backtotop-5472',
                        'type' => 'backtotop',
                        'title' => 'Back To Top',
                        'attributes' => [
                            'enabled' => '1',
                            'css' => [
                                'class' => ''
                            ],
                            'icon' => 'fa fa-angle-double-up'
                        ]
                    ],
                    2 => [
                        'type' => 'frameworks',
                        'title' => 'JavaScript Frameworks',
                        'attributes' => [
                            'enabled' => '1',
                            'jquery' => [
                                'enabled' => '1',
                                'ui_core' => '0',
                                'ui_sortable' => '0'
                            ],
                            'bootstrap' => [
                                'enabled' => '0'
                            ],
                            'mootools' => [
                                'enabled' => '0',
                                'more' => '0'
                            ]
                        ],
                        'id' => 'frameworks-4975'
                    ],
                    3 => [
                        'id' => 'assets-7929',
                        'type' => 'assets',
                        'title' => 'Custom CSS / JS',
                        'attributes' => [
                            'enabled' => '1',
                            'css' => [
                                
                            ],
                            'javascript' => [
                                0 => [
                                    'location' => 'gantry-assets://js/theme.js',
                                    'inline' => '',
                                    'in_footer' => '0',
                                    'extra' => [
                                        
                                    ],
                                    'priority' => '0',
                                    'name' => 'Theme Js'
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ],
        'index' => [
            'name' => 'default',
            'timestamp' => 1616905108,
            'version' => 7,
            'preset' => [
                'image' => 'gantry-admin://images/layouts/default.png',
                'name' => 'default',
                'timestamp' => 1615820955
            ],
            'positions' => [
                'search' => 'search',
                'switch' => 'switch',
                'slider1' => 'slider1',
                'aside' => 'Aside',
                'pre1' => 'pre1',
                'perview' => 'perview',
                'share' => 'share',
                'sidebar' => 'Sidebar'
            ],
            'sections' => [
                'header' => 'Header',
                'navigation' => 'Navigation',
                'above-slideshow' => 'Above-slideshow',
                'slideshow' => 'Slideshow',
                'aside' => 'Aside',
                'sidebar' => 'Sidebar',
                'mainbar' => 'Mainbar',
                'footer' => 'Footer',
                'offcanvas' => 'Offcanvas'
            ],
            'particles' => [
                'logo' => [
                    'logo-9608' => 'Logo / Image'
                ],
                'spacer' => [
                    'spacer-8120' => 'Spacer',
                    'spacer-3635' => 'Spacer'
                ],
                'position' => [
                    'position-position-8364' => 'search',
                    'position-position-2741' => 'switch',
                    'position-position-6267' => 'slider1',
                    'position-position-4734' => 'Aside',
                    'position-position-2554' => 'pre1',
                    'position-position-3719' => 'perview',
                    'position-position-7111' => 'share',
                    'position-position-3949' => 'Sidebar'
                ],
                'custom' => [
                    'custom-2399' => 'Top Menu',
                    'custom-9609' => 'Logo',
                    'custom-2410' => 'Information',
                    'custom-6963' => 'Quick Link',
                    'custom-1285' => 'Extra Link',
                    'custom-5076' => 'Contact Information'
                ],
                'menu' => [
                    'menu-6409' => 'Menu'
                ],
                'messages' => [
                    'system-messages-7152' => 'System Messages'
                ],
                'content' => [
                    'system-content-1587' => 'Page Content'
                ],
                'branding' => [
                    'branding-2819' => 'Branding'
                ],
                'social' => [
                    'social-3954' => 'Social'
                ],
                'mobile-menu' => [
                    'mobile-menu-5697' => 'Mobile-menu'
                ]
            ],
            'inherit' => [
                
            ]
        ],
        'layout' => [
            'version' => 2,
            'preset' => [
                'image' => 'gantry-admin://images/layouts/default.png',
                'name' => 'default',
                'timestamp' => 1615820955
            ],
            'layout' => [
                '/header/' => [
                    0 => [
                        0 => 'logo-9608 10',
                        1 => 'spacer-8120 57',
                        2 => 'position-position-8364 18',
                        3 => 'custom-2399 5',
                        4 => 'position-position-2741 10'
                    ]
                ],
                '/navigation/' => [
                    0 => [
                        0 => 'menu-6409'
                    ]
                ],
                '/above-slideshow/' => [
                    0 => [
                        0 => 'position-position-6267'
                    ]
                ],
                '/slideshow/' => [
                    
                ],
                '/container-main/' => [
                    0 => [
                        0 => [
                            'aside 25' => [
                                0 => [
                                    0 => 'position-position-4734'
                                ]
                            ]
                        ],
                        1 => [
                            'mainbar 50' => [
                                0 => [
                                    0 => 'system-messages-7152'
                                ],
                                1 => [
                                    0 => 'system-content-1587'
                                ],
                                2 => [
                                    0 => 'position-position-2554'
                                ],
                                3 => [
                                    0 => 'position-position-3719'
                                ],
                                4 => [
                                    0 => 'position-position-7111 30',
                                    1 => 'spacer-3635 70'
                                ]
                            ]
                        ],
                        2 => [
                            'sidebar 25' => [
                                0 => [
                                    0 => 'position-position-3949'
                                ]
                            ]
                        ]
                    ]
                ],
                '/footer/' => [
                    0 => [
                        0 => 'custom-9609 25',
                        1 => 'custom-2410 17',
                        2 => 'custom-6963 17',
                        3 => 'custom-1285 17',
                        4 => 'custom-5076 24'
                    ],
                    1 => [
                        0 => 'branding-2819 70',
                        1 => 'social-3954 30'
                    ]
                ],
                '/offcanvas/' => [
                    0 => [
                        0 => 'mobile-menu-5697'
                    ]
                ]
            ],
            'structure' => [
                'header' => [
                    'attributes' => [
                        'boxed' => '',
                        'class' => 'section-horizontal-paddings'
                    ]
                ],
                'navigation' => [
                    'type' => 'section',
                    'attributes' => [
                        'boxed' => '',
                        'class' => 'section-horizontal-paddings'
                    ]
                ],
                'above-slideshow' => [
                    'type' => 'section',
                    'attributes' => [
                        'boxed' => '',
                        'class' => 'section-horizontal-paddings'
                    ]
                ],
                'slideshow' => [
                    'type' => 'section',
                    'attributes' => [
                        'boxed' => '',
                        'class' => 'section-horizontal-paddings'
                    ]
                ],
                'aside' => [
                    'attributes' => [
                        'class' => ''
                    ],
                    'block' => [
                        'fixed' => '1'
                    ]
                ],
                'mainbar' => [
                    'type' => 'section',
                    'subtype' => 'main'
                ],
                'sidebar' => [
                    'type' => 'section',
                    'subtype' => 'aside',
                    'attributes' => [
                        'class' => ''
                    ],
                    'block' => [
                        'fixed' => '1'
                    ]
                ],
                'container-main' => [
                    'attributes' => [
                        'boxed' => '',
                        'class' => 'section-horizontal-paddings',
                        'extra' => [
                            
                        ]
                    ]
                ],
                'footer' => [
                    'attributes' => [
                        'boxed' => '',
                        'class' => 'section-horizontal-paddings section-vertical-paddings'
                    ]
                ],
                'offcanvas' => [
                    'attributes' => [
                        'boxed' => ''
                    ]
                ]
            ],
            'content' => [
                'logo-9608' => [
                    'title' => 'Logo / Image',
                    'attributes' => [
                        'image' => 'gantry-media://logo/152926842_279410070198546_2843013979326372393_n.png'
                    ]
                ],
                'position-position-8364' => [
                    'title' => 'search',
                    'attributes' => [
                        'key' => 'search',
                        'chrome' => ''
                    ]
                ],
                'custom-2399' => [
                    'title' => 'Top Menu',
                    'attributes' => [
                        'enabled' => 0,
                        'html' => '<div class="top-menu">
    <ul class="nav menu">
        <li><a href="#">TRANDING</a></li>
        <li><a href="#">ONLINE</a></li>
        <li><a href="#">BOOK</a></li>
        <li><a href="#">EVENTS</a></li>
        <li><a href="#">ALUMNI</a></li>
    </ul>
</div>
'
                    ]
                ],
                'position-position-2741' => [
                    'title' => 'switch',
                    'attributes' => [
                        'key' => 'switch'
                    ]
                ],
                'position-position-6267' => [
                    'title' => 'slider1',
                    'attributes' => [
                        'key' => 'slider1'
                    ]
                ],
                'position-position-4734' => [
                    'title' => 'Aside',
                    'attributes' => [
                        'key' => 'aside'
                    ]
                ],
                'position-position-2554' => [
                    'title' => 'pre1',
                    'attributes' => [
                        'key' => 'pre1'
                    ]
                ],
                'position-position-3719' => [
                    'title' => 'perview',
                    'attributes' => [
                        'enabled' => 0,
                        'key' => 'perview'
                    ]
                ],
                'position-position-7111' => [
                    'title' => 'share',
                    'attributes' => [
                        'key' => 'share'
                    ]
                ],
                'position-position-3949' => [
                    'title' => 'Sidebar',
                    'attributes' => [
                        'key' => 'sidebar'
                    ]
                ],
                'custom-9609' => [
                    'title' => 'Logo',
                    'attributes' => [
                        'enabled' => 0,
                        'html' => '<div class="jl-ft-about" style="text-align: left">
	<div class="jl-heading">
      <img src="gantry-media://logo/logo.png" alt="" />
  </div>
</div>'
                    ]
                ],
                'custom-2410' => [
                    'title' => 'Information',
                    'attributes' => [
                        'enabled' => 0,
                        'html' => '<div class="jl-custom-ft uk-grid">
  <div class="jl-custom-title uk-width-1-1">
    <h3>Information</h3>
  </div>

    <div class="jl-custom-link uk-width-1-1">
      <a href="#">Who we are </a>
    </div>
    <div class="jl-custom-link uk-width-1-1">
      <a href="#">History </a>
    </div>
    <div class="jl-custom-link uk-width-1-1">
      <a href="#">Facts & Figures </a>
    </div>
    <div class="jl-custom-link uk-width-1-1">
      <a href="#">Programs </a>
    </div>
    <div class="jl-custom-link uk-width-1-1">
      <a href="#">Mission / Vision </a>
    </div>

</div>'
                    ]
                ],
                'custom-6963' => [
                    'title' => 'Quick Link',
                    'attributes' => [
                        'enabled' => 0,
                        'html' => '<div class="jl-custom-ft uk-grid">
  <div class="jl-custom-title uk-width-1-1">
    <h3>QUICK LINK</h3>
  </div>

    <div class="jl-custom-link uk-width-1-1">
      <a href="#">Falcuties & Department </a>
    </div>
    <div class="jl-custom-link uk-width-1-1">
      <a href="#">Business & Corporation </a>
    </div>
    <div class="jl-custom-link uk-width-1-1">
      <a href="#">Events </a>
    </div>
    <div class="jl-custom-link uk-width-1-1">
      <a href="#">Charity </a>
    </div>
    <div class="jl-custom-link uk-width-1-1">
      <a href="#">Alumni </a>
    </div>
</div>'
                    ]
                ],
                'custom-1285' => [
                    'title' => 'Extra Link',
                    'attributes' => [
                        'enabled' => 0,
                        'html' => '<div class="jl-custom-ft uk-grid">
  <div class="jl-custom-title uk-width-1-1">
    <h3>EXTRA LINK</h3>
  </div>

    <div class="jl-custom-link uk-width-1-1">
      <a href="#">Accessibility </a>
    </div>
    <div class="jl-custom-link uk-width-1-1">
      <a href="#">Legal </a>
    </div>
    <div class="jl-custom-link uk-width-1-1">
      <a href="#">Sitemap </a>
    </div>
    <div class="jl-custom-link uk-width-1-1">
      <a href="#">Terms of use </a>
    </div>
    <div class="jl-custom-link uk-width-1-1">
      <a href="#">Privacy </a>
    </div>
</div>'
                    ]
                ],
                'custom-5076' => [
                    'title' => 'Contact Information',
                    'attributes' => [
                        'enabled' => 0,
                        'html' => '<div class="jl-custom-ft uk-grid">
  <div class="jl-custom-title uk-width-1-1">
    <h3>CONTACT INFORMATION</h3>
  </div>

    <div class="jl-custom-link uk-width-1-1">
      <a href="#">Senate House, Tyndall
Avenue, Bristol, BS8 1TH, UK. </a>
    </div>
    <div class="jl-custom-link uk-width-1-1">
      <a href="#">Tel: +44 (0)117 928 9000 </a>
    </div>
    <div class="jl-custom-link uk-width-1-1">
      <a href="#">Email: demo@joomlead.com </a>
    </div>

</div>'
                    ]
                ],
                'social-3954' => [
                    'attributes' => [
                        'enabled' => 0,
                        'items' => [
                            0 => [
                                'icon' => 'fa fa-twitter fa-fw',
                                'text' => '',
                                'link' => 'http://www.twitter.com/joomlead',
                                'name' => 'Twitter'
                            ],
                            1 => [
                                'icon' => 'fa fa-facebook fa-fw',
                                'text' => '',
                                'link' => 'http://www.facebook.com/joomlead',
                                'name' => 'Facebook'
                            ],
                            2 => [
                                'icon' => 'fa fa-google-plus fa-fw',
                                'text' => '',
                                'link' => 'https://plus.google.com/+joomlead',
                                'name' => 'Google+'
                            ],
                            3 => [
                                'icon' => 'fa fa-instagram',
                                'text' => '',
                                'link' => '#',
                                'name' => 'Instagram'
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ]
];
