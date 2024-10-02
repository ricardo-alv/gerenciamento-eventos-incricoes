<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateEvent extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $url = $this->segment(3);

        return [
            'name' => "required|min:3|max:255|unique:events,name,{$url},id",
            'location' => ['required', 'min:3', 'max:255'],
            'start_date' => ['required', 'date', 'before_or_equal:end_date'],  // A data de início deve ser anterior ou igual à data de término
            'end_date' => ['required', 'date', 'after_or_equal:start_date'], // A data de término deve ser posterior ou igual à data de início
            'capacity' => ['required'],
            'description' => ['nullable', 'min:3', 'max:10000'],
            'category_id' => ['required', 'exists:categories,id'],
        ];
    }
}
