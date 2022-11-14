<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequet extends FormRequest
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
    public function rules()
    {
        return [
            'id' => 'required|integer|exists:tasks,id',
            'name' => 'nullable|string|min:5',
            'priority' => 'nullable|string|in:low,medium,high',
            'project_id' => 'nullable|integer|exists:projects,id'
        ];
    }
