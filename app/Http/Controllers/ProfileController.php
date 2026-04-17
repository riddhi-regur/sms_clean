<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Role;
use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Configuration\Configuration;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
            'admin' => $request->user()->admin,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $user = $request->user();

            $user->fill($request->validated());

            if ($user->isDirty('email')) {
                $user->email_verified_at = null;
            }

            $user->save();

            if ($user->role_id === Role::ADMIN && $user->admin) {

                $image = $user->admin->image;

                if ($request->hasFile('image')) {
                    Configuration::instance();

                    $upload = (new UploadApi)->upload(
                        $request->file('image')->getRealPath(),
                        ['folder' => 'admins']
                    );

                    $image = $upload['secure_url'];
                }

                $user->admin->update([
                    'name' => $request->name,
                    'image' => $image,
                    'phone' => $request->phone,
                    'address' => $request->address,
                ]);
            }

            DB::commit();

            return Redirect::route('profile.edit')
                ->with('status', 'profile-updated');

        } catch (Exception $e) {
            DB::rollBack();

            // Log actual error for debugging
            Log::error('Profile update failed: '.$e->getMessage());

            return Redirect::back()
                ->with('error', 'Something went wrong while updating profile.')
                ->withInput();
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
