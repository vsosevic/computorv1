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

$poly = "5 * X^0 -d 4 * X^1 9666.663 * X^2 = 1 * X^0
8 * X^0 - 6 * X^1 + 0 * X^2 - 66665.6 * X^3 = 3 * X^0
 5 * X^0 - 6 * X^1 + 0 * X^2 - 5.6 * X^3 = 9 * x^0 + 9";

 $poly2 = "5 + 4 * X + X^2= X^2";

$test = preg_match('/([+|-]?[ ]?\d*[\.]?\d*[ |]\*[ |][x|X]\^\d)|([+|-]?[ ]?\d)/', $poly);

var_dump($test);

function has_args_errors($argv) {

	if (count($argv) > 2 || count($argv) < 2) {
		echo "Too many or too few arguments" . PHP_EOL;
		echo "Usage: php computor.php \"equation\"" . PHP_EOL;

		return TRUE;
	}
	else {
		return FALSE;
	}

}

function has_one_equal_sign($argv) {
	
}

?>
