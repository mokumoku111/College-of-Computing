<?php
return [
    '@class' => 'Gantry\\Component\\File\\CompiledYamlFile',
    'filename' => '/var/www/html/templates/jl_learnmate_free/custom/config/default/layout.yaml',
    'modified' => 1616905108,
    'data' => [
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
];
