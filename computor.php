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

$poly = "5 * X - 4*X^2+9666+.663 * x^2        =1*X^0+x-3*x+3*x^1+6+ 4*x^1";

$poly2 = "5 + 4 * X + X^2= X^2";


function has_args_errors($argv) {

	// More than 1 argv supplied
//	if (count($argv) > 2 || count($argv) < 2) {
//		echo "Too many or too few arguments" . PHP_EOL;
//		echo "Usage: php computor.php \"equation\"" . PHP_EOL;
//
//		return TRUE;
//	}

	// More than 1 '=' signs
    $count_equals = substr_count($argv, '=');
	if($count_equals != 1) {
		echo "Wrong number of equals. Should be only 1";

		return TRUE;
	}

	// One side of equation has no arguments
	$exploded_parts = explode('=', $argv);
	if (empty(trim($exploded_parts[0])) || empty(trim($exploded_parts[1]))) {
		echo "Equation should contain smth on each side";

		return FALSE;
	}

	// Formatting is wrong.
    $term_pattern = '/([+|-]?([ ]?\d*[\.]?\d*[ ]?(\*)?[ ]?)?(([x|X]\^\d*[ ]?)|([x|X])))|([+|-]?[ ]?\d*)/';

    $left_part_cleaned = trim(preg_replace($term_pattern, '',$exploded_parts[0]));
    $right_part_cleaned = trim(preg_replace($term_pattern, '',$exploded_parts[1]));

    if (!empty($left_part_cleaned) || !empty($right_part_cleaned)) {
    	echo "Something wrong with equation.";

    	return FALSE;
	}

	return FALSE;
}



