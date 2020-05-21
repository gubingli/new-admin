<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2020/1/20
 * Time: 10:46
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Faker\Provider\Image;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Util\RegularExpression;
use Tymon\JWTAuth\Facades\JWTAuth;

class HomeController extends Controller
{
    public function index()
    {
       return  Banner::where(['status'=>1])->orderBy('sort','desc')->get();
        return '我是后台';
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $customer = Auth::guard('customers')->attempt($credentials);
        try {
            if(isset($customer) && $customer){

                return $this->respondWithToken($customer);

            }else{
                $token = JWTAuth::attempt($credentials);
                if (!$token) {
                    return response()->json(['error' => 'invalid_credentials'], 401);
                } else{
                    return $this->respondWithToken($token);
                }
            }

        } catch (Exception $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }


    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('customers')->factory()->getTTL() * 60
        ]);
    }

    public function test(Request $request)
    {
        return view('admin.home');
    }

    public function upload(Request $request)
    {
        //return $request->file('file');
        if($request->isMethod('POST')) {

            $fileCharater = $request->file('file');

            if ($fileCharater->isValid()) {

                //获取文件的扩展名
                $ext = $fileCharater->getClientOriginalExtension();

                //获取文件的绝对路径
                $path = $fileCharater->getRealPath();

                //定义文件名
                $filename = date('Y-m-d-h-i-s') . '.' . $ext;

                //存储文件。disk里面的public。总的来说，就是调用disk模块里的public配置
                Storage::disk('public')->put($filename, file_get_contents($path));
             return $this->response->array(['url' => $filename])->setStatusCode(201);
            }
        }

        return view('admin.home');
    }
}