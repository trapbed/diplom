<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use App\Models\CourseApplication;
use App\Models\Lesson;
use App\Models\User;

use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;


class CourseController extends Controller
{
    public function my_courses(){
        $completed_arr = [];
        $courses = Course::select('*');
        $completed = json_decode(User::select('completed_courses')->where('id', '=', Auth::user()->id)->get()[0]->completed_courses)->courses;
        foreach($completed as $c){
            // dump($completed);
            $courses_completed = $courses->where('id', '=', $c);
        }
        $courses_completed = $courses_completed->get();

        $all = json_decode(User::select('all_courses')->where('id', '=', Auth::user()->id)->get()[0]->all_courses)->courses;
        foreach($all as $a){
            $courses_all = $courses->where('id', '=', $c);
        }
        $courses_all = $courses_all->get();
        // dump($courses_all, $courses_completed, $all);
        // foreach
    }
    //main
    public function main(){
        $newest_course = Course::select('courses.id','categories.title as category', 'courses.title','description')->where('access', '=', '1')->join('categories', 'categories.id', '=', 'courses.category')->orderBy('student_count', 'DESC')->limit(5)->get();
        // dd($newest_course);
        return view('index', ['courses'=>$newest_course]);
    }
// courses

    
    public function main_courses(Request $request){
        $old_search = "";
        $old_cat = "";
        $old_order = "";
        // dump($request);
        $header = 'Все курсы';
        $all_access_courses = DB::table('courses')->select( 'courses.id',
            'categories.title as category',
            'courses.title',
            'courses.description',
            'courses.image',
            'users.name as author',
            'courses.student_count',
            'courses.test',
            'courses.created_at',
            'courses.access',
            'courses.appl',
            DB::raw('COUNT(lessons.id) as lesson_count'));
        if(Auth::check()!= true || Auth::user()->role == 'student'){
            $all_access_courses = $all_access_courses->where('access','=', '1');
    
        }
        if($request->search){
            $header = "Поиск '".$request->search."'";
            $old_search = $request->search;
            $all_access_courses = $all_access_courses->where('courses.title','LIKE', '%'.$request->search.'%');
        }
        if($request->category){
            $name_cat = Category::select('title')->where('id', '=', $request->category)->get()[0]->title;
            $header = "Курсы по категории '".$name_cat."'";
            $old_cat = $request->category;
            $category = $request->category;
            $all_access_courses = $all_access_courses->where('categories.id', '=', $category);
        }
        if(Auth::check()== true && Auth::user()->role == 'author'){
            $all_access_courses = $all_access_courses->where('author', '=', Auth::user()->id);
        }

        if($request->category && $request->search){
            $header = "Курсы по категории '".$name_cat."' с поиском '".$request->search."'";
        }
        $all_access_courses = $all_access_courses->join('categories', 'categories.id', '=', 'courses.category')
                                                ->join('users', 'users.id', '=', 'courses.author')
                                                ->leftJoin('lessons', 'lessons.course_id', '=', 'courses.id')->groupBy('courses.id');
        
        $order_by = $request->order;

        if($request->order != 'access DESC' && $request->order!=null){
            $old_order = $request->order;
            $order_by = explode(" ", $order_by);
            $all_access_courses = $all_access_courses->orderBy($order_by[0], $order_by[1]);
        }
        else{
            $all_access_courses = $all_access_courses->orderBy('student_count', 'DESC');
        }
        
        $all_access_courses = $all_access_courses->get();

        $categories = Category::select('id', 'title')->where('exist', '=', '1')->get();
        if(Auth::check()==true && Auth::user()->role == 'author'){
            return view('author/courses', ['courses'=> $all_access_courses, 'categories'=>$categories, 'count_courses'=>$all_access_courses->count(), 'old_search'=>$old_search, "old_cat"=>$old_cat, 'old_order'=>$old_order, 'header'=>$header]);
        }
        else{
            return view('courses', ['courses'=> $all_access_courses, 'categories'=>$categories, 'count_courses'=>$all_access_courses->count(), 'old_search'=>$old_search, "old_cat"=>$old_cat, 'old_order'=>$old_order, 'header'=>$header]);
        }
        
    }

    
    public function one_course_main($id_course){
        $has = false;
        $lessons = false;
        $complete = false;
        $info_course = Course::select('courses.id', 'courses.title', 'categories.title as category','description','image','users.name as author','student_count', 'test')->where('courses.id','=', $id_course)
        ->join('users', 'users.id', '=', 'courses.author')
        ->join('categories', 'categories.id', '=', 'courses.category');

        if(Auth::check()){
            $all_courses = Auth::user()->all_courses;
            if($all_courses != null){
                $all_courses = json_decode($all_courses);
                $all_courses = $all_courses->courses;
                $has = in_array(intval($id_course), $all_courses);
                // dump($has);
                // dd($all_courses,intval($id_course), [$all_courses], $has);
            }
            $competed_courses = Auth::user()->completed_courses;
            if($competed_courses !=  null){
                $competed_courses = json_decode($competed_courses);
                $competed_courses = $competed_courses->courses;
                $complete = in_array(intval($id_course), $competed_courses);
                // dd($complete);
            }
        }
        if($has){
            $lessons = Lesson::select('id','title')->where('course_id', '=', $id_course)->get();
        }
        // // dd($lessons);

        if($info_course->exists() == true){
            $info_course= $info_course->get()[0];
            return view('one_course', ['title'=>$info_course->title, 'course'=>$info_course, 'id'=>$id_course, 'has'=>$has, 'lessons'=>$lessons, 'complete'=>$complete]);
        }
        else{
            return redirect()->route('courses');
        }
    }

