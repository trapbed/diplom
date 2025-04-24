<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class AuthController extends Controller
{
    //
    public function signup(Request $request){
        $data = [
            'name'=>$request->name,
            'email'=>$request->email,
            'pass'=>$request->pass
        ];
        $rules = [
            'name'=>'required|min:6',
            'email'=>'required|min:6|email|unique:users',
            'pass'=>'required|regex:/^[a-zA-Z0-9_]+$/|min:6'
        ];
        $messages = [
            'name.required'=>'Заполните имя',
            'name.min'=>'Минимальная длина имени- 6 символов',
            'email.required'=>'Заполните почту',
            'email.min'=>'Минимальная длина почты- 6 символов',
            'email.email'=>'Проверьте введенную почту',
            'email.unique'=>'Пользователь с такой почтой существует!',
            'pass.required'=>'Заполните пароль',
            'pass.min'=>'Минимальная длина пароля- 6 символов',
            'pass.regex'=>'Пароль может содержать только латиницу, цифры и символ нижнего подчеркивания'
        ];
        $validate = Validator::make($data, $rules, $messages);
        if($validate->fails()){
            return redirect('signup')
            ->withErrors($validate)
            ->withInput();
        }
        else{
            $user = User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'role'=>'student',
                'password'=>Hash::make($request->pass),
            ]);
            Auth::login($user);
            if(Auth::user()->role == 'student'){
                return redirect()->route('main');

            }
            else if(Auth::user()->role == 'author'){
                return redirect()->route('main_author');

            }
            else if(Auth::user()->role == 'admin'){
                return redirect()->route('main_admin');

            }
        }
    }
    public function login_db(Request $request){
        $user_check = User::where('email', '=', $request->email)->exists();
        if(strlen(trim($request->email))!= 0 && strlen(trim($request->pass))!=0){
            if($user_check){
                $user = User::select('id', 'email', 'password')->where('email', '=', $request->email)->get()[0];
                $pass = $user->password;
                $id = $user->id;
                if(Hash::check($request->pass, $pass)){
                    Auth::login( User::find($id));
                    if(Auth::user()->role == 'student'){
                        return redirect()->route('main');
        
                    }
                    else if(Auth::user()->role == 'author'){
                        return redirect()->route('main_author');
        
                    }
                    else if(Auth::user()->role == 'admin'){
                        return redirect()->route('main_admin');
        
                    }
                }
                else{
                    return back()->withErrors([
                        'pass'=>'Неверный пароль'
                    ])->withInput();
                }
            }
            else{
                return back()->withErrors([
                    'email'=>'Нет такого пользователя'
                ])->withInput();
            }
        }
        else{
            return back()->withErrors(['empty'=>'Заполните все поля!'])->withInput();
        }
        
    }
    public function logout(){
            Auth::logout();
            return redirect()->route('login');
    }

    public function recover_acc(Request $request){
        $check_email = User::where('email', '=', $request->email)->exists();
        if($check_email){
            $array = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z', 
                      'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z', 0, 1, 2,3, 4, 5, 6, 7, 8, 9 ];
            $random = array_rand($array, 8);
            $new_pass = '';
            foreach($random as $r){
                $new_pass.=$array[$r];
            }
            $set_pass = User::where('email', '=', $request->email)->update([
                'password'=>Hash::make($new_pass)
            ]);
            if($set_pass){
                if(mail($request->email, "Временный пароль", "Ваш временный пароль ".$new_pass)){
                    return redirect()->route('login')->withErrors(['err'=>'Сообщение с временным паролем отправлено!']);
                }
                else{
                    return back()->withErrors(['err'=>'Не удалось отправить временный пароль!']);
                }
            }
            else{
                return back()->withErrors(['mess'=>'Не удалось сохранить временный пароль!']);
            }
        }else{
            return back()->withErrors(['error'=>'Нет такого пользователя!']);
        }
    

    }

}
