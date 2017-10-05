<?php

namespace App\Http\Controllers;

use App\User;

class UserController extends Controller
{
    public function index()
    {
      $users = User::all();

      $data = $users->toArray();
      $links = [];

      foreach ($data as $key => $val) {
        $links[$key] = $val;
           $links[$key]['links'] = [
               '_links' => [
                   'self' => 'http://book-ap.dev/user/' . $val["id"]
               ]
           ];
       }

       return response()->json(
         [
           'response' => [
             'cookbooks' => $links
           ]], 200
         );
    }
}
