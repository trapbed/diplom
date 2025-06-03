<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use App\Models\CourseApplication;
use App\Models\Grade;
use App\Models\ImgLesson;
use App\Models\LessonTest;
use App\Models\Rate;
use App\Models\Test;
use App\Models\User;

use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;


class CourseController extends Controller
{
    public function main(){
        $newest_course = DB::table('courses')->select('courses.id','categories.title as category', 'courses.image', 'courses.title','description', DB::raw('AVG(rates.rate) as one_rate'))->where('access', '=', '1')->
        leftJoin('rates', 'rates.id_course', '=', 'courses.id')->join('categories', 'categories.id', '=', 'courses.category')->groupBy('courses.id')->orderBy('one_rate', 'DESC')->limit(5)->get();
        return view('index', ['courses'=>$newest_course]);
    }
    
    public function main_courses(Request $request){
        $old_search = "";
        $old_cat = "";
        $old_order = "";
        $user_course = "";

        $header = 'Все курсы';
        $all_access_courses = DB::table('courses')->select( 'courses.id',
            'categories.title as category',
            'courses.title',
            'courses.description',
            'courses.image',
            'users.name as author',
            'courses.student_count',
            'courses.created_at',
            'courses.access',
            'courses.appl',
            DB::raw('round(AVG(rates.rate), 2) as rate'),
            DB::raw('COUNT(lesson_tests.id) as test'),
            DB::raw('COUNT(lesson_tests.id) as lesson_count'));

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
                                                ->leftJoin('lesson_tests', 'lesson_tests.course_id', '=', 'courses.id')
                                                ->leftJoin('rates', 'rates.id_course', '=', 'courses.id')->
                                                groupBy('courses.id');
        
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

        if(Auth::check() == true && Auth::user()->role == 'student'){
            $user_course = User::select('completed_courses', 'all_courses')->where('id', '=', Auth::user()->id)->get()[0];
            if($user_course->all_courses != null){
                $all_courses = json_decode($user_course->all_courses)->courses;
            }else{
                $all_courses = null;
            }
            if($user_course->completed_courses != null){
                $completed_courses = json_decode($user_course->completed_courses)->courses;
            }else{
                $completed_courses = null;
            }
        }else{
            $all_courses = null;
            $completed_courses = null;
        }

        if(Auth::check()==true && Auth::user()->role == 'author'){
            return view('author/courses', ['courses'=> $all_access_courses, 'categories'=>$categories, 'count_courses'=>count($all_access_courses), 'old_search'=>$old_search, "old_cat"=>$old_cat, 'old_order'=>$old_order, 'header'=>$header]);
        }
        else{
            return view('courses', ['courses'=> $all_access_courses, 'categories'=>$categories, 'count_courses'=>count($all_access_courses), 'old_search'=>$old_search, "old_cat"=>$old_cat, 'old_order'=>$old_order, 'header'=>$header, 'all_courses'=>$all_courses, 'completed_courses'=>$completed_courses]);
        }
    }

    
    public function one_course_main($id_course){
        $has = false;
        $lessons = false;
        $complete = false;
        $completed_lessons = false;
        $user_rate = null;
        $user_rate_check = null;
        $user_grades = null;
        $all_lessons = null;
        $info_course = DB::table('courses')->select('courses.id', 'courses.title', 'categories.title as category','description','image','users.name as author','student_count', 'courses.any_blocks')->where('courses.id','=', $id_course)
        ->join('users', 'users.id', '=', 'courses.author')
        ->join('categories', 'categories.id', '=', 'courses.category');

        $db_rate_course = Rate::select('rate')->where('id_course', '=', $id_course)->get();
        $all_rates = [];
        foreach($db_rate_course as $one_rate){
            array_push($all_rates, $one_rate->rate);
        }
        
        if(Auth::check()){
            $all_courses = Auth::user()->all_courses;
            if($all_courses != null){
                $all_courses = json_decode($all_courses);
                $all_courses = $all_courses->courses;
                $has = in_array(intval($id_course), $all_courses);
            }
            $competed_courses = Auth::user()->completed_courses;
            if($competed_courses !=  null){
                $competed_courses = json_decode($competed_courses);
                $competed_courses = $competed_courses->courses;
                $complete = in_array(intval($id_course), $competed_courses);
            }
            $completed_lessons = Auth::user()->completed_lessons;
            if($completed_lessons != null){
                $completed_lessons = json_decode($completed_lessons)->lessons;
            }

            $user_grades = Grade::select('*')->where('id_user', '=', Auth::user()->id)->get();

            $user_rate = Rate::select('*')->where('id_user', '=', Auth::user()->id)->where('id_course', '=', $id_course)->get();
            $user_rate_check = Rate::select('rate')->where('id_user', '=', Auth::user()->id)->where('id_course', '=', $id_course)->exists();
        }

        $lessons = LessonTest::select('id','title', 'type')->where('course_id', '=', $id_course)->get();
        $arr_less = [];

        foreach($lessons as $id_less){
            array_push($arr_less, $id_less->id);
        }

        $arr_compl_lessons_on_course = [];

        $text_rates = DB::table('rates')->select('rates.*', 'users.email', 'users.id as user_id')->where('id_course', '=', $id_course)->where('text_rate', '!=', NULL)
        ->leftJoin('users', 'users.id', 'rates.id_user')->
        get();

        if($info_course->exists() == true){
            $info_course= $info_course->get()[0];
            $id_lessons = [];
            foreach($lessons as $lesson){
                array_push($id_lessons, $lesson->id);
                if(Auth::check() == true){
                       if(in_array($lesson->id, $completed_lessons)){
                            array_push($arr_compl_lessons_on_course, $lesson->id);
                        } 
                    // array_push($all_lessons, $lesson->id);
                }
            }

            return view('one_course', ['title'=>$info_course->title, 'course'=>$info_course, 'id'=>$id_course, 'has'=>$has, 
                                                   'lessons'=>$lessons, 'all_lessons'=>$id_lessons,'complete'=>$complete, 
                                                   'completed_lessons'=>$completed_lessons, 
                                                   'compl_lessons_on_course'=>$arr_compl_lessons_on_course, 'user_rate'=>$user_rate, 
                                                   'user_rate_exist'=>$user_rate_check,'rate'=>$all_rates, 'text_rates'=>$text_rates, 
                                                   'arr_less'=>$arr_less, 'user_grades'=>$user_grades]);
        }
        else{
            return redirect()->route('courses');
        }
    }

