<?php 

// if (!has_args_errors($argv)) {
// 	echo "no errors";
// }
// var_dump($argv);
$poly = [
	'sign' => -1,
	'coef' => 1.3,
	'degree' => 2,
];

// echo (int) $poly["sign"] *  (float) $poly["coef"];

// >>> This section should be deleted!!! >>>
$poly = "5 * X - 4*X^2+9666+.663 * x^2        =1*X^0+x-3*x+3*x^1+6+ 4*x^1 +3x";

$argv = $poly;

// <<< This section should be deleted!!! <<<

function argv_has_errors($argv) {

    $error_message = '';
	// More than 1 argv supplied
//	if (count($argv) > 2 || count($argv) < 2) {
//		echo "Too many or too few arguments" . PHP_EOL;
//		echo "Usage: php computor.php \"equation\"" . PHP_EOL;
//
//		return TRUE;
//	}

    $poly = $argv; // $argv[1] - in the future for command line

	// More than one '=' signs
    $count_equals = substr_count($poly, '=');
	if($count_equals != 1) {
        $error_message .= "Wrong number of equals. Should be only 1." . PHP_EOL;
	}

	// One side of equation has no arguments
	$exploded_parts = explode('=', $poly);

	if (empty(trim($exploded_parts[0])) || empty(trim($exploded_parts[1]))) {
        $error_message .= "Equation should contain smth on each side." . PHP_EOL;
	}

	// Formatting is wrong.
    $term_pattern = '/([+|-]?([ ]?\d*[\.]?\d*[ ]?(\*)?[ ]?)?(([x|X]\^\d*[ ]?)|([x|X])))|([+|-]?[ ]?\d*)/';

    $left_part_cleaned = trim(preg_replace($term_pattern, '',$exploded_parts[0]));
    $right_part_cleaned = trim(preg_replace($term_pattern, '',$exploded_parts[1]));

    if (!empty($left_part_cleaned) || !empty($right_part_cleaned)) {
        $error_message .= "Something wrong with equation." . PHP_EOL;
	}

	//Degree is too high.
    preg_match_all('/\^\d*/', $poly, $poly_degrees_dirty);

    $poly_degrees_clean = str_replace('^', '', $poly_degrees_dirty[0]);
    $max_poly_degree = max($poly_degrees_clean);

    if (!empty($error_message)) {
        echo $error_message;

        return TRUE;
    }

    if ($max_poly_degree > 2) {
        // TODO: print Reduced form
        echo "Polynomial degree: $max_poly_degree" . PHP_EOL;
        echo "The polynomial degree is stricly greater than 2, I can't solve." . PHP_EOL;

        return TRUE;
    }

	return FALSE;
}

if (!argv_has_errors($argv)) {
	$poly = strtoupper(str_replace(' ', '', $argv)); // $argv[1] - in the future for command line
    $test = 1;
}



