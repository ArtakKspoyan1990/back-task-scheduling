<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreTaskRequest extends FormRequest
{

    /**
     * @return bool
     */
    public function authorize()
    {
        // Only authenticated users can create tasks
        return Auth::check();
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_at' => 'required|date',
            'status' => 'required|string',
            'assigned_user_id' => 'required|exists:users,id',
        ];
    }
}
