<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use App\Models\CourseApplication;
use App\Models\LessonTest;
use App\Models\Test;
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
        $user_course = "";
        // dump($request);
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
            DB::raw('COUNT(lesson_tests.id) as test'),
            DB::raw('COUNT(lesson_tests.id) as lesson_count'));
        
        // if(Auth::check() == true){
        //     $all_access_courses = $all_access_courses->addSelect('users.completed_lessons');
        // }
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
                                                ->leftJoin('lesson_tests', 'lesson_tests.course_id', '=', 'courses.id')->
                                                // ->leftJoin('tests', 'tests.course_id', '=', 'courses.id')->
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
            // dd($user_course);
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
        $info_course = DB::table('courses')->select('courses.id', 'courses.title', 'categories.title as category','description','image','users.name as author','student_count')->where('courses.id','=', $id_course)
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
            $completed_lessons = Auth::user()->completed_lessons;
            if($completed_lessons != null){
                $completed_lessons = json_decode($completed_lessons)->lessons;
            }

        }
        // if($has){
            $lessons = LessonTest::select('id','title')->where('course_id', '=', $id_course)->get();
        // }
        $arr_compl_lessons_on_course = [];

        if($info_course->exists() == true){
            $info_course= $info_course->get()[0];
            $id_lessons = [];
            // $id_lessons = LessonTest::select('id')->where('course_id', '=', $id_course)->get();
            foreach($lessons as $lesson){
                array_push($id_lessons, $lesson->id);
                if(in_array($lesson->id, $completed_lessons)){
                    array_push($arr_compl_lessons_on_course, $lesson->id);
                }
            }
            return view('one_course', ['title'=>$info_course->title, 'course'=>$info_course, 'id'=>$id_course, 'has'=>$has, 'lessons'=>$lessons, 'complete'=>$complete, 'completed_lessons'=>$completed_lessons, 'compl_lessons_on_course'=>$arr_compl_lessons_on_course]);
        }
        else{
            return redirect()->route('courses');
        }
    }

    public function get_all_admin(){
        $courses = Course::select('courses.id as course_id','courses.title as course_title','categories.title as category_title', 'description', 'users.name as author','access', 'courses.created_at')
        ->JOIN('users','users.id','=', 'courses.author')
        ->JOIN('categories','categories.id','=','courses.category')->get();
        // dd(count($courses));
        return view('admin/courses', ['courses'=>$courses]);
    }
    public function change_access_course($access, $id_course){
        // dd($access, $id_course);
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
        // return response()->json($request);
    }

    

   
