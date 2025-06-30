<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],  // Apply CORS only to API paths
    'allowed_methods' => ['*'],                   // Allow all HTTP methods (GET, POST, etc.)
    'allowed_origins' => ['*'],                   // Allow all origins ('*' allows all, but you can restrict to a specific URL)
    'allowed_origins_patterns' => [],             // If using regex patterns to match origins
    'allowed_headers' => ['*'],                   // Allow all headers (e.g., Authorization, Content-Type)
    'exposed_headers' => [],                      // Headers exposed to the client
    'max_age' => 0,                               // Maximum age for preflight requests caching
    'supports_credentials' => false,              // Set to true if credentials are needed (e.g., cookies)
];
