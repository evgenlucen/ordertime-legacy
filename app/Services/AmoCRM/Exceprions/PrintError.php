<?php


namespace App\Services\AmoCRM\Exceprions;


use AmoCRM\Exceptions\AmoCRMApiException;

class PrintError
{
    public static function run(AmoCRMApiException $e)
    {
        $errorTitle = $e->getTitle();
        $code = $e->getCode();
        $debugInfo = var_export($e->getLastRequestInfo(), true);

        $error = <<<EOF
Error: $errorTitle
Code: $code
Debug: $debugInfo
EOF;

        echo '<pre>' . $error . '</pre>';
    }
}