<?php

namespace App\Http\Requests\Validations\FMP;

use App\Interfaces\CompanyProfileRequestInterface;

class FMPCompanyProfileRequest implements CompanyProfileRequestInterface
{
    public function rules()
    {
        return [
            'symbol' => 'required|string|alpha_num',
        ];
    }
}