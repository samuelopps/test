<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'required|max:255',
            'email' => 'required|email:rfc,dns|unique:users,email,'.$this->email,
            'password' => 'required|min:6|max:255',
            'document' => 'required|min:11|max:14|unique:users,document,'.$this->document,
            'profile' => 'required|in:common,storekeeper',
            'status' => 'in:active,inactive'
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
                    'name' => 'required|max:255',
                    'email' => 'required|email:rfc|unique:users',
                    'password' => 'required|min:6|max:255',
                    'document' => 'required|min:11|max:14|unique:users',
                    'profile' => 'required|in:common,storekeeper',
                    'status' => 'in:active,inactive'
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