// AUTHOR
    public function author_more_info_course($id){
        $course = Course::select('courses.id','courses.title', 'description','image', 'student_count', 'categories.title as category', 'courses.access as course_access')->join('categories', 'courses.category', '=', 'categories.id')->where('courses.id', '=', $id)->get()[0];
        $lessons_task = LessonTest::select('*')->where('course_id', '=', $id)->get();
        // dump($lessons);
        // dd($lessons);
        $count_lessons_task = $lessons_task->count();
        return view('author/one_course', ['course'=>$course, 'lessons'=>$lessons_task, 'count_lessons'=>$count_lessons_task]);
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
                'access'=>'0',
                'image'=>$request->file('image')->getClientOriginalName()
            ]);
            // dd($create);
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
        $course = Course::select('courses.*', DB::raw('COUNT(lesson_tests.id) as lesson_count'))->where('courses.id', '=', $id)->leftJoin('lesson_tests', 'lesson_tests.course_id', '=', 'courses.id')->groupBy('courses.id')->get()[0];
        return view('author/create_lesson', ['course'=>$course]);
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
        // dd($request->old_html, $request->request);
        // dd($request->request, $request->one_answer, $request->subsequence);
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
                        $mess[$num_task.'.one_answer_current.required'] = 'Выберите верный варинт ответа в задании '.$num_task.'!';
                        
                        
                        $validator = Validator::make($data, $rule, $mess);
                        $content['content'][$num_task]['one_answer'] = $array;
                }
                // dd( $data, $rule, $mess);
    
                
                // dump($request->one_answer);
            }
            if(isset($request->subsequence)){
                    // dd($request->subsequence);
                foreach($request->subsequence as $num_task=>$array){
                    // dd($array);
                    $data[$num_task]['subsequence_question'] = $array['question'];
                    $data[$num_task]['subsequence_answers'] = $array['answers'];
    
                    $rule[$num_task.'.subsequence_question'] = ['required'];
                    $rule[$num_task.'.subsequence_answers'] = ['min:3'];
                    
                    $mess[$num_task.'.subsequence_question.required'] = 'Заполните поле вопроса в задании '.$num_task.'!';
                    $mess[$num_task.'.subsequence_answers.min'] = 'Минимум 3 варианта ответа в задании '.$num_task.'!';
                    
                    $validator = Validator::make($data, $rule, $mess);
                    $content['content'][$num_task]['subsequence'] = $array;
                }
                // dd( $data, $rule, $mess);
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
                    // АЛФАВИТ
                    $all_answers = $incorrect+$correct;
                    // dd($array, $all_answers);
                    $data[$num_task]['some_answer_question'] = $array['question'];
                    $data[$num_task]['some_answer_incorrect'] = $array['incorrect'];
                    $data[$num_task]['some_answer_correct'] = isset($array['correct']) ? $array['correct'] : '';
    
                    $rule[$num_task.'.some_answer_question'] = ['required'];
                    $rule[$num_task.'.some_answer_incorrect'] = ['min:1'];
                    $rule[$num_task.'.some_answer_correct'] = ['min:1'];
                    
                    $rule[$num_task.'.some_answer_question.required'] = 'Заполните текст вопроса в задании '.$num_task;
                    $rule[$num_task.'.some_answer_incorrect.min'] = 'Минимум один ответ должен быть неверным '.$num_task;
                    $rule[$num_task.'.some_answer_correct.min'] = 'Выберите минимум один правильный ответ в задании '.$num_task;
                    // $mess[$num_task.'.some_answer.required'] = 'Заполните поле вопроса в задании '.$num_task.'!';
                    // $mess[$num_task.'.some_answer.required'] = 'Заполните ответ в задании '.$num_task.'!';
                    // dd($data, $rule, $mess);
                    $validator = Validator::make($data, $rule, $mess);
                    if($all_answers<3){
                        $validator->errors()->add('count_some_answer_answers', 'В задании '.$num_task.' должно быть не меньше 3-х вариантов ответа!');
                    }
                    $content['content'][$num_task]['some_answer'] = $array;
                }
            }
            // dump($content);
            
            // dump('Данные');
            // dump($data);
            // dump('Правила');
            // dump($rule);
            // dump('Сообщения');
            // dump($mess);
    
            // dd($content);
            if($validator->fails()){
                // dd($mess);
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
                // dump($request->request);
                // dd($json_content);
            }
        }
        


        // dump($request->request);


        // if(isset($request->one_answer)){

        // }
        // if(isset($request->subsequence)){

        // }
        // if(isset($request->word)){

        // }
        // if(isset($request->some_answer)){

        // }
        // foreach($request->request as $name=>$value){
        //     // dump( $name);
        //     switch($name){
        //         case 'timer':
        //             dump($name, $request->timer);
        //             // break;
        //         case 'id_course':
        //             dump($name, $request->id_course);
                
        //             // break;
        //         case 'title':
        //             dump($name, $request->title);
                
        //             // break;
        //         case 'one_answer':
        //             dump($name, $request->one_answer);
                
        //             // break;
        //         case 'subsequence':
        //             dump($name, $request->subsequence);
                
        //             // break;
        //         case 'word':
        //             dump($name, $request->word);
                
        //             // break;
        //         case 'some_answer':
        //             dump($name, $request->some_answer);
                
        //             break;
        //         // case '':
                
        //         //     break;
        //     }
        // }


        // return back();
        // if(isset($request->one_answer_1_question)){
        //     $data['one_answ_'] = $request->one_answer_1_question,
        //     $data['']
        // }
    }
}
