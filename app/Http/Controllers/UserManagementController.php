<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\PreventsSelfManagement;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class UserManagementController extends Controller
{
    use PreventsSelfManagement;
    public function index()
    {
        $users = User::all();

        return view('admin.users', compact('users'));
    }

    public function destroy(Request $request, $id)
    {

        $this->preventSelfManagement($request, $id);


        $user = User::findOrFail($id);

        $hasTasks = Task::where('assigned_to', $user->id)
            ->orWhere('added_by', $user->id)
            ->exists();

        if ($hasTasks) {
            return back()->with(
                'error',
                'This user has related tasks. Reassign or remove those tasks before deleting the account.'
            );
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }
    public function edit(Request $request, $id)
    {
        $this->preventSelfManagement($request, $id);

        $user = User::findOrFail($id);

        $teachers = Teacher::whereNull('user_id')
            ->orWhere('user_id', $user->id)
            ->orderBy('name')
            ->get();

        $students = Student::whereNull('user_id')
            ->orWhere('user_id', $user->id)
            ->orderBy('name')
            ->get();

        return view('admin.manage-user', compact('user', 'teachers', 'students'));
    }


    public function updateRole(Request $request, $id)
    {
        $this->preventSelfManagement($request, $id);

        $validated = $request->validate([
            'role' => 'required|in:user,admin,super_admin,qa,tester,teacher,student,school_admin',
            'teacher_id' => 'required_if:role,teacher|nullable|integer|exists:teachers,id',
            'student_id' => 'required_if:role,student|nullable|integer|exists:students,id',
        ]);

        DB::transaction(function () use ($id, $validated) {
            $user = User::findOrFail($id);
            $record = null;

            if ($validated['role'] === 'teacher') {
                $record = Teacher::whereKey($validated['teacher_id'])
                    ->lockForUpdate()
                    ->firstOrFail();
            }

            if ($validated['role'] === 'student') {
                $record = Student::whereKey($validated['student_id'])
                    ->lockForUpdate()
                    ->firstOrFail();
            }

            if ($record && $record->user_id !== null && (int) $record->user_id !== (int) $user->id) {
                throw ValidationException::withMessages([
                    $validated['role'] === 'teacher' ? 'teacher_id' : 'student_id'
                    => 'This record is already linked to another account.',
                ]);
            }

            Teacher::where('user_id', $user->id)->update(['user_id' => null]);
            Student::where('user_id', $user->id)->update(['user_id' => null]);

            if ($record) {
                $record->update(['user_id' => $user->id]);
            }

            $user->update(['role' => $validated['role']]);
        });

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User role updated successfully.');
    }
}
