<?php

namespace App\Types;

enum ExportDocumentType: string
{
    case Official = 'official';
    case OfficialRedacted = 'official_redacted';
    case Friendly = 'friendly';

    public function hideSensitiveInfo(): bool
    {
        return $this->value === self::OfficialRedacted->value;
    }

    public function getViewName(): string
    {
        return match ($this) {
            self::Official => 'documents.official2017',
            self::OfficialRedacted => 'documents.official2017',
            self::Friendly => 'documents.friendly',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
