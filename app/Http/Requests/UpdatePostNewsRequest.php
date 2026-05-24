<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostNewsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'headline'        => 'required|max:255',
            'category_id'     => 'required|exists:categories,id',
            'date'            => 'required|date',
            'image'           => 'nullable|image|max:2048',
            'content'         => 'required',
            'meta_title'      => 'nullable|max:255',
            'meta_description'=> 'nullable',
            'meta_keywords'   => 'nullable',
            'status'          => 'required|in:draft,published,pending',
            'scheduled_for'   => 'nullable|date|after:now',
            'is_breaking'     => 'boolean',
        ];
    }
}
