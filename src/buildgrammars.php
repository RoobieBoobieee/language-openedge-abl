<?php
$inputFile = 'data.csv';
$outputFile = 'grammars/language-abl.json';
/* csv file to array */
$data = array_map('str_getcsv', file($inputFile));
array_walk($data, function(&$a) use ($data) {
  $a = array_combine($data[0], $a);
});

/* Remove column header */
array_shift($data);

/* Sort by Sytax Type */
usort($myArray, function($a, $b) {
    return $a['syntax_highlight_type'] <=> $b['syntax_highlight_type'];
});
/* end csv file to array */

$outputArray = [];
$outputArray["name"] = "OpenEdge Advanced Business Language (ABL)";
$outputArray["scopeName"] = "OpenEdge Advanced Business Language (ABL)";
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
  array_push($foo, $value['syntax_highlight_type']);
}

foreach ($sortedData as $key => $value) {
  switch ($key) {
    case 'value':
      $pattern['name'] = '';
      break;

    default:
      # code...
      break;
  }
  $pattern['match'] .= '\b(' . implode('|', $value).  ')\b';
  array_push($outputArray["patterns"], $pattern);
}
