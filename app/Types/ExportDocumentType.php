<?php

namespace App\Types;

enum ExportDocumentType: string
{
    case Official = 'official';
    case OfficialRedacted = 'official_redacted';

    public function hideSensitiveInfo(): bool
    {
        return $this->value === self::OfficialRedacted->value;
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
