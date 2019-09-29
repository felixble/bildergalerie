<?php

// include the constants that differ from each local installation (see .env.sample for an example)
$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

define('DB_HOST', getenv('DB_HOST'));
define('DB_USER', getenv('DB_USER'));
define('DB_PASS', getenv('DB_PASS'));
define('DB_DATABASE', getenv('DB_DATABASE'));
define('DB_CHARSET', getenv('DB_CHARSET'));
define('DB_PORT', getenv('DB_PORT'));
define('IS_DEBUG', getenv('IS_DEBUG') == 'true');

define('reCAPTCHA_SECRET_KEY', getenv('reCAPTCHA_SECRET_KEY'));

define('MANDANT_EMAIL', getenv('MANDANT_EMAIL'));
define('SENDER_EMAIL_ADDRESS', getenv('SENDER_EMAIL_ADDRESS'));
define('ERROR_EMAIL', getenv('ERROR_EMAIL'));

define('PASSWORD_PEPPER', getenv('PASSWORD_PEPPER'));