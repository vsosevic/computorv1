<?php

const TERM_REGULAR_PATTERN = '/([+|-]?([ ]?\d*[\.]?\d*[ ]?(\*)?[ ]?)?(([x|X]\^\d*[ ]?)|([x|X])))|([+|-]?[ ]?\d*)/';

// >>> This section should be deleted!!! >>>
// TODO: handle 'x^2' properly.
$poly = "254523123123123123123123454x^2 =0";

$argv = $poly;

// <<< This section should be deleted!!! <<<

/**
 * Check argv from user along with equation correctness.
 *
 * @param $argv
 *
 * @return bool
 */
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

    if (!isset($exploded_parts[0]) || !isset($exploded_parts[1])) {
        $error_message .= "Equation should contain smth on each side." . PHP_EOL;
    }

    // Formatting is wrong.
    $left_part_cleaned = trim(preg_replace(TERM_REGULAR_PATTERN, '',$exploded_parts[0]));
    $right_part_cleaned = trim(preg_replace(TERM_REGULAR_PATTERN, '',$exploded_parts[1]));

    if (!empty($left_part_cleaned) || !empty($right_part_cleaned)) {
        $error_message .= "Something wrong with equation." . PHP_EOL;
    }

    if (!empty($error_message)) {
        echo $error_message;

        return TRUE;
    }

    //Degree is too high.
    preg_match_all('/\^\d*/', $poly, $poly_degrees_dirty);

    $poly_degrees_clean = str_replace('^', '', $poly_degrees_dirty[0]);
    $max_poly_degree = !empty($max_poly_degree) ? max($poly_degrees_clean) : 0;

    if ($max_poly_degree > 2) {
        // TODO: print Reduced form
        echo "Polynomial degree: $max_poly_degree" . PHP_EOL;
        echo "The polynomial degree is stricly greater than 2. I can't solve." . PHP_EOL;

        return TRUE;
    }

    return FALSE;
}

if (!argv_has_errors($argv)) {
    $poly = strtoupper($argv); // $argv[1] - in the future for command line
    $poly_exploded = explode('=', $poly);

    $poly_left = $poly_exploded[0];
    $poly_right = $poly_exploded[1];

    $left_terms = create_reduced_poly_array($poly_left);
    $right_terms = create_reduced_poly_array($poly_right);

    $reduced_leftside_terms_array = add_two_terms_arrays($left_terms, $right_terms);

    print_terms_array($reduced_leftside_terms_array, true);

}

function create_reduced_poly_array($poly) {

    $terms_array_raw = [];

    preg_match_all(TERM_REGULAR_PATTERN, $poly, $terms_array_raw);

    $terms_array_raw = array_filter(array_map('trim',$terms_array_raw[0]));

    $term_array_reduced = [];

    foreach ($terms_array_raw as $term) {
        $current_coef = 0;
        $current_degree = 0;

        // Define number
        preg_match('/[\-]?[\d+]?\.?\d+/', $term, $matched_number); // searching for >>>3.3<<< * X
        $current_coef = empty($matched_number) ? 1 : (float) $matched_number[0];

        //Define degree
        preg_match('/X[\^]?(\d+)?/', $term,$matched_degree); // searching for X ^ >>>2<<<

        if (!empty($matched_degree)) {
            $current_degree = isset($matched_degree[1]) ? (int) $matched_degree[1] : 1;
        }

        // Don't save zero terms
        if ($current_coef == 0) {
            continue;
        }

        // Reduced form or just new array.
        if (!empty($term_array_reduced[$current_degree])) {
            $term_array_reduced[$current_degree]['coef'] += $current_coef;
        }
        else {
            $term_array_reduced[$current_degree] = [
                'coef' => $current_coef,
                'degree' => $current_degree,
            ];
        }

    }

    ksort($term_array_reduced);

    return $term_array_reduced;
}

function negate_terms_array(&$terms_array) {
    if (!empty($terms_array)) {
        foreach ($terms_array as &$term) {
            $term['coef'] *= -1;
        }
    }
}

function add_two_terms_arrays($left_terms, $right_terms) {
    $resulting_array = [];

    negate_terms_array($right_terms);

    for ($degree = 0; $degree <=2; $degree++) {
        $left_terms_coef = empty($left_terms[$degree]) ? 0 : $left_terms[$degree]['coef'];
        $right_terms_coef = empty($right_terms[$degree]) ? 0 : $right_terms[$degree]['coef'];

        $resulting_coef = $left_terms_coef + $right_terms_coef;

        if ($resulting_coef != 0) {
            $resulting_array[$degree] = [
                'coef' => $resulting_coef,
                'degree' => $degree,
            ];
        }
    }

    return $resulting_array;
}

function print_terms_array($terms_array, $print_like_equation = false) {
    if (empty($terms_array)) {
        echo '0 = 0' . PHP_EOL . 'All the real numbers are solution';

        return;
    }

    $output = 'Reduced form: ';

    foreach ($terms_array as $degree => $term) {
        switch ($degree) {
            case 0:
                $output .= $term['coef'] . " ";
                break;
            case 1:
                if ($term['coef'] >= 0) { $output .= '+';};
                if ($term['coef'] == 1) { $term['coef'] = '';};
                $output .= $term['coef'] . 'x';
                break;
            case 2:
                if ($term['coef'] >= 0) { $output .= '+';};
                if ($term['coef'] == 1) { $term['coef'] = '';};
                $output .= $term['coef'] . 'x^2';
                break;
        }
    }
    if ($print_like_equation) {
        $output .= ' = 0';
    }

    echo $output;
}

// TODO: implement solve_reduced_equation() function
function solve_reduced_equation($reduced_leftside_terms_array) {

}