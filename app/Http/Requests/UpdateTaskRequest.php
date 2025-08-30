<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateTaskRequest extends FormRequest
{

    /**
     * @return bool
     */
    public function authorize()
    {
        // Only authenticated users can update tasks
        return Auth::check();
    }


    /**
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'due_at' => 'sometimes|required|date',
            'status' => 'sometimes|required|string',
            'assigned_user_id' => 'sometimes|required|exists:users,id',
        ];
    }
}
