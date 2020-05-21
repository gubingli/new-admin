<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2020/1/20
 * Time: 10:46
 */
namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{

   public function index()
   {
      $user =  $this->user();
      $user =  User::where('id',$user->id)->get();

      return $this->response->array(['data' => $user])->setStatusCode(201);
   }

}