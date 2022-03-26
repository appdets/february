<?php

# Dummy options

$options = [

    # wp defaults 
    'id' => 'february-options',
    'menu_title' => 'February Demo',
    'menu_slug' => 'february-options',
    'capability' => 'manage_options',
    'icon_url' => 'dashicons-buddicons-replies',
    'position' => null,

    # february option page 
    'title' => 'February Options',
    'description' => 'A simple options page with a few options.',

    # february behaviors 
    'default_section' => null,
    "tools" => 1,
    "tools_label" => 'Utility Tools',
    'save' => 'Save Settings',
    'saving' => 'Saving...',
    'divider' => 1,
    'conditional_hide' => false,

    # sections
    'sections' => [
        # Basic field section
        [
            'id' => 'basic',
            'title' => 'Basic Fields',
            'description' => 'A simple options page with a few options.',
            'show' => '',
            'fields' => [
                [
                    'id' => 'text',
                    'type' => 'text',
                    'label' => 'Text',
                    'description' => 'A simple text field.',
                    'default' => '',
                    'placeholder' => 'Enter text',
                    'default' => 'Name',
                    'show' => '',
                    'validate' => '',
                    'class' => '',
                    'attributes' => '',
                    'required' => true,
                ],
                [
                    'id' => 'textarea',
                    'type' => 'textarea',
                    'label' => 'Textarea',
                    'description' => 'A simple textarea field.',
                    'default' => '',
                    'placeholder' => 'Enter text',
                    'rows' => 3,
                    'not' => '$radio == "option-1" && $checkbox',
                    'attributes' => [
                        'foo' => 'bar',
                    ],
                ],
                [
                    'id' => 'checkbox',
                    'type' => 'checkbox',
                    'label' => 'Checkbox',
                    'message' => 'A simple checkbox field.',
                    'description' => 'A simple checkbox field.',
                    'default' => true,
                ],
                [
                    'id' => 'radio',
                    'type' => 'radio',
                    'label' => 'Radio',
                    'description' => 'A simple radio field.',
                    'default' => 'option-2',
                    'inline' => 1,
                    'options' => [
                        'option-1' => 'Option 1',
                        'option-2' => 'Option 2',
                        'option-3' => 'Option 3',
                    ],
                ],
                [
                    'id' => 'select',
                    'type' => 'select',
                    'label' => 'Select',
                    'placeholder' => 'Select an option',
                    'description' => 'A simple select field.',
                    'default' => 'center',
                    'hints' => 'lorem ipsum dolor sit amet',
                    'options' => [
                        [
                            'icon' => 'dashicons dashicons-align-left',
                            'value' => 'left',
                            'label' => 'Left',
                        ],
                        [
                            'icon' => 'dashicons dashicons-align-center',
                            'value' => 'center',
                            'label' => 'Center',

                        ],
                        [
                            'icon' => 'dashicons dashicons-align-right',
                            'value' => 'right',
                            'label' => 'Right',

                        ],
                        [
                            'icon' => 'dashicons dashicons-align-none',
                            'value' => 'none',
                            'label' => 'None',
                        ],
                        [
                            'icon' => 'dashicons dashicons-align-none',
                            'value' => 'none',
                            'label' => 'None',
                        ],
                        [
                            'icon' => 'dashicons dashicons-align-none',
                            'value' => 'none',
                            'label' => 'None',
                        ],
                        [
                            'icon' => 'dashicons dashicons-align-none',
                            'value' => 'none',
                            'label' => 'None',
                        ],
                        [
                            'icon' => 'dashicons dashicons-align-none',
                            'value' => 'none',
                            'label' => 'None',
                        ],
                        [
                            'icon' => 'dashicons dashicons-align-none',
                            'value' => 'none',
                            'label' => 'None',
                        ],
                    ],
                ],
                [
                    'id' => 'range',
                    'type' => 'range',
                    'label' => 'Range',
                    'description' => 'A simple select field.',
                    'default' => '20',
                ],
                [
                    'id' => 'image',
                    'type' => 'image',
                    'label' => 'image',
                    'description' => 'A simple image field.',
                    'default' => '',
                ],
                [
                    'id' => 'tab',
                    'type' => 'tab',
                    'label' => 'Tab',
                    'description' => 'A simple tab field.',
                    'default' => 'center',
                    'hide_label' => true,
                    'options' => [
                        [
                            'icon' => 'dashicons dashicons-align-left',
                            'value' => 'left',
                            'label' => 'Left',
                        ],
                        [
                            'icon' => 'dashicons dashicons-align-center',
                            'value' => 'center',
                            'label' => 'Center',

                        ],
                        [
                            'icon' => 'dashicons dashicons-align-right',
                            'value' => 'right',
                            'label' => 'Right',

                        ],
                        [
                            'icon' => 'dashicons dashicons-align-none',
                            'value' => 'none',
                            'label' => 'None',
                        ],
                    ],
                ],
                [
                    'id' => 'multi_switch',
                    'type' => 'multi_switch',
                    'label' => 'Multi Switch',
                    'description' => 'A simple multi switch.',
                    'default' => ['center', 'right'],
                    'options' => [
                        [
                            'icon' => 'dashicons dashicons-align-left',
                            'value' => 'left',
                            'label' => 'Left',
                        ],
                        [
                            'icon' => 'dashicons dashicons-align-center',
                            'value' => 'center',
                            'label' => 'Center',

                        ],
                        [
                            'icon' => 'dashicons dashicons-align-right',
                            'value' => 'right',
                            'label' => 'Right',

                        ],
                        [
                            'icon' => 'dashicons dashicons-align-none',
                            'value' => 'none',
                            'label' => 'None',
                        ],
                    ],
                ],
                [
                    'id' => 'multi_checkbox',
                    'type' => 'multi_checkbox',
                    'label' => 'Multi Checkbox',
                    'description' => 'A simple  multi checkbox.',
                    'default' => ['center', 'right'],
                    'options' => [
                        [
                            'icon' => 'dashicons dashicons-align-left',
                            'value' => 'left',
                            'label' => 'Left',
                        ],
                        [
                            'icon' => 'dashicons dashicons-align-center',
                            'value' => 'center',
                            'label' => 'Center',

                        ],
                        [
                            'icon' => 'dashicons dashicons-align-right',
                            'value' => 'right',
                            'label' => 'Right',

                        ],
                        [
                            'icon' => 'dashicons dashicons-align-none',
                            'value' => 'none',
                            'label' => 'None',
                        ],
                    ],
                ],
                [
                    'type' => 'message',
                    'message' => 'This is center',
                    'show' => '$tab == "center"',
                ],


            ],
        ],
        # Markup section
        [
            'id' => 'markup',
            'title' => 'Markup Fields',
            'full' => true,
            'icon' => 'dashicons dashicons-editor-code',
            'description' => 'A simple options page with a few options.',
            'submit' => false,
            'fields' => [
                // message field 
                [
                    'id' => 'message',
                    'type' => 'message',
                    'text' => 'A simple message field.',
                    'default' => '',
                ],
                [
                    'id' => 'nohtml',
                    'type' => 'nohtml',
                    'text' => '<a href="#">A simple nohtml field that doesn\'t render HTML.</a>',
                    'default' => '',
                ],
                [
                    'id' => 'html',
                    'type' => 'html',
                    'html' => 'A simple html field. <em><strong>Renders HTML syntax</strong></em>',
                    'default' => '',
                ],
                [
                    'id' => 'code',
                    'type' => 'html',
                    'html' => '<h2>Simple HTML code that embeds YouTube videos</h2><br><iframe width="100%" height="360" src="https://www.youtube.com/embed/_f-qkGJBPts" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
                ]
            ],
        ],
        # About section 
        [
            'id' => 'about',
            'title' => 'About February',
            'full' => true,
            'icon' => 'dashicons dashicons-info',
            'submit' => false,
            'fields' => [
                // message field 
                [
                    'id' => 'about-february',
                    'type' => 'message',
                    'text' => 'A tiny minimal robust WordPress Option Framework made with TailwindCSS and Alpine.js',
                    'default' => '',
                ],
            ]
        ]
    ],

];

/**
 * Initialize the options before anything else.
 */

February::create($options);





# Simple getting saved data

/**
 * All fields data
 */

# OOP 
/**
 * @id string
 * The same ID you used in the options array
 */
$data = February::get_options('february-options'); // return all the data

# Works same
$data = fget_options('february-options');





/**
 * Single field data
 */

# OOP 
/**
 * @name string
 * @id string
 * The same IDs you used in the options array 
 */
$field = February::get_option('text', 'february-options'); // return single field data
 
# Works same
$data = fget_option('text', 'february-options');
