<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Auth;
use Hash;
use Illuminate\Http\Request;

use App\Models\User;

use App\Models\UserApplication;
use Validator;

class UserController extends Controller
{
    //
    public function account_info(){
        $all_c = false;
        $completed_c = false;
        if(Auth::user()->role == 'student'){
            $completed_c = count(json_decode(Auth::user()->completed_courses)->courses);
            $all_c = count(json_decode(Auth::user()->all_courses)->courses);
        }
       
        // dump($completed_c, $all_c);
        return view(Auth::user()->role.'/account', ['all_c'=>$all_c, 'completed_c'=>$completed_c]);
    }

    public function edit_account(Request $request){
        $data = [
            'name'=>$request->name,
            'email'=>$request->email
        ];
        $rules = [
            'name'=>'required|min:1',
            'email'=>'required|email|min:6',
        ];
        $mess =[
            'name.required'=>'Поле имя является обязательным!',
            'name.min'=>'Минимальная длина имени- 1 символ!',
            'email.required'=>'Поле почта- обязательное!',
            'email.email'=>'Введите корректную почту!',
            'email.min'=>'Минимальная длина почты- 6 символов',
        ];
        $validate = Validator::make($data, $rules, $mess);
        if($validate->fails()){
            return back()->withErrors($validate)->withInput();
        }
        else{
            if($request->email != Auth::user()->email){
                $check_email = User::select('*')->where('email', '=', $request->email)->get()->count();
                if(!$check_email){
                    $update = User::where('id', '=', Auth::user()->id)->update([
                        'email'=>$request->email, 
                        'name'=>$request->name
                    ]);
                }
                else{
                    return back()->withErrors(['success'=>'Пользователь с такой почтой уже есть!']);
                }
            
                // dd($check_email);
            }
            else{
                $update = User::where('id', '=', Auth::user()->id)->update([
                    'name'=>$request->name,
                    'email'=>$request->email
                ]);
            }
            // if($request->name != Auth::user()->name){
                
            // }

            if($update){
                return back()->withErrors(['success'=>'Успешное обновление данных!']);
            }
            else{
                return back()->withErrors(['error'=>'Не удалось обновить данные!']);
            }
        }
    }
    public function all_users_admin(){
        $all_users = User::select('id','name','email','role','password', 'blocked')->get();
        return view('admin/main', ['users'=>$all_users]);
    }

    public function change_blocked($id_user, $blocked){
        // dd($id_user, $blocked);
        $blocked = User::where('id', '=', $id_user)->update(['blocked'=>$blocked]);
        $all_users = User::select('id','name','email','role','password', 'blocked')->get();
        if($blocked){
            return back()->with(['mess'=>'Доступ изменен!', 'users'=>$all_users]);
        }
        else{
            return back()->with(['mess'=>'Не удалось изменить доступ!', 'users'=>$all_users]);
        }
    }

    public function users_appl(){
        $users_appl = UserApplication::select('user_applications.id','users.name', 'users.id as user_id','current_status','date', 'status_appl','wish_status')->join('users','users.id', '=', 'user_applications.user_id')->orderBy('date')->get();
        return view('admin/users_appl', ['users'=>$users_appl]);
    }

    public function new_pass(Request $request){
        $data = [
            'password'=>$request->password
        ];
        $rules = [
            'password'=>'required|min:6'
        ];
        $mess = [
            'password.required'=>'Заполните пароль!',
            'password.min'=>'Минимальная длина пароля- 6 символов!',
        ];
        $validate = Validator::make($data, $rules, $mess);
        if($validate->fails()){
            return back()->withErrors($validate);
        }
        else{
            $new_pass = User::where('id', '=', Auth::user()->id)->update([
                'password'=>Hash::make($request->password)
            ]);
            if($new_pass){
                return back()->withErrors(['success'=>'Успешное изменение пароля!']);
            }
            else{
                return back()->withErrors(['error'=>'Не удалось изменить пароль!']);
            }
        }
    }
// 'id_user'=>$user->user_id, 'id_appl'=>$user->id, 'role'=>$user->wish_status, 'status_appl'=>'Принята'
    public function change_role($id_user, $id_appl, $role, $status_appl){
        // dd($id_user, $id_appl, $role, $status_appl);
        if($status_appl == 'Принята'){
            $update_role = User::where('id','=',$id_user)->update(['role'=>$role]);
            if($update_role){
                $update_user_appl = UserApplication::where('id','=', $id_appl)->update(['status_appl'=>$status_appl]);
                return back()->with(['mess'=>'Успешное изменение роли!']);
            }
            else{
                return back()->with(['mess'=>'Не удалось изменить роль']);
            }
        }else{
            $update_user_appl = UserApplication::where('id','=', $id_appl)->update(['status_appl'=>$status_appl]);
            return back()->with(['mess'=>'Успешная отмена заявки!']);
        }
    }

    public function start_study($id_course){
        $old_array = User::select('all_courses')->where('id', '=', Auth::user()->id)->get()[0]->all_courses;
        // dump($old_array);
        if($old_array == null){
            $new_array['courses'] = [$id_course];
            $new_array = json_encode($new_array);
            // dd($new_array);
        }
        else{
            $old_array = json_decode($old_array)->courses;
            $new_array['courses'] = [];
            foreach($old_array as $oa){
                array_push($new_array['courses'], intval($oa));
            }

            array_push($new_array['courses'], intval($id_course));
            $new_array = json_encode($new_array);
            
        }
        $update_all_courses = User::where('id', '=', Auth::user()->id)->update([
            'all_courses'=>$new_array
        ]);
        $old_student_count = Course::select('student_count')->where('id', '=', $id_course)->get()[0]->student_count;
        $update_course_student_count = Course::where('id', '=', $id_course)->update([
            'student_count'=>$old_student_count+1
        ]);
        if($update_all_courses){
            return redirect()->route('one_course_main', ['id_course'=>$id_course])->withErrors(['success'=>'Вы получили этот курс!']);
        }
        else{
            return back()->withErrors(['success'=>'Не удалось получить этот курс!']);
        }
    }

    public function complete_course($id_course){
        $complete_check = User::where('id', '=', Auth::user()->id)->select()->get()[0]->completed_courses;
        // $complete_courses = [];
        if($complete_check == null){
            $complete_courses['courses'] = [$id_course];
            $complete_courses = json_encode($complete_courses);
        }
        else{
            $complete_check = json_decode($complete_check)->courses;
            $complete_courses['courses'] = [];
            foreach($complete_check as $co){
                array_push($complete_courses['courses'], intval($co));
            }
            array_push($complete_courses['courses'], intval($id_course));
            $complete_courses = json_encode($complete_courses);
            // dd($complete_courses, $id_course);
        }
        $update_completed_courses = User::where('id', '=', Auth::user()->id)->update([
            'completed_courses'=>$complete_courses
        ]);
        if($update_completed_courses){
            return redirect()->route('one_course_main', ['id_course'=>$id_course])->withErrors(['success'=>'Вы завершили этот курс!']);
        }
        else{
            return back()->withErrors(['success'=>'Не удалось завершить этот курс!']);
        }
        // dd($id_course, $complete_check);
    }
}
