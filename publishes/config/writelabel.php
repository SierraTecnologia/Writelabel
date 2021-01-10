<?php

return [

    /**
     * Features
     */
    'features' => [
        'point_types' => [
            'active' => true,
            'model' => \WriteLabel\Models\Routine::class,
        ],
        'tasks' => [
            'active' => true,
            'model' => \WriteLabel\Models\Task::class,
        ],
        'metas' => [
            'active' => true,
            'model' => \WriteLabel\Models\Meta::class,
        ],
    ],
    /**
     * Extensions
     */
    'extensions' => [
        'routines' => [
            'active' => true,
            'model' => \WriteLabel\Models\Routine::class,
        ],
        'tasks' => [
            'active' => true,
            'model' => \WriteLabel\Models\Task::class,
        ],
        'metas' => [
            'active' => true,
            'model' => \WriteLabel\Models\Meta::class,
        ],
    ],

    // Attributes Database Tables
    'services' => [

        'pointagram' => env('SERVICES_POINTAGRAM_KEY', null),

    ],

    // Attributes Database Tables
    'tables' => [

        'teste' => 'teste',

    ],

];

