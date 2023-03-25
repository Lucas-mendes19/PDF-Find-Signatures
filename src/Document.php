<?php

namespace Lukelt\PdfSignatures;

use InvalidArgumentException;

class Document
{
    public readonly string $file;
    public readonly string $content;

    public function __construct($file)
    {
        $this->file = $file;

        // if (!file_exists($this->file) || pathinfo($this->file, PATHINFO_EXTENSION != 'pdf') || base64_decode($this->file, true) === false)
        //     throw new InvalidArgumentException("Unidentified document.");

        $this->content();
    }

    private function content()
    {
        if (file_exists($this->file))
            $this->content =  file_get_contents($this->file);
        
        if (base64_decode($this->file, true) === true)
            $this->content = base64_decode($this->file);
    }

    public static function tempPath(string $prefix = null, string $extension = 'txt'): string
    {
        return sys_get_temp_dir() . '/' . $prefix . rand() . '.' . $extension;
    }
}