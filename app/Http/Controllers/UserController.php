<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Grade;
use App\Models\LessonTest;
use Auth;
use Hash;
use Illuminate\Http\Request;

use App\Models\User;

use App\Models\UserApplication;
use Illuminate\Support\Facades\DB;
use Validator;

class UserController extends Controller
{
    public function account_info(){
        $all_c = 0;
        $completed_c = 0;
        if(Auth::user()->role == 'student'){
            if(Auth::user()->completed_courses != null){
                $completed_c = count(json_decode(Auth::user()->completed_courses)->courses);
            }
            if(Auth::user()->all_courses != null){
                $all_c = count(json_decode(Auth::user()->all_courses)->courses);
            }
        }
        return view(Auth::user()->role.'/account', ['all_c'=>$all_c, 'completed_c'=>$completed_c]);
    }

    public function edit_account(Request $request){
        $data = [
            'name'=>$request->name,
            'email'=>$request->email
        ];
        $rules = [
            'name'=>'required|regex:/^[А-Я]{1}[а-я]+\s(([А-Я]{1}[а-я]+)|([А-Я]{1}[а-я]+\s[А-Я]{1}[а-я]+))$/u',
            'email'=>'required|email',
        ];
        $mess =[
            'name.required'=>'Поле имя является обязательным!',
            'name.regex'=>'Введите корректное ФИО!',
            'email.required'=>'Заполните почту!',
            'email.email'=>'Проверьте введенную почту!',
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
                    return back()->withErrors(['mess'=>'Пользователь с такой почтой уже есть!']);
                }
            }
            else{
                $update = User::where('id', '=', Auth::user()->id)->update([
                    'name'=>$request->name,
                    'email'=>$request->email
                ]);
            }

            if($update){
                return back()->withErrors(['mess'=>'Успешное обновление данных!']);
            }
            else{
                return back()->withErrors(['mess'=>'Не удалось обновить данные!']);
            }
        }
    }
    public function all_users_admin(){
        $all_users = User::select('id','name','email','role','password', 'blocked')->get();
        return view('admin/main', ['users'=>$all_users]);
    }

    public function change_blocked($id_user, $blocked){
        $blocked = User::where('id', '=', $id_user)->update(['blocked'=>$blocked]);
        $all_users = User::select('id','name','email','role','password', 'blocked')->get();
        if($blocked){
            return redirect()->route('main_admin')->withErrors(['mess'=>'Доступ изменен!']);
        }
        else{
            return back()->withErrors(['mess'=>'Не удалось изменить доступ!', 'users'=>$all_users]);
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
                return back()->withErrors(['mess'=>'Успешное изменение пароля!']);
            }
            else{
                return back()->withErrors(['mess'=>'Не удалось изменить пароль!']);
            }
        }
    }
    public function change_role($id_user, $id_appl, $role, $status_appl){
        if($status_appl == 'Принята'){
            $update_role = User::where('id','=',$id_user)->update(['role'=>$role]);
            if($update_role){
                $update_user_appl = UserApplication::where('id','=', $id_appl)->update(['status_appl'=>$status_appl]);
                return back()->withErrors(['mess'=>'Успешное изменение роли!']);
            }
            else{
                return back()->withErrors(['mess'=>'Не удалось изменить роль']);
            }
        }else{
            $update_user_appl = UserApplication::where('id','=', $id_appl)->update(['status_appl'=>$status_appl]);
            return back()->withErrors(['mess'=>'Заявка отклонена']);
        }
    }

    public function start_study($id_course){
            if(Auth::check() != false){
                $old_array = User::select('all_courses')->where('id', '=', Auth::user()->id)->get()[0]->all_courses;
            if($old_array == null){
                $new_array['courses'] = [$id_course];
                $new_array = json_encode($new_array);
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
                return redirect()->route('one_course_main', ['id_course'=>$id_course])->withErrors(['mess'=>'Вы получили этот курс!']);
            }
            else{
                return redirect()->route('one_course_main', ['id_course'=>$id_course])->withErrors(['mess'=>'Не удалось получить этот курс!']);
            }
        }else{
            return redirect()->route('one_course_main', ['id_course'=>$id_course])->withErrors(['mess'=>'Сначала авторизуйтесь!']);
        }
    }

    public function complete_course($id_course){
        $complete_check = User::where('id', '=', Auth::user()->id)->select()->get()[0]->completed_courses;
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
        }
        $update_completed_courses = User::where('id', '=', Auth::user()->id)->update([
            'completed_courses'=>$complete_courses
        ]);
        if($update_completed_courses){
            return redirect()->route('one_course_main', ['id_course'=>$id_course])->withErrors(['mess'=>'Вы завершили этот курс!']);
        }
        else{
            return back()->withErrors(['mess'=>'Не удалось завершить этот курс!']);
        }
    }

    public function my_statistics(){
        $courses = User::select('all_courses','completed_courses')->where('id', '=', Auth::user()->id)->get()[0];
        $grades = DB::table('grades')->where('id_user', '=', Auth::user()->id)->select('grades.grade',DB::raw('COUNT(grade) as count'))->groupBy('grades.grade')->get();
        return view('student/my_statistics', ['grades'=>$grades, 'courses'=>$courses]);
    }
    
}
