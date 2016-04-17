<html>
<?php
/**
 * @namespace Wsk
 * @package Phpsypt
 * @subpackage Standard
 * @category encryption
 * @return Digestic encrypted string
 * @author Kev Wis* <wiskev@gmail.com>
 * @see Jasypt (Java simplified encryption) <http://www.jasypt.org/>
 * @version (beta) 0.1.0
 */

require_once 'Standard/Byte/Digester.php';

/**
 *
 * Phpsypt - sample digest post to Jasypt 1.9
 *
 * Jasypt is a java library which allows the developer
 * to add basic encryption capabilities to his/her projects
 * with minimum effort, and without the need of having deep
 * knowledge on how cryptography works.
 *
 *
 */

try {

  $message = null;
	$data = array (
			"userParam" => "MYUSER",
			"passwordParam" => "MYPASSWORD",
			"styleCSSParam" => "http:/localhost/style.css",
			"urlRetourParam" => "http://localhost/form.php"
	);

	if (is_array($data) && !empty($data)) {
		$message = "MESSAGE=TEST";
		foreach ( $data as $param => $value ) {
			$message .= "|{$param}={$value}";
		}

		$message = utf8_encode($message);
		$message = Wsk_Phpsypt_Standard_Byte_Digester::digest ( $message ) ;
	}


} catch ( Exception $e ) { echo $e->getMessage (); }

?>
    <head>
        <title>PHP TO JASYPT (1.9)</title>
    </head>

    <body>

    <?php if (empty($_POST)): ?>
        <form id="secureForm" method="POST" action="http://localhost/jasypt.jsf">
            <input type="hidden" name="secureKey" value="<?php echo $message ?>" />
            <?php foreach ($data as $name => $value): ?>
            <input type="hidden" name="<?php echo $name ?>" value="<?php echo $value ?>" />
            <?php endforeach; ?>
            <button type="submit"><span>TEST</span></button>
        </form>
    <?php else: ?>
        <pre><?php print_r($_POST) ?></pre>
    <?php endif; ?>
    </body>
</html>
