<?php

namespace Lukelt\PdfSignatures;

class Certificate
{
    private readonly array $data;

    public readonly string $version;
    public readonly string $name;
    public readonly string $identifier;
    public readonly array $issuer;
    public readonly array $validity;

    public function __construct(array $data, string $format = 'Y-m-d H:i:s')
    {
        $this->data = $data;
        $this->version = $data['version'];
        
        $subject = explode(':', $data['subject']['CN']);
        $this->name = $subject[0];
        $this->identifier = $subject[1];

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