    public function get_all_admin(){
        $courses = Course::select('courses.id as course_id','courses.title as course_title','categories.title as category_title', 'description', 'users.name as author','access','test', 'courses.created_at')
        ->JOIN('users','users.id','=', 'courses.author')
        ->JOIN('categories','categories.id','=','courses.category')->get();
        // dd(count($courses));
        return view('admin/courses', ['courses'=>$courses]);
    }
    public function change_access_course($access, $id_course){
        // dd($access, $id_course);
        $update = Course::where('id', '=', $id_course)->update(['access'=>$access]);
        $courses = Course::select('courses.id as course_id','courses.title as course_title','categories.title as category_title', 'description', 'users.name as author','access','test', 'courses.created_at')
        ->JOIN('users','users.id','=', 'courses.author')
        ->JOIN('categories','categories.id','=','courses.category')->get();
        if($update){
            return back()->with(['mess'=>'Доступ изменен!', 'courses'=>$courses]);
        }
        else{
            return back()->with(['mess'=>'Не удалось изменить доступ!', 'courses'=>$courses]);
        }
        // return response()->json($request);
    }

    

   
// AUTHOR
    public function author_more_info_course($id){
        $course = Course::select('courses.id','courses.title', 'description', 'student_count', 'categories.title as category')->join('categories', 'courses.category', '=', 'categories.id')->where('courses.id', '=', $id)->get()[0];
        $lessons = Lesson::select('*')->where('course_id', '=', $id)->get();
        // dd($lessons);
        $count_lessons = $lessons->count();
        return view('author/one_course', ['course'=>$course, 'lessons'=>$lessons, 'count_lessons'=>$count_lessons]);
    }
    public function create_course_show(){
        $categories = Category::select('id', 'title')->where('exist', '=', '1')->get();
        return view('author/create_course_show', ['categories'=>$categories]);
    }
    public function create_course(Request $request){
        $data = [
            'title'=>$request->title ,
            'category'=>$request->category ,
            'description'=>$request->description ,
            'image'=>$request->image ,
        ];
        $rules = [
            'title'=>'required|min:1',
            'category'=>'required',
            'description'=>'required|min:1',
            'image'=>'required|mimes:jpg,jpeg,png',
        ];
        $mess = [
            'title.required'=>'Поле заголовок- обязательное',
            'title.min'=>'Минимальная длина поля заголовок- 5 символов',
            'category.required'=>'Выберите категорию',
            'description.required'=>'Заполните описание',
            'description.min'=>'Минимальная длина поля описание- 5 символов',
            'image.required'=>'Выберите изображение',
            'image.mimes'=>'Вы выбрали не изображение'
        ];
        $validate = Validator::make($data, $rules, $mess);
        if($validate->fails()){
            return back()
            ->withErrors($validate)
            ->withInput();
        }
        else{
            $create = Course::insert([
                'author'=>Auth::user()->id,
                'title'=>$request->title,
                'category'=>$request->category,
                'description'=>$request->description,
                'image'=>$request->file('image')->getClientOriginalName()
            ]);
            // dd($create);
            if($create){
                
                $image = $request->file('image')->getClientOriginalName();
                $upload = $request->file('image')->move(public_path()."/img/courses", $image);
                return redirect()->route('main_author')->withErrors(['success'=>'Успешное создание курса!']);
            }
            else{
                return back()->withErrors(['error'=>'Не удалось создать курс!'])->withInput();
            }
        }
    }
    function update_course_show($id){
        $categories = Category::select('id', 'title')->where('exist', '=', '1')->get();
        $course = Course::select('id','category','title','description','image')->where('id','=', $id)->get()[0];
        return view('author/update_course', ['categories'=>$categories, 'course'=>$course]);
    }
    
