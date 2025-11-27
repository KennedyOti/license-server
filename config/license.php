<?php

return [
    'private_key' => env('LICENSE_PRIVATE_KEY'),
    'public_key' => env('LICENSE_PUBLIC_KEY'),
    'token_ttl' => env('LICENSE_TOKEN_TTL', 48 * 3600), // 48 hours
];