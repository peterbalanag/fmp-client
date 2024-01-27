<?php

namespace App\Http\Controllers;

use App\Interfaces\CompanyQuoteRequestInterface;
use App\Interfaces\DataProviderInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompanyQuoteController extends Controller
{
    protected $dataProvider;
    protected $quoteRequestValidator;

    public function __construct(
        DataProviderInterface $dataProvider,
        CompanyQuoteRequestInterface $quoteRequestValidator
    ) {
        $this->dataProvider = $dataProvider;
        $this->quoteRequestValidator = $quoteRequestValidator;
    }

    public function getFullCompanyQuote(Request $request)
    {
        try {
            // request validation
            $validator = Validator::make($request->all(), $this->quoteRequestValidator->rules());

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            } else {
                $data = $validator->validated();
            }

            // this endpoint expects one result only
            $result = $this->dataProvider->getCompanyQuote($data['symbol']);

            return response([
                'company_quote'   => $result[0]
            ]);
        }
         catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
