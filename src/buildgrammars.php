<?php
define("inputFile", 'data.csv');
define("outputFile", '../grammars/language-openedge-abl.json');
define("regEx_CaseInsensitive", '(?i)');
define("regEx_Multiline", '(?m)');
define("regEx_BeginOfWord", '(^|[ \t]+)');
define("regEx_EndOfWord", '(\n|\r|$|[ \t]+|[ \t]*\.[ \t]*\n)');

include('beginEndPatterns.php');

/* csv file to array */
$data = array_map( function($v) {
    return str_getcsv($v, ";");
}, file(inputFile));

array_walk($data, function(&$a) use ($data) {
    $a = array_combine($data[0], $a);
});

/* Remove column header */
array_shift($data);

$outputArray = [];
$outputArray["name"] = "OpenEdge ABL";
$outputArray["scopeName"] = "source.OpenEdgeABL";
$outputArray["limitLineLength"] = false;
$outputArray["fileTypes"] = [
    "p",
    "w",
    "i",
    "cls",
];
$sortedData = [];
$sortedData['Type'] = [];

foreach ($data as $key => $value) {
    $foo = &$sortedData[$value['syntax_highlight_type']];
    if (!$foo) {
        $foo = [];
    }
    array_push($foo, $value['keyword']);
}

$outputArray["patterns"] = [];


foreach ($beginEndPatterns as $key => $value) {
    $pattern = [];
    $pattern['name'] = $value['name'];
    $pattern['begin'] = $value['begin'];
    $pattern['end'] = $value['end'];
    array_push($outputArray["patterns"], $pattern);
}

$pattern[][] = [];

addPattern('decimal', '|', '(\d*\.\d+)');
addPattern('integer', '|', '(\d+)');

foreach ($sortedData as $key => $value) {
    addPattern(strtolower($key), implode('|', $value));
}

/* Write to file */
$fp = fopen(outputFile, 'w');
fwrite($fp, json_encode($outputArray));
fclose($fp);

function addPattern($name, $regex) {
    global $outputArray;
    $pattern = [];
    $pattern['captures']['2']['name'] = $name;
    $pattern['match'] = regEx_BeginOfWord . $regex . regEx_EndOfWord . regEx_CaseInsensitive . regEx_Multiline;
    array_push($outputArray["patterns"], $pattern);
}
