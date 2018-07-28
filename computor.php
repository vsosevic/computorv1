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

echo (int) $poly["sign"] *  (float) $poly["coef"];


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

?>
