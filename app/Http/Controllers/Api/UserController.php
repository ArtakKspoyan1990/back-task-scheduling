<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);

        return User::select('id', 'name', 'email', 'is_available', 'role')
            ->where('role', 'customer')
            ->paginate($perPage);
    }


    /**
     * @param $id
     * @return mixed
     */
    public function toggleAvailability($id)
    {
        $user = User::findOrFail($id);

        // Ensure only customers can be toggled
        if ($user->role !== 'customer') {
            return response()->json(['message' => 'Only customers can be toggled'], 403);
        }

        $user->is_available = !$user->is_available;
        $user->save();

        return response()->json($user);
    }
}
