<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Imports\StudentsImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    // Method untuk menampilkan daftar siswa
    public function index(Request $request)
    {
        $search = $request->input('search');
    
        $students = Student::query()
            ->where('name', 'LIKE', "%{$search}%")
            ->orWhere('nis', 'LIKE', "%{$search}%")
            ->orWhere('class', 'LIKE', "%{$search}%")
            ->get();
    
        return view('pages.students', compact('students', 'search'));
    }    

    // Method untuk menyimpan siswa baru
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'nis' => 'required|unique:students,nis',
            'class' => 'required',
            'outstanding_balance' => 'required|numeric',
        ]);

        $validatedData['password'] = Hash::make($request->password);

        $student = Student::create($validatedData);

        // Assign role 'student' to the newly created student
        $student->assignRole('student');

        // Trigger registration event if you are using Laravel Breeze or Fortify
        event(new Registered($student));

        return redirect()->route('students')->with('success', 'Data siswa berhasil ditambahkan.');
    }

    
    // Method untuk menampilkan form edit siswa
    public function edit($id)
    {
        $student = Student::findOrFail($id);
        return view('students.edit', compact('student'));
    }
    
    // Method untuk memperbarui data siswa
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nis' => 'required|string|max:20|unique:students,nis,'.$id,
            'class' => 'required|string|max:50',
            'outstanding_balance' => 'required|numeric|min:0',
        ]);
    
        $student = Student::findOrFail($id);
        $student->update($request->all());
    
        return redirect()->route('students')->with('success', 'Data siswa berhasil diperbarui.');
    }

    // Method untuk menghapus data siswa
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();
    
        return redirect()->route('students')->with('success', 'Data siswa berhasil dihapus.');
    }

    // Method untuk menampilkan form import siswa
    public function showImportForm()
    {
        return view('import');
    }

    // Method untuk mengimport data siswa dari file Excel
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        Excel::import(new StudentsImport(), $request->file('file'));

        return redirect()->back()->with('success', 'Data siswa berhasil diimport.');
    }

    // Method untuk menampilkan form login untuk student
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Method untuk proses login student
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        // Pertama, coba login sebagai Admin (tabel users)
        if (Auth::guard('web')->attempt($request->only('email', 'password'))) {
            return redirect()->intended('dashboard');
        }

        // Jika gagal, coba login sebagai Student (tabel students)
        if (Auth::guard('student')->attempt($request->only('email', 'password'))) {
            return redirect()->intended('/student/dashboard');
        }

        // Jika kedua-duanya gagal, kembalikan dengan error
        throw ValidationException::withMessages([
            'email' => [trans('auth.failed')],
        ]);
    }

    // Method untuk logout student
    public function logout()
    {
        Auth::guard('student')->logout();
        return redirect()->route('student.login');
    }
}
