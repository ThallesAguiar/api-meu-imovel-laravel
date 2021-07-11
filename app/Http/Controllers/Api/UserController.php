<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);

        return response()->json($users);
    }


    public function store(UserRequest $request)
    {
        $data = $request->all();

        if (!$request->has('password') || !$request->get('password')) {
            $erro = new ApiMessages('Password is required.');
            return response()->json($erro->getMessage(), 401, ['Accept' => 'application/json']);
        }

        Validator::make($data, [
            'phone' => 'required',
            'mobile_phone' => 'required',
        ]);

        try {
            $data['password'] = bcrypt($data['password']);

            $user = User::create($data);

            // referencia
            $user->profile()->create(
                [
                    'phone' => $data['phone'],
                    'mobile_phone' => $data['mobile_phone']
                ]
            );

            return response()->json(['success' => 'User created.']);
        } catch (\Exception $e) {
            $erro = new ApiMessages($e->getMessage());
            return response()->json($erro->getMessage(), 401, ['Accept' => 'application/json']);
        }
    }


    public function show($id)
    {
        try {
            $user = User::with('profile')->findOrFail($id);
            $user->profile->social_networks = unserialize($user->profile->social_networks);

            return response()->json($user);
        } catch (\Exception $e) {
            $erro = new ApiMessages($e->getMessage());
            return response()->json($erro->getMessage(), 401, ['Accept' => 'application/json']);
        }
    }


    public function update(Request $request, $id)
    {
        $data = $request->all();

        if ($request->has('password') && $request->get('password')) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        Validator::make($data, [
            'profile.phone' => 'required',
            'profile.mobile_phone' => 'required',
        ]);

        try {
            $profile = $data['profile'];
            $profile['social_networks'] = serialize($profile['social_networks']);

            $user = User::findOrFail($id);
            $user->update($data);

            $user->profile()->update($profile);

            return response()->json(['success' => 'User updated']);
        } catch (\Exception $e) {
            $erro = new ApiMessages($e->getMessage());
            return response()->json($erro->getMessage(), 401, ['Accept' => 'application/json']);
        }
    }


    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete($user);

            return response()->json(['success' => 'User ' . $id . ' deleted']);
        } catch (\Exception $e) {
            $erro = new ApiMessages($e->getMessage());

            return response()->json($erro->getMessage(), 401, ['Accept' => 'application/json']);
        }
    }
}
