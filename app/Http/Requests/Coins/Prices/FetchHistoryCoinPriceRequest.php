<?php

namespace App\Http\Requests\Coins\Prices;

use Illuminate\Foundation\Http\FormRequest;

class FetchHistoryCoinPriceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'symbol' => $this->symbol,
        ]);
    }

    public function rules()
    {
        return [
            'symbol' => 'required|exists:coins,symbol',
        ];
    }
}
