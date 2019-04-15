<?php

namespace App\Http\Requests;


class ContactUsValidate extends APIRequest
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
        return [
            'name' => "required|regex:/^[.\'\-a-zA-Z ]+$/|max:100",
            'email' => 'required|email|max:100',
            'where' => 'required|string',
            'event_date' => 'required|date|before:today',
            'how_find' => 'nullable|string',
            'about' => 'required|string',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'name.regex' => "The name contains only alphabet."
        ];
    }

    /**
     * @return array
     */
    public function attributes()
    {
        return [
            'where' => 'event location'
        ];
    }
}
