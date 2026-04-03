<?php

namespace App\Enum;

enum FieldTypeEnum: string
{
    case TEXT = 'text';
    case NUMBER = 'number';
    case SELECT = 'select';
    case DATE = 'date';
    case TEXTAREA = 'textarea';

    public static function labels(): array
    {
        return [
            self::TEXT->value => 'Text Input',
            self::NUMBER->value => 'Number',
            self::SELECT->value => 'Dropdown List',
            self::DATE->value => 'Date Picker',
            self::TEXTAREA->value => 'Long Text',
        ];
    }
}
