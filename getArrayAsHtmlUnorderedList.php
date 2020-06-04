<?php

function getArrayAsHtmlUnorderedList($array) 
{
	if (!is_array($array)) return;

	foreach ($array as $field => $value) {
		if (is_array($value)) {
			$value = getArrayAsHtmlUnordenatedList($value);
		}
		if (is_bool($value)) {
			$value = $value ? "true" : "false";
		}
		$rows[] = is_numeric($field) 
			? "<li>{$value}</li>" 
			: "<li><i><b>{$field}:</b> {$value}</i></li>";
	}

	$rows = !empty($rows) ? implode(PHP_EOL, $rows) : null;
	
	return PHP_EOL . "<ul>" . PHP_EOL . $rows . PHP_EOL . "</ul>" . PHP_EOL;
}


$arr["nome"] = "Mateus";
$arr["idade"] = 24;
$arr["freela_disponivel"] = true;
$arr["remoto"] = true;
$arr["experiencias"] = [
	"Foco" => 6,
	"SalvadorCard" => 24
];
$arr["habilidades"] = [
	"php" => [
		"nivel" => "intermediario",
		"laravel" => true,
	]
];
$arr["idiomas"] = [
	"portugues",
	"ingles",
];

//$arr = ["foo" , "bar"];

echo getArrayAsHtmlUnordenatedList("teste");