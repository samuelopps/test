<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurseRequest extends FormRequest
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
            'balance' => 'required|numeric|min:0|not_in:0',
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
                    'balance' => 'required|numeric|min:0|not_in:0',
                    'user_id' => 'required|exists:users,id',
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
