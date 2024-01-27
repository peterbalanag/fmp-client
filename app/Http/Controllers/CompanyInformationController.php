<?php

namespace App\Http\Controllers;

use App\Interfaces\CompanyProfileRequestInterface;
use App\Interfaces\DataProviderInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class CompanyInformationController extends Controller
{
    protected $dataProvider;
    protected $profileRequestValidator;

    public function __construct(
        DataProviderInterface $dataProvider,
        CompanyProfileRequestInterface $profileRequestValidator
    ) {
        $this->dataProvider = $dataProvider;
        $this->profileRequestValidator = $profileRequestValidator;
    }

    public function getCompanyInformation(Request $request)
    {
        try {

            // request validation
            $validator = Validator::make($request->all(), $this->profileRequestValidator->rules());

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            } else {
                $data = $validator->validated();
            }

            // this endpoint expects one result only
            $result = $this->dataProvider->getCompanyProfile($data['symbol']);

            return response([
                'company_profile'   => $result[0]
            ]);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
