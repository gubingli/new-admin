<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::where(['status'=>1])->orderBy('sort','desc')->get();
        return $banners;
    }

    public function add(Request $request)
    {
        $request->validate([
            'banner_url'=>'required',
        ],[
            'banner_url'=>'图片url'
        ]);
       $data['banner_url'] = $request->banner_url;
       $data['status'] = $request->status ?? 1;
       $data['sort'] = $request->sort ?? 0;
       if($request->id) {
           $banners = Banner::where(['id'=>$request->id])->update($data);
       }else{
           $banners = Banner::create($data);
       }

        return $this->response->array(['message'=>'操作成功','data'=>$banners])->setStatusCode(200);
    }

    public function del()
    {
        return '我是轮播图删除';
    }
}
