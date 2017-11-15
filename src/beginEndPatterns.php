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
        'name' => 'comment',
        'begin' => '/\\*',
        'end' => '\\*/',
    ],
];
