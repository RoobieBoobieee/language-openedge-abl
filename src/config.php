<?php

$beginEndPatterns = [
    [
        'name' => 'quote',
        'begin' => '(?<!~)\'',
        'end' => '(?<!~)\'',
    ],
    [
        'name' => 'quote',
        'begin' => '(?<!~)"',
        'end' => '(?<!~)"',
    ],
    [
        'name' => 'include',
        'begin' => '{',
        'end' => '}',
    ],
    [
        'name' => 'block-comment',
        'begin' => '/\\*',
        'end' => '\\*/',
    ],
    [
        'name' => 'interpreter',
        'begin' => '^([ ]|\t)*&',
        'end' => '(?<!~)\\n',
    ],
];

$escapableCharacters = [
    '~"',
    '~\'',
    '~~',
    '~\\',
    '~{',
    '~n',
    '~t',
    '~r',
    '~n',
    '~E',
    '~b',
    '~f',
];

$regex = [
    'Default' => [
        'Characters' => [
            ',',
            ':',
        ],
        'Specials' => [
            '\n'
        ]
    ],
    'Preprocessor' => [
        'Option' => [
            'Characters' => [
                ',',
                ':',
            ],
        ]
    ],
    'Keyword' => [

    ],
    'Statement' => [

    ],
    'Type' => [

    ],
    'JumpStatement' => [

    ],
    'Untranslatable' => [

    ],
];
