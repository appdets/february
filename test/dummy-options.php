<?php

$options = [
    'id' => 'february-options',
    'menu_title' => 'February Demo',
    'menu_slug' => 'february-options',
    'capability' => 'manage_options',
    'icon_url' => 'dashicons-buddicons-replies',
    'position' => null,

    'title' => 'February Options',
    'description' => 'A simple options page with a few options.',

    'default_section' => false,
    "enable_tools" => true,
    'save' => 'Save Options',
    'saving' => 'Saving...',
    'divider' => 1,

    'sections' => [
        [
            'id' => 'inputs',
            'title' => 'Input Fields',
            'description' => 'A simple options page with a few options.',
            'condition' => '',
            'fields' => [
                [
                    'id' => 'text',
                    'type' => 'text',
                    'label' => 'Text',
                    'description' => 'A simple text field.',
                    'default' => '',
                    'placeholder' => 'Enter text',
                    'default' => 'Name',
                    'condition' => '',
                    'validate' => '',
                    'class' => '',
                    'attributes' => '',
                    'required' => true,
                ],
                // [
                //     'type' => 'divider'
                // ],
                [
                    'id' => 'textarea',
                    'type' => 'textarea',
                    'label' => 'Textarea',
                    'description' => 'A simple textarea field.',
                    'default' => '',
                    'placeholder' => 'Enter text',
                    'rows' => 3,
                    'condition' => '$radio == "option-1" && $checkbox',
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
                    'default' => 'option-1',
                    'inline' => false,
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
                    'default' => '',
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
                    ],
                ],
                [
                    'id' => 'range',
                    'type' => 'range',
                    'label' => 'Select',
                    'description' => 'A simple select field.',
                    'default' => '20', 
                ],
                [
                    'id' => 'tab',
                    'type' => 'multi_switch',
                    'label' => 'Tab',
                    'description' => 'A simple tab field.',
                    'default' => '',
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
                    'message' => 'This is left',
                    'condition' => '$tab == "left"',
                ],                
                [
                    'type' => 'message',
                    'message' => 'This is center',
                    'condition' => '$tab == "center"',
                ],
                [
                    'type' => 'message',
                    'message' => 'This is right',
                    'condition' => '$tab == "right"',
                ],
                

            ],
        ],
        // about section 
        [
            'id' => 'about',
            'title' => 'About February',
            'full' => true,
            'icon' => 'dashicons dashicons-info',
            'description' => 'A simple options page with a few options.', 
            'submit' => false,
            'fields' => [
                // html field 
                [
                    'id' => 'html',
                    'type' => 'message',
                    'text' => 'A simple message field.',
                    'default' => '',
                ],
            ],
        ],
    ],

];

February::create($options);
