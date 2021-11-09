<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class IndexController extends Controller
{
    public function version()
    {
        return ['version' => '1.0.0'];
    }

    public function userInfo($id)
    {
        return ['id' => $id];
    }

    public function userName(Request $request)
    {
        return ['name' => $request->get('name')];
    }

    public function userID(Request $request)
    {
        return ['id' => $request->header('X-Request-ID')];
    }

    public function debug()
    {
        return ['debug' => env('APP_DEBUG')];
    }

    public function register()
    {
        $exists = DB::table('users')->where('name', 'kinv')->first();
        if ($exists) {
            unset($exists->remember_token);
            unset($exists->email_verified_at);
            unset($exists->password);
            $exists = (array)$exists;
            return $exists;
        }
        $save = [
            'name' => 'kinv',
            'email' => 'kinvcode@gmail.com',
            'password' => Hash::make('123456')
        ];
        $user = new User($save);
        $user->save();
        return $user;
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|between:5,15',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return Response::json(['status' => -1, 'msg' => '账号或密码错误'], 401);
        }

        // 更新 api_key
        $api_token = uniqid($user->id);
        $user->api_token = $api_token;
        $user->save();

        return Response::json($user);
    }

    public function myCollection($id)
    {
        return ['info' => '正则表达式'];
    }
}
