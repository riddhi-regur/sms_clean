<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        DB::beginTransaction();

        try {
             $request->validate([
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

            $user = new User;
            $user->email =  $request->email;
            $user->password = Hash::make($request->password);
            $user->role_id = Role::ADMIN;
            $user->save();
            
             if (! $user->exists) {
                throw new Exception('User was not persisted.');
            }

             $admin = new Admin;
            $admin->name = $request->name;
            $admin->user_id = $user->id;
             $admin->save();
             
        event(new Registered($user));

        Auth::login($user);
DB::commit();
        return redirect(route('dashboard', absolute: false));
        }catch (Exception $e) {
            DB::rollBack();
           
              return redirect()->back()
            ->with('error', $e->getMessage())
            ->withInput();
        }
       
    }
}
