<?php
$inputFile = 'data.csv';
$outputFile = '../grammars/language-openedge-abl.json';
/* csv file to array */
$data = array_map( function($v) {
    return str_getcsv($v, ";");
}, file($inputFile));

array_walk($data, function(&$a) use ($data) {
    $a = array_combine($data[0], $a);
});

/* Remove column header */
array_shift($data);

/* Sort by Sytax Type */
// usort($data, function($a, $b) {
//     return $a['syntax_highlight_type'] <=> $b['syntax_highlight_type'];
// });
/* end csv file to array */

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

foreach ($data as $key => $value) {
    $foo = &$sortedData[$value['syntax_highlight_type']];
    if (!$foo) {
        $foo = [];
    }
    array_push($foo, $value['keyword']);
}

$outputArray["patterns"] = [];
foreach ($sortedData as $key => $value) {
    $pattern = [];
    switch ($key) {
        case 'Preprocessor':
            $pattern['name'] = 'preprocessor';
            break;
        case 'Keyword':
            $pattern['name'] = 'keyword';
            break;
        case 'Statement':
            $pattern['name'] = 'statement';
            break;
        case 'Type':
            $pattern['name'] = 'type';
            break;
        case 'JumpStatement':
            $pattern['name'] = 'jumpstatement';
            break;
        default:
            continue;
        break;
    }
    $pattern['match'] = '\b(' . implode('|', $value).  ')\b';
    array_push($outputArray["patterns"], $pattern);
}

/* Write to file */
$fp = fopen($outputFile, 'w');
fwrite($fp, json_encode($outputArray));
fclose($fp);
