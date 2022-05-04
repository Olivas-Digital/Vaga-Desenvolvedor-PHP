<?php

namespace Database\Factories;

use App\Models\DocumentType;

class DocumentTypeFactory
{
    protected static $docTypes = [
        'CPF' => 'Pessoa Física',
        'CNPJ' => 'Pessoa Jurídica'
    ];

    public static function generate()
    {
        foreach (self::$docTypes as $initials => $description) {
            $initialExists = DocumentType::where('initials', '=', $initials)->exists();

            if ($initialExists) continue;

            DocumentType::create(['initials' => $initials, 'description' => $description]);
        }
    }
}
