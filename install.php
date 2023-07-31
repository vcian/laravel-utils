<?php

require_once __DIR__ . '/src/Console/Thanks.php';

use Vcian\LaravelUtils\Console\Thanks;

// Call the Thanks class to execute the script
(new Thanks(new \Symfony\Component\Console\Output\ConsoleOutput()))->__invoke();
