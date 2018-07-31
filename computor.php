<?php 

const TERM_REGULAR_PATTERN = '/([+|-]?([ ]?\d*[\.]?\d*[ ]?(\*)?[ ]?)?(([x|X]\^\d*[ ]?)|([x|X])))|([+|-]?[ ]?\d*)/';

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
$poly = "3+5 * X - 4*X^2+9666+.663 * x^2        =0*X^0+x-3*x+3*x^1+6+ 4*x^1 +3x+x+x+3x+x^+3x+4+5";

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
    $left_part_cleaned = trim(preg_replace(TERM_REGULAR_PATTERN, '',$exploded_parts[0]));
    $right_part_cleaned = trim(preg_replace(TERM_REGULAR_PATTERN, '',$exploded_parts[1]));

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
    $poly_exploded = explode('=', $poly);

    $poly_left = $poly_exploded[0];
    $poly_right = $poly_exploded[1];

//    $left_terms = create_poly_array($poly_left);
    $right_terms = create_poly_array($poly_right);

    $test = 1;
}

function create_poly_array($poly) {
    $terms_array = [];
    preg_match_all(TERM_REGULAR_PATTERN, $poly,$terms_array);

    $terms_array = array_filter($terms_array[0]);

    $term_arr = [];

    foreach ($terms_array as $term) {
        $sign = 1;
        $coef = 0;
        $degree = 0;

        // Define sign
        if (strpos($term, '-') !== false) {
            $sign = -1;
        }

        // Define number
        preg_match('/(\d+)?\.?\d+/', $term, $matched_number);
        $coef = empty($matched_number) ? 1 : (float) $matched_number[0];

        //Define degree
        preg_match('/X[\^]?(\d+)?/', $term,$matched_degree);
        if (!empty($matched_degree)) {
            $degree = isset($matched_degree[1]) ? $matched_degree[1] : 1;
        }

        $term_arr[] = [
            'sign' => $sign,
            'coef' => $coef,
            'degree' => $degree,
        ];
    }

    return $term_arr;
}



