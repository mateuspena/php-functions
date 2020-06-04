<?php

/**
 * Get a JSON object as array, removing the all empty keys.
 *
 * @author Mateus Pena.
 * @param string $json
 * @param bool $without_empties
 * @return array
 * @see https://www.php.net/manual/pt_BR/migration70.new-features.php Operador de coalescência nula.
 * @see https://pt.stackoverflow.com/questions/77072/ Implementando Closures Recursivas.
 */
function getJsonAsArray($json, $without_empties=true)
{
    $array = json_decode($json, true) ?? [];

    $array_filter = function($array) use (&$array_filter) {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $array[$key] = $array_filter($value);
            }
            if ($array[$key]===null || $array[$key]===[] || $array[$key]==="") {
                unset($array[$key]);
            }
        }
        return $array;
    };

    return $without_empties ? $array_filter($array) : $array;
}

$json = "{\"lancamentos\":[{\"teste2\":[{\"lvl2\":\"\", \"lvl2_2\":\"mateus\"}],\"teste\":\"\",\"data\":\"2020-05-20\",\"uid\":\"842AC035B7787F7F412963EF39E99DDE\",\"tipo_lancamento_id\":1,\"nome\":\"Lancha\",\"id\":9,\"valor\":150,\"conta_id\":2}],\"lancamentos_deletados\":[],\"hotel_id\":\"734\"}";

print_r( ["original" => getJsonAsArray($json, false), "without" => getJsonAsArray($json)] );

// Análise de Performance
	// função nativa.
	$begin = microtime(true);
	$decoded = json_decode($json, true) ?? [];
	$native = microtime(true) - $begin;

	// minha função.
	$begin = microtime(true);
	$decoded = getJsonAsArray($json);
	$function = microtime(true) - $begin;

	echo "Função Nativa: {$native} seconds." 
			. PHP_EOL 
			. "Minha Função: {$function} seconds." 
			. PHP_EOL
			. "Diff: " . ($function - $native) . " seconds."
			. PHP_EOL;