<?php

namespace App\Services;

use App\Models\Faculty;
use App\Models\Role;
use App\Models\User;
use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Configuration\Configuration;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class FacultyService
{
    public function getAllFaculty()
    {
        return Faculty::select(['id', 'name', 'image', 'phone', 'address', 'designation', 'user_id',  'department_id'])->with('user:id,email')
            ->with('department:id,name')->get();
    }

    public function createFaculty(array $data)
    {
        $user = new User;
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->role_id = Role::FACULTY;
        $user->save();

        if (isset($data['image'])) {
            Configuration::instance();
            $upload = (new UploadApi)->upload($data['image']->getRealPath(), [
                'folder' => 'admins',
            ]);
            $image = $upload['secure_url'];
            // $image = $data['image']->store('admins', 'public');
        }

        $faculty = new Faculty;

        $faculty->name = $data['name'];
        $faculty->user_id = $user->id;
        $faculty->phone = $data['phone'] ?? null;
        $faculty->image = $image ?? null;
        $faculty->address = $data['address'] ?? null;
        $faculty->designation = $data['designation'] ?? null;
        $faculty->department_id = $data['department_id'];

        $faculty->save();

        return $faculty;
    }

    public function updateFaculty($id, $data)
    {
        $faculty = Faculty::findOrFail($id);
        if (isset($data['image'])) {
            Configuration::instance();
            $upload = (new UploadApi)->upload($data['image']->getRealPath(), [
                'folder' => 'admins',
            ]);

            $data['image'] = $upload['secure_url'];
            // $data['image'] = $data['image']->store('admins', 'public');
        }

        $faculty->update($data);

        if (isset($data['email']) && $faculty->user) {
            $faculty->user->update([
                'email' => $data['email'],
            ]);
        }

        return $faculty;
    }

    public function deleteFaculty($id)
    {
        try {
            $faculty = Faculty::findOrFail($id);

            if ($faculty->image) {
                Storage::disk('public')->delete($faculty->image);
            }

            if ($faculty->user) {
                $faculty->user->delete();
            }

            $faculty->delete();
        } catch (QueryException $e) {
            // Foreign key restrict error
            throw new \Exception('Cannot delete this faculty because it has assigned.');
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