    public function get_all_admin(){
        $courses = Course::select('courses.id as course_id','courses.title as course_title','categories.title as category_title', 'description', 'users.name as author','access', 'courses.created_at')
        ->JOIN('users','users.id','=', 'courses.author')
        ->JOIN('categories','categories.id','=','courses.category')->get();
        return view('admin/courses', ['courses'=>$courses]);
    }
    public function change_access_course($access, $id_course){
        $update = Course::where('id', '=', $id_course)->update(['access'=>$access]);
        $courses = Course::select('courses.id as course_id','courses.title as course_title','categories.title as category_title', 'description', 'users.name as author','access', 'courses.created_at')
        ->JOIN('users','users.id','=', 'courses.author')
        ->JOIN('categories','categories.id','=','courses.category')->get();
        if($update){
            return redirect()->route('courses_admin')->withErrors(['mess'=>'Доступ изменен!']);
        }
        else{
            return redirect()->route('courses_admin')->withErrors(['mess'=>'Не удалось изменить доступ!']);
        }
    }
  
// AUTHOR
    public function author_more_info_course($id){
        $course = Course::select('courses.id','courses.title', 'description','image', 'student_count', 'categories.title as category', 'courses.access as course_access')->join('categories', 'courses.category', '=', 'categories.id')->where('courses.id', '=', $id)->get()[0];
        $lessons_task = LessonTest::select('*')->where('course_id', '=', $id)->get();
        $count_lessons_task = $lessons_task->count();
        return view('author/one_course', ['course'=>$course, 'lessons'=>$lessons_task, 'count_lessons'=>$count_lessons_task]);
    }
    public function create_course_show(){
        $categories = Category::select('id', 'title')->where('exist', '=', '1')->orderBy('title')->get();
        $desc_img = DB::table('img_desc_courses')->select('*')->where('author', '=', Auth::user()->id)->orderBy('id', 'DESC')->get();
        return view('author/create_course_show', ['categories'=>$categories, 'desc_img'=>$desc_img]);
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
            $any_blocks = [];
            $count = 1;
            foreach($request->type as $key1=>$val1){
                foreach($val1 as $key2=>$val2){
                    // dump(key($val1));
                    // dump($val2);
                    $any_blocks[$count][key($val1)] = $val2;
                }
                $count++;
                json_encode($any_blocks, JSON_UNESCAPED_UNICODE);
            }

            $create = Course::insert([
                'author'=>Auth::user()->id,
                'title'=>$request->title,
                'category'=>$request->category,
                'description'=>$request->description,
                'any_blocks'=>json_encode($any_blocks, JSON_UNESCAPED_UNICODE),
                'access'=>'0',
                'image'=>$request->file('image')->getClientOriginalName()
            ]);
            
            if($create){
                $image = $request->file('image')->getClientOriginalName();
                $upload = $request->file('image')->move(public_path()."/img/courses", $image);
                return redirect()->route('main_author')->withErrors(['mess'=>'Успешное создание курса!']);
            }
            else{
                return back()->withErrors(['mess'=>'Не удалось создать курс!'])->withInput();
            }
        }
    }
    function update_course_show($id){
        $categories = Category::select('id', 'title')->where('exist', '=', '1')->get();
        $course = Course::select('id','category','title','description','image')->where('id','=', $id)->get()[0];
        return view('author/update_course', ['categories'=>$categories, 'course'=>$course]);
    }

    function del_course($id){
        $delete_course = Course::where('id', '=', $id)->delete();
        if($delete_course){
            return redirect()->route('main_author')->withErrors(['mess'=>'Успешное удаление']);
        }else{
            return redirect()->route('main_author')->withErrors(['mess'=>'Не удалось удалить']);
        }
    }
    
    public function update_course(Request $request){
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
            $data['image'] = $request->image;
            $rules['image'] = 'mimes:jpg,jpeg,png';
            $mess['image.mimes'] = 'Выбранный файл не изображение!';
        }
        $validate = Validator::make($data, $rules, $mess);
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
                return redirect('author/update_course_show/'.$request->id_course)->withErrors(['mess'=>'Успешное обновление курсa']);
            }
            else{
                $categories = Category::select('id', 'title')->get();
                $course = Course::select('id','category','title','description','image')->where('id','=', $request->id_course)->get()[0];
                return redirect('author/update_course_show/'.$request->id_course)->withErrors(['mess'=>'Не удалось обновить курс']);
            }
        }
    }
    public function data_for_create_course($id){
        $images = ImgLesson::select('*')->where('author', '=', Auth::user()->id)->orderBy('id', 'DESC')->get();
        $course = Course::select('courses.*', DB::raw('COUNT(lesson_tests.id) as lesson_count'))->where('courses.id', '=', $id)->leftJoin('lesson_tests', 'lesson_tests.course_id', '=', 'courses.id')->groupBy('courses.id')->get()[0];
        return view('author/create_lesson', ['course'=>$course, 'images'=>$images]);
    }

    public function data_for_create_test($id){
        $tests = LessonTest::select('*')->where('course_id', '=', $id)->get();
        $course = Course::select('courses.*')->where('courses.id', '=', $id)->leftJoin('lesson_tests', 'lesson_tests.course_id', '=', 'courses.id')->groupBy('courses.id')->get()[0];
        return view('author/create_test', ['test'=>$tests, 'course'=>$course]);
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
            return redirect()->route('main_author')->withErrors(['mess'=>'Заявка отправлена!'])->withInput();
        }else{
            return redirect()->route('main_author')->withErrors(['mess'=>'Не удалось отправить заявку!'])->withInput();
        }
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
                return back()->withErrors(['mess'=>'Заявка отклонена!']);
            }
            else{
                return back()->withErrors(['mess'=>'Не удалось отклонить заявку!']);
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
                    $appl_in_course = Course::where('id','=',$id_course)->update([
                        'appl'=>'0'
                    ]);
                    return back()->withErrors(['mess'=>'Заявка принята!']);
                }
                else{
                    return back()->withErrors(['mess'=>'Не удалось принять заявку!']);
                }
            }
            else{
                return back()->withErrors(['mess'=>'Не удалось принять заявку!']);
            }
        }
    }

    // TESTS
    public function create_test_db(Request $request){
        if($request->one_answer == null && $request->subsequence==null && $request->word == null && $request->some_answer == null){
            return back()->withErrors(['mess'=>'Заполните тест контентом!']);
        }
        else{
            $data = [
                'course_id'=>$request->id_course,
                'title_test'=>$request->title_test,
                'timer'=>$request->timer
            ];
            $rule = [
                'course_id'=>'required',
                'title_test'=>'required',
            ];
            $mess = [
                'course_id.required'=>'Курс не выбран!',
                'title_test.required'=>'Заполните заголовок тестирования!',
            ];
    
            
            $content['title_test'] = $request->title_test;
            $content['timer'] = $request->timer;
            if(isset($request->one_answer)){
                foreach($request->one_answer as $num_task=>$array){
                        $data[$num_task]['one_answer_question'] = $array['question'];
                        $data[$num_task]['one_answer_answers'] = $array['answers'];
                        $data[$num_task]['one_answer_current'] = $array['current'];
    
                        $rule[$num_task.'.one_answer_question'] = ['required'];
                        $rule[$num_task.'.one_answer_answers'] = ['min:3'];
                        $rule[$num_task.'.one_answer_current'] = ['required'];
                        
                        $mess[$num_task.'.one_answer_question.required'] = 'Заполните поле вопроса в задании '.$num_task.'!';
                        $mess[$num_task.'.one_answer_answers.min'] = 'Минимум 3 варианта ответа в задании '.$num_task.'!';
                        $mess[$num_task.'.one_answer_current.required'] = 'Выберите верный вариант ответа в задании '.$num_task.'!';
                        
                        
                        $validator = Validator::make($data, $rule, $mess);
                        $content['content'][$num_task]['one_answer'] = $array;
                }
            }
            if(isset($request->subsequence)){
                foreach($request->subsequence as $num_task=>$array){
                    $data[$num_task]['subsequence_question'] = $array['question'];
                    $data[$num_task]['subsequence_answers'] = $array['answers'];
    
                    $rule[$num_task.'.subsequence_question'] = ['required'];
                    $rule[$num_task.'.subsequence_answers'] = ['min:3'];
                    
                    $mess[$num_task.'.subsequence_question.required'] = 'Заполните поле вопроса в задании '.$num_task.'!';
                    $mess[$num_task.'.subsequence_answers.min'] = 'Минимум 3 варианта ответа в задании '.$num_task.'!';
                    
                    $validator = Validator::make($data, $rule, $mess);
                    $content['content'][$num_task]['subsequence'] = $array;
                }
            }
            if(isset($request->word)){
                foreach($request->word as $num_task=>$array){
                    $data[$num_task]['word_question'] = $array['question'];
                    $data[$num_task]['word_current'] = $array['current'];
    
                    $rule[$num_task.'.word_question'] = ['required'];
                    $rule[$num_task.'.word_current'] = ['required'];
                    
                    $mess[$num_task.'.word_question.required'] = 'Заполните поле вопроса в задании '.$num_task.'!';
                    $mess[$num_task.'.word_current.required'] = 'Заполните ответ в задании '.$num_task.'!';
                    
                    $validator = Validator::make($data, $rule, $mess);
                    $content['content'][$num_task]['word'] = $array;
                }
            }
            if(isset($request->some_answer)){
                foreach($request->some_answer as $num_task=>$array){
                    $correct = isset($array['correct']) ? count($array['correct']) : 0;
                    $incorrect = isset($array['incorrect']) ? count($array['incorrect']) : 0;

                    $all_answers = $incorrect+$correct;
                    $data[$num_task]['some_answer_question'] = $array['question'];
                    $data[$num_task]['some_answer_incorrect'] = $array['incorrect'];
                    $data[$num_task]['some_answer_correct'] = isset($array['correct']) ? $array['correct'] : '';
    
                    $rule[$num_task.'.some_answer_question'] = ['required'];
                    $rule[$num_task.'.some_answer_incorrect'] = ['min:1'];
                    $rule[$num_task.'.some_answer_correct'] = ['min:1'];
                    
                    $rule[$num_task.'.some_answer_question.required'] = 'Заполните поле вопроса в задании '.$num_task;
                    $rule[$num_task.'.some_answer_incorrect.min'] = 'Минимум один ответ должен быть неверным '.$num_task;
                    $rule[$num_task.'.some_answer_correct.min'] = 'Выберите минимум один правильный ответ в задании '.$num_task;
                    $validator = Validator::make($data, $rule, $mess);
                    if($all_answers<3){
                        $validator->errors()->add('count_some_answer_answers', 'В задании '.$num_task.' должно быть не меньше 3-х вариантов ответа!');
                    }
                    $content['content'][$num_task]['some_answer'] = $array;
                }
            }
            if($validator->fails()){
                return back()->withErrors($validator)->withInput();
            }else{
                $json_content = json_encode($content, JSON_UNESCAPED_UNICODE);

                $new_test = DB::table('lesson_tests')->insert([
                    'course_id'=>$request->id_course,
                    'title'=>$request->title_test,
                    'timer'=>$request->timer,
                    'content'=>$json_content
                ]);
                if($new_test){
                    return redirect()->route('author_more_info_course', ['id'=>$request->id_course])->withErrors(['mess'=>'Успешное создание теста!']);
                }
                else{
                    return redirect()->route('author_more_info_course', ['id'=>$request->id_course])->withErrors(['mess'=>'Не удалось создать тест!']);
                }
            }
        }
    }

    public function send_rate_course(Request $request){
        $data = [
            'rate'=>$request->rate
        ];
        $rules = [
            'rate'=>['required'],
        ];
        $mess = [
            'rate.required'=>'Поставьте оценку!',
        ];
        if($request->text_rate != null){
            $data['text_rate'] = $request->text_rate;
            $rules['text_rate'] = ['min:3'];
            $mess['text_rate.min'] = 'Минимум 3 символа в текстовом поле!';
        }
        $validator = Validator::make($data, $rules, $mess);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }else{
            $check_rate = Rate::select('*')->
            where('id_user','=',Auth::user()->id)->
            where('id_course', '=', $request->id_course)->get();
            if($check_rate != null && count($check_rate) != 0){
                $db_rate = Rate::where('id_user','=',Auth::user()->id)->
                                where('id_course', '=', $request->id_course)->
                                update([
                                    'rate'=>$request->rate,
                                    'text_rate'=>$request->text_rate
                                ]);
            }else{
                $db_rate = Rate::insert([
                    'id_user'=>Auth::user()->id,
                    'id_course'=>$request->id_course,
                    'rate'=>$request->rate,
                    'text_rate'=>$request->text_rate
                ]);
            }
            if($db_rate){
                return redirect()->route('one_course_main', ['id_course'=>$request->id_course])->withErrors(['mess'=>'Отзыв отправлен!']);
            }else{
                return redirect()->route('one_course_main', ['id_course'=>$request->id_course])->withErrors(['mess'=>'Не удалось отправить отзыв!']);
            }
        }
    }

    public function send_img_to_desc_course(Request $request){
        $key = key($request->type);
        $image = $request->file($request->file('type')[$key]['text_img']['img']->getClientOriginalName());
        $upload = $request->file('type')[$key]['text_img']['img']->move(public_path()."/img/desc_course/", $image);
        return back();
    }
}
