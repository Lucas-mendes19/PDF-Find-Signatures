<?php

namespace Lukelt\PdfSignatures;

use Exception;
use Lukelt\PdfSignatures\helper\Temp;

/**
 * Document entity
 */
class Document
{
    use Temp;

    public readonly string $file;
    public readonly string $content;

    /**
     * @param string $file content file or path file
     * @return void
     */
    public function __construct(string $file)
    {
        if (file_exists($file) && pathinfo($file)['extension'] !== 'pdf')
            throw new Exception("Invalid document format.");
        
        if (!file_exists($file)) {
            $pathFile = $this->path('file_', 'pdf');
            file_put_contents($pathFile, $file);
            $file = $pathFile;
        }

        $this->file = $file;
        $this->content();
    }

    /**
     * Get file contents
     * @return void
     */
    private function content(): void
    {
        $this->content = file_get_contents($this->file);
    }
}