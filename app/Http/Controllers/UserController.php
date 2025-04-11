<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index(){
        $users = User::all();
        return view('user-management',compact('users'));
    }
    // public function updateRole(Request $request, $id)
    // {
    //     $user = User::findOrFail($id);
    
    //     // Validate the role input
    //     $request->validate([
    //         'role' => 'required|in:1,2,3', // Ensure role is 1, 2, or 3
    //     ]);
    
    //     // Update the user's role
    //     $user->role = $request->role;
    //     $user->save();
    
    //     return redirect()->back()->with('success', 'User role updated successfully!');
    // }
    
    
    public function show($id)
    {
        $user = User::findOrFail($id);
    
        $authUser = auth()->user();
    
        // If no authenticated user, redirect to the login page
        if (!$authUser) {
            return redirect('/')->with('error', 'You need to log in to access this page.');
        }
    
        // Check if the logged-in user's role is not Admin (role != 1)
        if ($authUser->role != 1) {
            return redirect('/users')->with('warning', 'You do not have admin privileges.');
        }
    
        return view('user-auth', compact('user'));
    }
    
    
    
    public function view(User $authUser, User $user)
    {
        dd($authUser->role, $user->id);
        return $authUser->role == 1 || $authUser->id === $user->id;
    }
    

    public function create()
    {
        return view('user-create'); // Return the form for creating a user
    }
    

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'nullable|email|max:255|unique:users',
            'role' => 'required|in:1,2,3',
            'password' => 'required|string',
            'status' => 'required|integer|in:0,1',  
        ]);
    
        // Log the validated data
        Log::info('Validated Data:', $validatedData);
    
        try {
            User::create([
                'fullname' => $request->fullname,
                'username' => $request->username,
                'email' => $request->email,
                'role' => $request->role,
                'password' => bcrypt($request->password),
                'status' => $request->status,
                'isactive' => $request->has('isactive'),
            ]);
    
            // Log success
            Log::info('User successfully created.');
        } catch (\Exception $e) {
            // Log errors
            Log::error('Error creating user:', ['message' => $e->getMessage()]);
            return back()->with('error', 'Failed to create user.');
        }
    
        return redirect('users')->with('success', 'User created successfully!');
    }
    

    public function edit($id){

        $users = User::all();
        return view('user-edit',compact('users'));
    }
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $authUser = auth()->user();
    
        // If no authenticated user, redirect to the login page
        if (!$authUser) {
            return redirect('/')->with('error', 'You need to log in to access this page.');
        }
    
        // Check if the logged-in user's role is not Admin (role != 1)
        if ($authUser->role != 1) {
            return redirect('/users')->with('warning', 'You do not have admin privileges.');
        }
    
        if ($request->isMethod('get')) {
            // Handle GET request to display the user data
            return view('user-auth', compact('user'));
        } elseif ($request->isMethod('post') || $request->isMethod('put')) {
            // Handle POST/PUT request to update the user data
            $request->validate([
                'fullname' => 'required|string',
                'username' => 'required|string|unique:users,username,' . $user->id,
                'email' => 'required|email|unique:users,email,' . $user->id,
                'role' => 'required|string',
            ]);
    
            $user->update([
                'fullname' => $request->fullname,
                'username' => $request->username,
                'email' => $request->email,
                'role' => $request->role,
                'isactive' => $request->has('isactive'),
            ]);
    
            return redirect()->route('users.index')->with('success', 'User updated successfully');
        }
    
        // Fallback in case of an invalid request method
        return redirect()->route('users.index')->with('error', 'Invalid request.');
    }
    
}
