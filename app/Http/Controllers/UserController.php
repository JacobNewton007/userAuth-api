<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;



class UserController extends Controller
{
  public function register(Request $request) {
    $fields = $request->validate([
      'name' =>'required|string',
      'email' => 'required|string|unique:users,email',
      'password' => 'required|string|confirmed'
    ]);

    $user = User::create([
      'name' => $fields['name'],
      'email' => $fields['email'],
      'password' => bcrypt($fields['password'])
    ]);

    $token = $user->createToken('myapptoken')->plainTextToken;

    $response = [
      'user' => $user,
      'token' => $token
    ];

    return response($response, 201);

  }

  public function loginUser(Request $request) {
    $fields = $request->validate([
      'email' => 'required|string',
      'password' => 'required|string'
    ]);

    // get user email. 
    $user = User::where('email', $fields['email'])->first();

    // password validation
    if(!$user || !Hash::check($fields['password'], $user->password)) {
      return response([
        'message' => 'invalid email or password'
      ], 401);
    }

    // create token
    $token = $user->createToken('myapptoken')->plainTextToken;

    $response = [
      'user' => $user,
      'token' => $token
    ];

    return response($response, 201);

  }

  /**
   * Display a listing of the user. 
   * @return \Illuminate\Http\Response
   */
  public function getAllUser() 
  {
    return User::all();
  }

  /**
   * Display a specific User Details
   * @param int $id
   * @return \Illuminate\Http\Response
   */

  public function getUserById($id) 
  {
    return User::find($id);
  }

  /**
   * Update a specific User Details
   * 
   * @param \Illuminate\Http\Request  $request
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function updateUser(Request $request, $id) 
   {
     $user = User::find($id);
     $user->update($request->all());
     return $user;
   }

   /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function deleteUser($id)
    {
        return User::destroy($id);

    }

  public function logout(Request $request) {
    auth()->user()->tokens()->delete();

    return [
      'message' => 'logged out'
    ];
  }
}
