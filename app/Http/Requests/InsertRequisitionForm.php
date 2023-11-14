<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class InsertRequisitionForm extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function attributes()
    {
        $attributes = [];

        foreach ($this->allItems as $index => $item) {
            $attributes["allItems.$index.itemId"] = 'Item ID';
            $attributes["allItems.$index.ItemName"] = 'Item Name';
            $attributes["allItems.$index.codes"] = 'Codes';
            $attributes["allItems.$index.unit"] = 'Unit';
            $attributes["allItems.$index.estCost"] = 'Estimated Cost';
            $attributes["allItems.$index.Quantity"] = 'Quantity';
            $attributes["allItems.$index.errors"] = 'Errors';
        }
//        dd($attributes);

        return $attributes;
    }
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $errors = $validator->errors()->getMessages();

        // Map through the errors and change the keys
        $updatedErrors = [];
        foreach ($errors as $key => $messages) {
            // Extract index and attribute from the key
            $parts = explode('.', $key);
            $index = (int)$parts[1] + 1; // Increment the index by 1
            $attribute = $parts[2];

            // Add to the updatedErrors
            if (!isset($updatedErrors[$index])) {
                $updatedErrors[$index] = [];
            }
            $updatedErrors[$index][$attribute] = $messages[0];
        }

        // Throw a HttpResponseException with the modified error messages
        throw new HttpResponseException(
            response()->json(['errors' => $updatedErrors], 422)
        );
    }

    public function rules()
    {
        if ($this->status != 'Services') {
            // If the request has 'services', apply these rules
            return [
                'allItems.*.itemId' => 'required',
                'allItems.*.ItemName' => 'required',
                'allItems.*.codes' => 'required',
                'allItems.*.unit' => 'required',
                'allItems.*.EstCost' => 'required',
                'allItems.*.Quantity' => 'required',
            ];
        }
        else {
            return [
                'allItems.*.Detail' => 'required',
            ];
        }
    }

}
