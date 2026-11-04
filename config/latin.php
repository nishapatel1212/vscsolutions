<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Python AI sidecar
    |--------------------------------------------------------------------------
    |
    | Technical/environment settings only. Business-identity facts (company
    | name, ABN, REC number, bank details, logo paths, etc.) live in the
    | company_settings database table instead — see App\Models\CompanySetting
    | and the company() helper in app/helpers.php.
    |
    */

    'python_path' => env('PYTHON_PATH', 'python'),
    'scripts_path' => base_path('python-scripts'),
];
