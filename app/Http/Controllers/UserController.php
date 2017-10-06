<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Hashing\BcryptHasher;

class UserController extends Controller
{

  public function index()
  {
    $users = User::all();

    $data = $users->toArray();
    $links = [];

    foreach ($data as $key => $val) {
      $links[$key] = $val;
         $links[$key]['_links'] = [
           'self' => 'http://book-ap.dev/user/' . $val["id"]
         ];
     }

     return response()->json(
       [
         'response' => [
           'users' => $links
         ]], 200
       );
  }

    /**
     * Create a new user resource.
     */
    public function store(Request $request)
    {
      $response = [];
      $status = 1;

      $this->validate(
        $request, [
          'name' => 'required',
          'email' => 'required|unique:users|email',
          'password' => 'required'
        ]
      );

      $name = $request->input('name');
      $email = $request->input('email');
      $password = $request->input('password');
      $hashedPassword = (new BcryptHasher)->make($password);

      $user = new User(
          [
              'name' => $name,
              'email' => $email,
              'password' => $hashedPassword
          ]
      );

      try {
        if ($user->save()) {
          $response["created"] = true;
          $response['_links'] = [
            'self' => 'http://book-ap.dev/user/' . $user->id
          ];
          $status = 201;
        }
      } catch (Exception $e) {
        $response["error"] = $e->getMessage();
        $status = 422;
      }

      return response()->json([
        'response' => $response
      ], $status);
    }

    /**
    * Get one user from the database
    */
    public function find($userId)
    {
      $response = [];
      $status = 200;

      $user = self::userExist($userId);

      if(! $user ) {
        $response['error'] = 'User not found.';
        $status = 404;
      } else {
        $response['response'] = $user;
      }

      return response()->json([
        'response' => $response
      ], $status);
    }

    /**
    * Implement a full/partial update
    */
    public function update(Request $request, $userId)
    {
      $response = [];
      $status = 1;

      $user = self::userExist($userId);

      if (! $user || $user === null) {
        $response["error"] = 'User not found.';
        $status = 404;
      } else {
        $fields = $request->only('name', 'password');
        foreach ($fields as $key => $val)
        {
          if ($val !== null || !is_null($val)) {
            $user->$key = $val;
          }
        }

        try {
          if ($user->save()) {
            $response["updated"] = true;
            $status = 200;
          }
        } catch (Exception $e) {
          $response["error"] = $e->getMessage();
          $status = 422;
        }
      }

      return response()->json(
        [
          'response' => $response
        ], $status);
    }

    /**
    * Delete a resource
    */
    public function delete($userId)
    {
      $response = [];
      $status = 1;

      $user = self::userExist($userId);

      if (! $user || $user === null) {
        $response["error"] = 'User not found.';
        $status = 404;
      } else {
        try {
          if ($user->delete()) {
            $response["deleted"] = true;
            $status = 202;
          }
        } catch (Exception $e) {
          $response["error"] = $e->getMessage();
          $status = 422;
        }
      }

      return response()->json(
        [
          'response' => $response
        ], $status);
    }

    /**
    * Check if user exist by id
    */
    protected static function userExist($id)
    {
      return User::find($id) ?? false;
    }
}
