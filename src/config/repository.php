<?php
declare(strict_types=1);

return [

    'criteria' => [
        'acceptedConditions' => [
            '=',
            'like'
        ],

        'params' => [
            'search' => 'search',
            'searchFields' => 'searchFields',
            'filter' => 'filter',
            'orderBy' => 'orderBy',
            'sortedBy' => 'sortedBy',
            'with' => 'with',
            'searchJoin' => 'searchJoin'
        ]
    ],

    'generator' => [
        'basePath' => app()->path(),
        'rootNamespace' => 'App\\',
        'stubsOverridePath' => app()->path(),
        'paths' => [
            'repositories' => 'Repositories',
            'interfaces' => 'Repositories',
            'validators' => 'Validators',
            'criteria' => 'Criteria'
        ]
    ]
];
