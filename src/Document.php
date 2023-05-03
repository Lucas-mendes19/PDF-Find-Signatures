<?php

namespace Lukelt\PdfSignatures;

use InvalidArgumentException;

/**
 * Document entity
 */
class Document
{
    public readonly string $file;
    public readonly string $content;

    /**
     * @param string $file content file or path file
     * @return void
     */
    public function __construct(string $file)
    {
        $this->file = $file;

        if (!file_exists($this->file) || pathinfo($this->file)['extension'] !== 'pdf')
            throw new InvalidArgumentException("Document not found.");

        $this->content();
    }

    /**
     * Get file contents
     * @return void
     */
    private function content(): void
    {
        $this->content =  file_get_contents($this->file);
    }
}