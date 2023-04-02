<?php

namespace Lukelt\PdfSignatures;

use InvalidArgumentException;

class Document
{
    public readonly string $file;
    public readonly string $content;

    public function __construct(string $file)
    {
        $this->file = $file;

        if (!file_exists($this->file) || pathinfo($this->file)['extension'] !== 'pdf')
            throw new InvalidArgumentException("Document not found.");

        $this->content();
    }

    private function content(): void
    {
        $this->content =  file_get_contents($this->file);
    }
}