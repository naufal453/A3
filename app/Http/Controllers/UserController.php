<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Ensure Auth is imported
use Illuminate\Routing\Controller; // Import the base Controller class
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // Import the trait

class UserController extends Controller
{
    use AuthorizesRequests; // Add this line to include the trait

    public function __construct()
    {
        $this->middleware('auth')->except('show');
    }

    public function show($username)
    {
        $user = User::with('posts')->where('username', $username)->firstOrFail();
        return view('dashboard.show', compact('user'));
    }

    public function edit($username)
    {
        $user = User::where('username', $username)->firstOrFail();

        $this->authorize('update', $user);

        return view('user.usersettings', compact('user'));
    }

    public function update(Request $request, $username)
    {
        $user = User::where('username', $username)->firstOrFail();

        $this->authorize('update', $user);

        // Validate the request data
        $validatedData = $request->validate([
            'username' => 'required|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed'
        ]);

        // Update user data
        $user->username = $validatedData['username'];
        $user->email = $validatedData['email'];

        if (!empty($validatedData['password'])) {
            $user->password = bcrypt($validatedData['password']);
        }

        $user->save();

        return redirect()->route('user.usersettings', ['username' => $user->username])
                         ->with('success', 'Profile updated successfully.');
    }

    // New method to mark notifications as read
    public function markNotificationsRead(Request $request)
    {
        $user = auth()->user();
        $user->unreadNotifications->markAsRead();

        return response()->json(['success' => true]);
    }
}
