<?php

namespace Lukelt\PdfSignatures\helper;

trait Temp
{
    private static function path(string $prefix = null, string $extension = 'txt'): string
    {
        return sys_get_temp_dir() . '/' . $prefix . rand() . '.' . $extension;
    }
}