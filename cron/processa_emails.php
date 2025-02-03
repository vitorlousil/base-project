<?php

require '../vendor/autoload.php';

use BaseProject\Email;

$email = new Email();
$email->processarFila(5);

echo "Processo de e-mails concluído.\n";
