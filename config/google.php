<?php

use Google\Service\Sheets;

return [
    /*
    |----------------------------------------------------------------------------
    | Google application name
    |----------------------------------------------------------------------------
    */
    'application_name' => env(
        key: 'GOOGLE_APPLICATION_NAME',
        default: '',
    ),

    /*
    |----------------------------------------------------------------------------
    | Google OAuth 2.0 access
    |----------------------------------------------------------------------------
    |
    | Keys for OAuth 2.0 access, see the API console at
    | https://developers.google.com/console
    |
    */
    'client_id' => env(
        key: 'GOOGLE_CLIENT_ID',
        default: '',
    ),
    'client_secret' => env(
        key: 'GOOGLE_CLIENT_SECRET',
        default: '',
    ),
    'redirect_uri' => env(
        key: 'GOOGLE_REDIRECT',
        default: '',
    ),
    'scopes' => [Sheets::DRIVE, Sheets::SPREADSHEETS],
    'access_type' => 'online',
    'approval_prompt' => 'auto',

    /*
    |----------------------------------------------------------------------------
    | Google developer key
    |----------------------------------------------------------------------------
    |
    | Simple API access key, also from the API console. Ensure you get
    | a Server key, and not a Browser key.
    |
    */
    'developer_key' => env(
        key: 'GOOGLE_DEVELOPER_KEY',
        default: '',
    ),

    /*
    |----------------------------------------------------------------------------
    | Google service account
    |----------------------------------------------------------------------------
    |
    | Set the credentials JSON's location to use assert credentials, otherwise
    | app engine or compute engine will be used.
    |
    */
    'service' => [
        /*
        | Enable service account auth or not.
        */
        'enable' => env(
            key: 'GOOGLE_SERVICE_ENABLED',
            default: true,
        ),

        /*
         * Path to service account json file. You can also pass the credentials as an array
         * instead of a file path.
         */
        'file' => env(
            key: 'GOOGLE_SERVICE_ACCOUNT_JSON_LOCATION',
            default: storage_path(
                path: 'google/industrial-silo-390411-2fd1ce1f9dee.json',
            ),
        ),
    ],

    /*
    |----------------------------------------------------------------------------
    | Additional config for the Google Client
    |----------------------------------------------------------------------------
    |
    | Set any additional config variables supported by the Google Client
    | Details can be found here:
    | https://github.com/google/google-api-php-client/blob/master/src/Google/Client.php
    |
    | NOTE: If client id is specified here, it will get over written by the one above.
    |
    */
    'config' => [],

    'spreadsheet_id' => env(
        key: 'GOOGLE_SPREADSHEET_ID',
        default: '1Sum1L6VJNXRroX11Iyqg8SSIqLmFK7BgMKmWBZApkAA',
    ),
    'sheet_name' => env(
        key: 'GOOGLE_SHEET_NAME',
        default: 'Sheet1',
    ),
];
