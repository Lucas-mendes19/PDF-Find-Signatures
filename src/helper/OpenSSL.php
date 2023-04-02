<?php

namespace Lukelt\PdfSignatures\helper;

trait OpenSSL
{
    private static ?string $pathOpenSSL = null;

    private static function exec(string $pathInput, string $pathOutput): void
    {
        $openSSL = (self::$pathOpenSSL) ? '"' . self::$pathOpenSSL . '"' : "openssl";
        $Command = $openSSL . " pkcs7 -in {$pathInput} -inform DER -print_certs > {$pathOutput}";
        shell_exec($Command);
    }

    public static function defineOpenSSL(string $path): void
    {
        self::$pathOpenSSL = $path . '/openssl';
    }
}