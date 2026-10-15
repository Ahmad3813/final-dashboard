<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        return view('profile.view', compact('user'));
    }
    public function edit(Request $request)
    {

        $user = $request->user();
        return view('profile.edit', compact('user'));
    }
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'ends_with:.com',
                'unique:users,email,' . $user->id,
            ],
            'current_password' => [
                'nullable',
                'required_with:password',
                'string',
            ],
            'password' => [
                'nullable',
                'required_with:current_password',
                'string',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[^A-Za-z0-9]/',
                'confirmed',
            ],
        ]);

        if (!empty($validated['password'])) {
            if (!Hash::check($validated['current_password'], $user->password)) {
                return back()
                    ->withErrors([
                        'current_password' => 'Your current password is incorrect.',
                    ])
                    ->withInput();
            }

            $user->password = Hash::make($validated['password']);
        }
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);



        return redirect()
            ->route('view-profile')
            ->with('success', 'Profile updated successfully.');
    }
}
