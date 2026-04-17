<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Throwable;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $validated = $request->validateWithBag('updatePassword', [
                'current_password' => ['required', 'current_password'],
                'password' => ['required', Password::defaults(), 'confirmed'],
            ]);

            $request->user()->update([
                'password' => Hash::make($validated['password']),
            ]);

            DB::commit();

            return back()->with('status', 'password-updated');

        } catch (ValidationException $e) {

            throw $e;
        } catch (Throwable $e) {
            DB::rollBack();

            Log::error('Password update failed: '.$e->getMessage());

            return back()
                ->with('error', 'Something went wrong while updating password.')
                ->withInput();
        }
    }

    public function edit()
    {
        return view('profile.update-password-form');
    }
}
