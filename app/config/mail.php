<?php
return [
	'driver' => env('MAIL_DRIVER'),
    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],
];