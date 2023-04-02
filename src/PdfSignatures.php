<?php
 
namespace Lukelt\PdfSignatures;

use Exception;
use Lukelt\PdfSignatures\helper\OpenSSL;
use Lukelt\PdfSignatures\helper\Temp;

class PdfSignatures
{
    use Temp, OpenSSL;

    private static string $file;
    private static string $content;
    private static array $displacements;

    private static array $exec;

    public static function find(string $file)
    {
        $document = new Document($file);

        self::$file = $document->file;
        self::$content = $document->content;

        return self::displacementFind()::signatures();
    }

    public static function displacementFind()
    {
        $result = [];
        $regexp = '#ByteRange\[\s*(\d+) (\d+) (\d+)#';
        
        preg_match_all($regexp, self::$content, $result);  
        unset($result[0], $result[1]);
        $point = array_filter($result);

        if (empty($point))
            throw new Exception("Does not have digital signatures");

        for ($index = 0; $index < count($result[2]); $index++) { 
            self::$displacements[] = [
                'start' => $point[2][$index],
                'end' => $point[3][$index]
            ];
        }

        return self::class;
    }

    public static function signatures(): array
    {
        $signaturesContent = [];

        foreach (self::$displacements as $displacement) {
            if ($stream = fopen(self::$file, 'rb')) {
                $signature = stream_get_contents(
                    $stream,
                    $displacement['end'] - $displacement['start'] - 2,
                    $displacement['start'] + 1
                );
                
                fclose($stream);
                
                $pathCertificate = self::path('pfx_', 'pfx');
                file_put_contents($pathCertificate, hex2bin($signature));
            }
        
            $pathText = self::path('der_', 'txt');
            self::exec($pathCertificate, $pathText);
            unlink($pathCertificate);

            $data = self::processCertificate($pathText);
            unlink($pathText);

            $plainTextContent = openssl_x509_parse(end($data));
            $signaturesContent[] = $plainTextContent;
        }

        return $signaturesContent;
    }

    private static function processCertificate(string $path): array
    {
        $data = preg_split("/\\n\\r/", file_get_contents($path));
        return array_filter($data, fn($cert) => strlen($cert) > 2);
    }
}