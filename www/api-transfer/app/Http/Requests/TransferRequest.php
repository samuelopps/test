<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        $update = [
            'amount' => 'required|numeric|min:0|not_in:0',
        ];

        switch($this->method())
        {
            case 'PATCH':
            {
                return [
                    $update
                ];
            }
            break;
            case 'PUT':
                return [
                    $update
                ];
            break;
            case 'POST':
            {
                return [
                    'amount' => 'required|numeric|min:0|not_in:0',
                    'paying_purse_id' => 'required|exists:users,id',
                    'receiver_purse_id' => 'required|exists:users,id',
                ];
            }
            break;
            default:
            {
                return [];
            }
            break;
        }
    }
}
