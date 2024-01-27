<?php

namespace App\Http\Requests\Validations\FMP;

use App\Interfaces\CompanyQuoteRequestInterface;

class FMPCompanyQuoteRequest implements CompanyQuoteRequestInterface
{
    public function rules()
    {
        return [
            'symbol' => 'required|string|alpha_num',
        ];
    }
}