    public function update_course(Request $request){
        // dump($request);
        $data = [
            'title'=>$request->title,
            'category'=>$request->category,
            'description'=>$request->description
        ];
        $rules = [
            'title'=>'required|min:1',
            'category'=>'required',
            'description'=>'required|min:1',
        ];
        $mess = [
            'title.required'=>"Поле заголовок- обязательное",
            'title.min'=>"Минимальная длина поля заголовок- 5 символов",
            'category.required'=>"Поле категория- обязательное",
            'description.required'=>"Поле описание- обязательное",
            'description.min'=>"Минимальная длина поля описание- 5 символов",
        ];
        if($request->image){
            // dd($request->image);
            // array_push($data, );
            $data['image'] = $request->image;
            $rules['image'] = 'mimes:jpg,jpeg,png';
            $mess['image.mimes'] = 'Выбранный файл не изображение!';
        }
        $validate = Validator::make($data, $rules, $mess);
        // dd($validate);
        if($validate->fails()){
            return redirect('author/update_course_show/'.$request->id_course)
            ->withErrors($validate)
            ->withInput();
        }
        else{
            $update = Course::where('id', '=', $request->id_course)->update([
                'title'=>$request->title, 
                'category'=>$request->category,
                'description'=>$request->description,
            ]);
            if($request->file()){
                
                $update = Course::where('id', '=', $request->id_course)->update([
                    'image'=>$request->file('image')->getClientOriginalName()
                ]);
                $image = $request->file('image')->getClientOriginalName();
                $upload = $request->file('image')->move(public_path()."/img/courses", $image);
            }
            if($update){
                $categories = Category::select('id', 'title')->get();
                $course = Course::select('id','category','title','description','image')->where('id','=', $request->id_course)->get()[0];
                return redirect('author/update_course_show/'.$request->id_course)->withErrors(['success'=>'Успешное обновление курсa']);
            }
            else{
                $categories = Category::select('id', 'title')->get();
                $course = Course::select('id','category','title','description','image')->where('id','=', $request->id_course)->get()[0];
                return redirect('author/update_course_show/'.$request->id_course)->withErrors(['error'=>'Не удалось обновить курс']);
            }
        }
    }
    public function data_for_create_course($id){
        $course = Course::select('courses.*', DB::raw('COUNT(lessons.id) as lesson_count'))->where('courses.id', '=', $id)->leftJoin('lessons', 'lessons.course_id', '=', 'courses.id')->groupBy('courses.id')->get()[0];
        return view('author/create_lesson', ['course'=>$course]);
    }

    public function send_access($course_id, $wish_access){
        $create_appl = CourseApplication::insert([
            'course_id'=>$course_id,
            'wish_access'=>$wish_access
        ]);
        if($create_appl){
            $u_course = Course::where('id', '=', $course_id)->update([
                'appl'=>'1'
            ]);
            return redirect()->route('main_author')->withErrors(['success'=>'Заявка отправлена!'])->withInput();
        }else{
            return redirect()->route('main_author')->withErrors(['error'=>'Не удалось отправить заявку!'])->withInput();
        }
        // dd($course_id, $wish_access);
    }
    
    public function application_courses(){
        $author_appl_course = CourseApplication::select('course_applications.*', 'courses.title as course_title', 'users.id as id_user', 'users.name')->
                              join('courses', 'courses.id', '=', 'course_applications.course_id')->
                              join('users','users.id','=','courses.author')->
                              where('users.id','=',Auth::user()->id)->get();
        return view('author/applications_course', ['appls'=>$author_appl_course]);
    }

    public function get_course_applications(){
        $applications = CourseApplication::select('course_applications.id', 'courses.id as id_course', 'wish_access', 'courses.title as course', 'course_applications.created_at')->join('courses', 'courses.id', '=', 'course_applications.course_id')->where('course_applications.status', '=', 'Отправлена')->get();
        return view('/admin/course_applications', ['appls'=>$applications, 'count'=>$applications->count()]);
    }

    public function set_access($id_course, $id_appl, $wish, $act){
        if($act == 'Отклонена'){
            $upd_appl = CourseApplication::where('id', '=', $id_appl)->update([
                'status'=>$act
            ]);
            if($upd_appl){
                return back()->withErrors(['success'=>'Заявка отклонена!']);
            }
            else{
                return back()->withErrors(['error'=>'Не удалось отклонить заявку!']);
            }
        }
        else{
            $upd_course = Course::where('id', '=', $id_course)->update([
                'access'=>$wish
            ]);
            if($upd_course){
                $upd_appl = CourseApplication::where('id', '=', $id_appl)->update([
                    'status'=>$act
                ]);
                if($upd_appl){
                    return back()->withErrors(['success'=>'Заявка принята!']);
                }
                else{
                    return back()->withErrors(['error'=>'Не удалось принять заявку!']);
                }
            }
            else{
                return back()->withErrors(['error'=>'Не удалось принять заявку!']);
            }
        }
    }
}
