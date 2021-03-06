<?php
define("inputFile", 'data.csv');
define("outputFile", '../grammars/language-openedge-abl.json');
define("regEx_Spaces", '([ ]|\t)*');
define("regEx_CaseInsensitive", '(?i)');
define("regEx_Multiline", '(?m)');
define("regEx_EscapeChar", '(?<!~)');
define("regEx_BeginOfWord", '\t|^|(?<=[ ])|\(');
define("regEx_EndOfWord", '\t|\r|(?=[ ])|[\.|:]?' . regEx_Spaces . '\n|\(');




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
foreach ($sortedData as $key => $value) {
    $RegexBegin = regEx_BeginOfWord;
    $RegexEnd = regEx_EndOfWord;
    switch ($key) {
        case 'Preprocessor':
            break;
        case 'Keyword':
            break;
        case 'Statement':
            break;
        case 'Type':
            $RegexEnd = regEx_EndOfWord . "|" . bracketify(regEx_Spaces . "\)");
            $RegexEnd .= "|" . bracketify(regEx_Spaces . ",");
            break;
        case 'JumpStatement':
            break;
        case 'Untranslatable':
            $RegexBegin = regEx_BeginOfWord . "|" . bracketify("\"?");
            break;
        default:
            continue;
        break;
    }

    addPattern(strtolower($key), bracketify(implode('|', $value)), $RegexBegin, $RegexEnd);
}

addPattern('integer', '(\d+)');
addPattern('decimal', '(\d*\.\d+)');

/* Write to file */
$fp = fopen(outputFile, 'w');
fwrite($fp, json_encode($outputArray));
fclose($fp);

function addPattern($name, $regex, $beginRegex = '', $endRegex = '') {
    global $outputArray;
    if ($beginRegex == '') {
        $beginRegex =  regEx_BeginOfWord;
    }
    if ($endRegex == '') {
        $endRegex = regEx_EndOfWord;
    }
    $pattern = [];
    $pattern['captures']['2']['name'] = $name;
    $pattern['match'] = sprintf('(%s)%s%s(%s)', $beginRegex, regEx_CaseInsensitive . regEx_Multiline, $regex, $endRegex);
    array_push($outputArray["patterns"], $pattern);
}

function bracketify($string) {
    return '(' . $string . ')';
}
