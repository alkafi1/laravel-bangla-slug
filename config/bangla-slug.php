<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Separator
    |--------------------------------------------------------------------------
    |
    | The default separator to use when generating a slug. For example,
    | "আমার সোনার বাংলা" will become "আমার-সোনার-বাংলা" with a "-" separator.
    |
    */
    'separator' => '-',

    /*
    |--------------------------------------------------------------------------
    | Keep English Characters
    |--------------------------------------------------------------------------
    |
    | By default, the slug generator will keep English letters and numbers.
    | Set this to false if you want to strictly keep only Bengali characters
    | and numbers.
    |
    */
    'keep_english' => true,

    /*
    |--------------------------------------------------------------------------
    | Maximum Length
    |--------------------------------------------------------------------------
    |
    | Set the maximum length of the generated slug. If set to null, it will
    | not truncate the string. When it truncates, it ensures the string
    | is trimmed cleanly.
    |
    */
    'max_length' => null,

    /*
    |--------------------------------------------------------------------------
    | Custom Replacements
    |--------------------------------------------------------------------------
    |
    | You can define custom character or word replacements before the slug
    | generation takes place. Useful for replacing symbols with words.
    | Example: ['@' => 'এট', '&' => 'এবং']
    |
    */
    'replacements' => [
        // '@' => 'এট',
        // '&' => 'এবং',
    ],
];
