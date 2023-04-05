<?php

namespace Lukelt\PdfSignatures;

use DateTime;

class Certificate
{
    // private readonly array $data;

    public readonly string $version;
    public readonly string $name;
    public readonly array $issuer;
    public readonly array $validity;

    public function __construct(array $data, string $format = 'Y-m-d H:i:s')
    {
        // $this->data = $data;

        $this->version = $data['version'];
        $this->name = $data['subject']['CN'];
        $this->issuer($data);
        $this->validity($data, $format);
    }

    private function issuer($data): array
    {
        return $this->issuer = [
            'organization' => $data['issuer']['O'],
            'country' => $data['issuer']['C'],
        ];
    }

    private function validity($data, string $format = 'Y-m-d H:i:s'): array
    {
        return $this->validity = [
            'validFrom' => date($format, $data['validFrom_time_t']),
            'validTo' => date($format, $data['validTo_time_t']),
        ];
    }
}