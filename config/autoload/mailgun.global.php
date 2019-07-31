<?php
//return [];
return [
    'mail' => [
        'transport' => [
            'type' => 'mailgun',
            'options' => [
                /**
                 * Set your Mailgun domain name (eg. mydomain.com)
                 */
                'domain' => 'sandbox84bb5c9c3b044deca9bbc9dece09028c.mailgun.org',

                /**
                 * Set your Mailgun API key
                 */
                'api_key' => '',

                /**
                 * Set a outgoing mail override
                 */
                'to' => 'William Lightning <kassah@gmail.com>',

                /**
                 * Set a default from address
                 */
                'from' => 'Test App <noreply@example.com>',
            ],
        ],
    ],
];