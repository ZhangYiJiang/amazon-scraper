<?php

return [
    /**
     * -----------------------------------------------------------
     * Default and maximum pagesizes
     * -----------------------------------------------------------
     *
     * Defines the maximum and default number of items returned in a single page
     *
     */
    'pagesize' => [
        'default' => 30,
        'max' => 100,
    ],

    /**
     * -----------------------------------------------------------
     * Exclusions
     * -----------------------------------------------------------
     *
     * Defines the maximum and default number of items returned in a single page
     *
     */

    'exclusions' => [
        'books' => [
            'description',
            'url',
            'isbn',
            'asin',
            'created_at',
            'updated_at',
        ],

        'authors' => [
            'url',
            'bio',
            'created_at',
            'updated_at',
        ],

        'keywords' => [
            'updated_at',
            'created_at',
        ],
    ],
];