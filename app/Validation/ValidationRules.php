<?php

namespace App\Validation;

use CodeIgniter\Validation\Validation;
use CodeIgniter\Validation\ValidationException;


class ValidationRules
{
    public function validateDateRange(string $str, string $field, array $data): bool
    {
        $from = strtotime($data[$data[1]]);
        $before = strtotime($str);

        return $before > $from;
    }
}
