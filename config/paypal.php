<?php 
return [ 
    'client_id' => env('PAYPAL_CLIENT_ID','AXj1kqsDpMNH_JPmShIXUHOz1kBiy-wCScpseMolfyYuhE88FqtWKHJS5ZngL5YudEUJ3tP77A1h-EyN'),
    'secret' => env('PAYPAL_SECRET','ELz376zooyXvnQC8fxsX8tkZeqgMTXtxKsEr0bby3q0-iOGj73Eo-73TowMcAF6fRxOASNcpR2asKU8V'),
    'settings' => array(
        'mode' => env('PAYPAL_MODE','sandbox'),
        'http.ConnectionTimeOut' => 30,
        'log.LogEnabled' => true,
        'log.FileName' => storage_path() . '/logs/paypal.log',
        'log.LogLevel' => 'ERROR'
    ),
];