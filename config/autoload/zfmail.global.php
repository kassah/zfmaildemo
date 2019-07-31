<?php
//return [];
return [
    'mail' => [
        'transport' => [
            'type' => 'smtp',
            'options' => [
                'name' => 'zf',
                'host' => 'mailhog',
                'port' => 1025,
            ]
        ],
    ]
];