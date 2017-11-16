<?php

$beginEndPatterns = [
    [
        'name' => 'quote',
        'begin' => '\'',
        'end' => '\'',
    ],
    [
        'name' => 'quote',
        'begin' => '"',
        'end' => '"',
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
        'begin' => '&',
        'end' => '\\n',
    ],
];
