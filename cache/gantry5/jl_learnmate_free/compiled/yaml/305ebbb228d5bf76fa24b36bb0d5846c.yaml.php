<?php
return [
    '@class' => 'Gantry\\Component\\File\\CompiledYamlFile',
    'filename' => '/var/www/html/templates/jl_learnmate_free/gantry/theme.yaml',
    'modified' => 1615825436,
    'data' => [
        'details' => [
            'name' => 'Learnmate Free',
            'version' => '1.0.4',
            'icon' => 'paper-plane',
            'date' => 'April 05, 2018',
            'author' => [
                'name' => 'JoomLead',
                'email' => 'support@joomlead.com',
                'link' => 'https://www.joomlead.com'
            ],
            'documentation' => [
                'link' => 'http://docs.gantry.org/gantry5'
            ],
            'support' => [
                'link' => 'https://gitter.im/gantry/gantry5'
            ],
            'updates' => [
                'link' => NULL
            ],
            'copyright' => '(C) 2015 - 2018 JoomLead. All rights reserved.',
            'license' => 'GPLv2',
            'description' => 'Learnmate Free Theme',
            'images' => [
                'thumbnail' => 'admin/images/preset1.png',
                'preview' => 'admin/images/preset1.png'
            ]
        ],
        'configuration' => [
            'gantry' => [
                'platform' => 'joomla',
                'engine' => 'nucleus'
            ],
            'theme' => [
                'parent' => 'jl_learnmate_free',
                'base' => 'gantry-theme://common',
                'file' => 'gantry-theme://includes/theme.php',
                'class' => '\\Gantry\\Framework\\Theme'
            ],
            'fonts' => [
                'roboto' => [
                    400 => 'gantry-theme://fonts/roboto_regular_macroman/Roboto-Regular-webfont',
                    500 => 'gantry-theme://fonts/roboto_medium_macroman/Roboto-Medium-webfont',
                    700 => 'gantry-theme://fonts/roboto_bold_macroman/Roboto-Bold-webfont'
                ]
            ],
            'css' => [
                'compiler' => '\\Gantry\\Component\\Stylesheet\\ScssCompiler',
                'target' => 'gantry-theme://css-compiled',
                'paths' => [
                    0 => 'gantry-theme://scss',
                    1 => 'gantry-engine://scss'
                ],
                'files' => [
                    0 => 'learnmate',
                    1 => 'learnmate-joomla',
                    2 => 'custom'
                ],
                'persistent' => [
                    0 => 'learnmate'
                ],
                'overrides' => [
                    0 => 'learnmate-joomla',
                    1 => 'custom'
                ]
            ],
            'dependencies' => [
                'gantry' => '5.3.2'
            ],
            'block-variations' => [
                'Title Variations' => [
                    'title1' => 'Title 1',
                    'title2' => 'Title 2',
                    'title3' => 'Title 3',
                    'title4' => 'Title 4',
                    'title5' => 'Title 5',
                    'title6' => 'Title 6',
                    'title-grey' => 'Title Grey',
                    'title-pink' => 'Title Pink',
                    'title-red' => 'Title Red',
                    'title-purple' => 'Title Purple',
                    'title-orange' => 'Title Orange',
                    'title-blue' => 'Title Blue',
                    'title-gradient' => 'Title Gradient',
                    'title-outline' => 'Title Outline'
                ],
                'Box Variations' => [
                    'box1' => 'Box 1',
                    'box2' => 'Box 2',
                    'box3' => 'Box Blank',
                    'box-grey' => 'Box Grey',
                    'box-pink' => 'Box Pink',
                    'box-red' => 'Box Red',
                    'box-purple' => 'Box Purple',
                    'box-orange' => 'Box Orange',
                    'box-blue' => 'Box Blue',
                    'box-gradient' => 'Box Gradient',
                    'box-outline' => 'Box Outline'
                ],
                'Effects' => [
                    'spaced' => 'Spaced',
                    'shadow' => 'Shadow',
                    'rounded' => 'Rounded'
                ],
                'Utility' => [
                    'center' => 'Center',
                    'title-center' => 'Centered Title',
                    'equal-height' => 'Equal Height',
                    'disabled' => 'Disabled',
                    'align-right' => 'Align Right',
                    'align-left' => 'Align Left',
                    'nomarginall' => 'No Margin',
                    'nopaddingall' => 'No Padding'
                ]
            ]
        ],
        'admin' => [
            'styles' => [
                'core' => [
                    0 => 'base',
                    1 => 'accent',
                    2 => 'font'
                ],
                'section' => [
                    0 => 'header',
                    1 => 'navigation',
                    2 => 'slideshow',
                    3 => 'above-slideshow',
                    4 => 'aside',
                    5 => 'main',
                    6 => 'sidebar',
                    7 => 'footer',
                    8 => 'copyright',
                    9 => 'offcanvas'
                ],
                'configuration' => [
                    0 => 'breakpoints'
                ]
            ]
        ]
    ]
];
