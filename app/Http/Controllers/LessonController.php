<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\Grade;
use App\Models\ImgLesson;
use App\Models\LessonTest;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
class LessonController extends Controller
{
    public function images_lesson(){
        return view('author/images_lesson');
    }
    public function add_to_dir(Request $request){
        $data = ['img'=>$request->img];
        $rules = ['img'=>'required|mimes:jpeg,jpg,png'];
        $mess = [
            'img.request'=>'Выберите изображение', 
            'img.mimes'=>'Вы выбрали не изображение'
        ];
        $validate = Validator::make($data, $rules, $mess);
        if($validate->fails()){
            return view('author/images_lesson')
            ->withErrors($validate);
        }else{
            $image = $request->file('img')->getClientOriginalName();
            $upload = $request->file('img')->move(public_path() . "/img/".$request->directory, $image);
            if($upload){
                $add_to_DB = DB::table('img_'.$request->directory)->insert([
                    'author'=>Auth::user()->id,
                    'name'=>$image
                ]);
                return redirect('/get_images_lesson')->withErrors(['mess'=>'Успешное добавление изображения в директорию!']);
            }
            else{
                return back()->withErrors(['mess'=>'Не удалось загрузить изображение']);
            }
        }
    }
    public function create_lesson(Request $request){
        $array_data = [];
        $id = $request->id_course;
        $texts = $request->request;
        $imgs = $request->files;
        $title = $request->title;
        foreach($texts as $name=>$text){
            if(gettype($text) == 'array'){
                
                foreach($text as $key=>$value){
                    if($name == 'img'){
                        $array_data[$key] =["img"=> $value];
                    }elseif($name == 'text'){
                        $array_data[$key] =["txt"=> trim($value)];
                    }
                }
            }            
        }
        ksort($array_data);
        $array_data = json_encode($array_data);
        $create = LessonTest::insert([
            'type'=>'lesson',
            'title'=>$title,
            'course_id'=>$id,
            'content'=>($array_data)
        ]);
        if($create){
            return redirect('author_more_info_course/'.$id)->withErrors(['mess'=>'Урок создан!']);
        }
        else{
            return redirect('author_more_info_course/'.$id)->withErrors(['mess'=>'Не удалось создать урок!']);
        }
    }
    public function remove_lesson($id_lesson, $id_course){
        $remove = LessonTest::where('id', '=', $id_lesson)->delete();
        if($remove){
            return redirect('author_more_info_course/'.$id_course)->withErrors(['mess'=>'Урок удален!']);
        }
        else{
            return redirect('author_more_info_course/'.$id_course)->withErrors(['mess'=>'Не удалось удалить урок!']);
        }
    }
    public function update_lesson_view($id){
        $course = DB::table('lesson_tests')->select('courses.*')->where('lesson_tests.id', '=', $id)->leftJoin('courses', 'courses.id', '=', 'lesson_tests.course_id')->get()[0];
        $data = LessonTest::select('*')->where('lesson_tests.id', '=', $id)->get()[0];
        $images = ImgLesson::select('*')->where('author', '=', Auth::user()->id)->get();
        $categories = Category::select('*')->get();
        if($data->type == 'lesson'){
            return view('author.update_lesson', ['data'=>$data, 'categories'=>$categories, 'course'=>$course, 'images'=>$images]);
        }elseif($data->type == 'test'){
            return view('author.update_test', ['data'=>$data, 'categories'=>$categories, 'course'=>$course, 'images'=>$images]);
        }
    }
    public function update_lesson(Request $request){
        $array_data = [];
        $id = $request->id_course;
        $texts = $request->request;
        $title = $request->title;
        foreach($texts as $name=>$text){
            if(gettype($text) == 'array'){
                
                foreach($text as $key=>$value){
                    if($name == 'img'){
                        // dd($key, $value);
                        $array_data[$key] =["img"=> $value];
                    }elseif($name == 'text'){
                        $array_data[$key] =["txt"=> trim($value)];
                    }
                }
            }            
        }

        ksort($array_data);
        $array_data = json_encode($array_data);
        $update = LessonTest::where('id', '=',$request->id_lesson)->update([
            'content'=>($array_data)
        ]);
        if($update){
            return redirect('author_more_info_course/'.$id)->withErrors(['mess'=>'Урок обновлен!']);
        }
        else{
            return redirect('author_more_info_course/'.$id)->withErrors(['mess'=>'Не удалось обновить урок!']);
        }
    }
    public function one_lesson($id){
        $one_lesson = LessonTest::select('lesson_tests.id', 'lesson_tests.title', 'courses.title as course', 'content', 'lesson_tests.type')->where('lesson_tests.id', '=', $id)->join('courses', 'courses.id', '=', 'lesson_tests.course_id')->where('lesson_tests.id', '=', $id)->get()[0];
        $content = array( json_decode(($one_lesson->content)));
        $array_content = [];
        if($one_lesson->type == 'lesson'){
            foreach($content as $key=>$value){
                foreach($value as $a=>$b){
                    $array_content[$a] =get_object_vars($b);
                }
            }
        }else{
            foreach($content[0] as $key=>$value){
                if($key == 'content'){
                    $array_content[$key] = get_object_vars($value);
                }else{
                    $array_content[$key] = $value;
                }
            }
        }
        return view('author/one_lesson',  ['lesson'=>$one_lesson, 'content'=>$array_content]);
    }
    public function one_lesson_student($id, $course){
        $completed = User::select('completed_courses')->where('id', '=', Auth::user()->id)->get()[0]->completed_courses;
        if($completed != null){
            $completed = json_decode($completed)->courses;
            $completed = in_array($course, $completed);
        }
        
        $timer = null;
        $array_lessons = LessonTest::select('id', 'title')->where('course_id','=', $course)->get();
        $array_id = [];
        $array_id_title = [];
        $next_id = null;
        $next_title = null;
        $before_id = null;
        $before_title = null;
        foreach($array_lessons as $value){
            array_push($array_id, intval($value->id));
            $array_id_title[$value->id] = $value->title;
        }
        $current_key = array_search($id, $array_id); 
        if($current_key < $array_lessons->count()-1){
            $next_id = $array_id[$current_key+1];
            $next_title = $array_id_title[$next_id];
        }
        if($current_key != 0){
            $before_id = $array_id[$current_key-1];
            $before_title = $array_id_title[$before_id];
        }
        $one_lesson = LessonTest::select('courses.id as course_id','lesson_tests.id', 'lesson_tests.title','lesson_tests.type', 'courses.title as course', 'content')->join('courses', 'courses.id', '=', 'lesson_tests.course_id')->where('lesson_tests.id', '=', $id)->get()[0];
        $content = array( json_decode(($one_lesson->content)));
        $array_content = [];
        if($one_lesson->type == 'lesson'){
            foreach($content as $key=>$value){
                foreach($value as $a=>$b){
                    $array_content[$a] = get_object_vars($b);
                }
            }
        }
        else{
            foreach($content as $key_t1=>$value_t1){
                $timer = isset($value_t1->timer) ? $value_t1->timer : 0;
                $array_content = get_object_vars($value_t1->content);
            }
        }

        $completed_lessons = User::select('completed_lessons')->where('id', '=', Auth::user()->id)->get()[0]->completed_lessons;
        if($completed_lessons != null){
            $completed_lessons = json_decode($completed_lessons)->lessons;
            $check_completed_lesson = in_array($one_lesson->id, $completed_lessons); 
            if($check_completed_lesson != true){
                array_push($completed_lessons, $one_lesson->id);
                $new_completed_lessons['lessons'] = $completed_lessons;
                $new_completed_lessons = json_encode($new_completed_lessons);
                User::where('id', '=', Auth::user()->id)->update([
                    'completed_lessons'=>$new_completed_lessons
                ]);
            }
        }
        else{
            $array_completed_lessons = [];
            $array_completed_lessons['lessons'] = [$one_lesson->id];
            $array_completed_lessons = json_encode($array_completed_lessons);
            $completed_lessons = User::where('id', '=', Auth::user()->id)->update([
                'completed_lessons'=>$array_completed_lessons
            ]);
        }
          
        return view('student/one_lesson',  ['lesson'=>$one_lesson, 'content'=>$array_content, 'next_id'=>$next_id, 'next_title'=>$next_title, 'before_id'=>$before_id, 'before_title'=>$before_title, 'completed'=>$completed, 'timer'=>$timer]);
    }
    public function check_test_student(Request $request){
        $score = 0;
        $this_test_id = $request->id_test;
        $pre_content = LessonTest::select('*')->where('id', '=', $this_test_id)->get()[0];
        $content = $pre_content->content;
        $content = json_decode($content)->content;
        $answers_array_to_db = [];
        foreach($request->request as $name=>$array){
            if($name == 'subsequence' || $name== 'one_answer' || $name == 'some_answer' || $name == 'word'){
                foreach($array as $key=>$answers){
                    $array_db = ($content->$key);
                    if($name == 'some_answer'){
                        $count_correct_user_s_a = 0;
                        $all_answers_db = [];
                        foreach($array_db->$name->correct as $cors){
                            array_push($all_answers_db, $cors);
                        }
                        foreach($array_db->$name->incorrect as $incors){
                            array_push($all_answers_db, $incors);
                        }
                        $correct_answers_db = $array_db->$name->correct;
                        $answers_student = $answers;

                        $answers_array_to_db[$key][$name] = $answers_student;
                        foreach($correct_answers_db as $c_a){
                            if(in_array($c_a, $answers_student)){
                                $count_correct_user_s_a ++;
                            }
                        }
                        $count_incorrset_s_a = count($answers_student)-$count_correct_user_s_a-1;
                        if(count(get_object_vars($correct_answers_db)) == $count_correct_user_s_a){
                            $score += 1;
                        }
                        else{
                            $score += 0;
                        }
                    }
                    else if($name == 'one_answer'){
                        if($array_db->$name->current == $answers){
                            $score++;
                        }
                        $answers_array_to_db[$key][$name] = $array_db->$name->current;
                    }
                    else if($name == 'subsequence'){
                        $array_user_sub = explode(',', $answers);
                        $count_array_sub_db = count($array_db->$name->answers);
                        $array_currects_sub = array_intersect_assoc($array_user_sub, $array_db->$name->answers);
                        $count_array_sub_user = count($array_currects_sub);
                        $current_sub_coef = ($count_array_sub_user/$count_array_sub_db);
                        $score+=$current_sub_coef;

                        $answers_array_to_db[$key][$name] = $array_user_sub;
                    }
                    else if($name == 'word'){
                        $in_db_word = LessonTest::select('*')->where('id', '=', $request->id_test)->where('content' , 'LIKE', '%'.$answers.'%')->get();
                        if(count($in_db_word) != 0){
                            $percent_similar_word = 100;
                        }
                        else{
                            $percent_similar_word = 0;
                        }
                        $coef_word = $percent_similar_word/100;
                        $score+=$coef_word;
                        $answers_array_to_db[$key][$name] = $array_db->$name->current;
                    }

                }
            }
            
        }
        $coef_score = $score/count(get_object_vars($content));
        $coef_score = round($coef_score, 2);

        switch($coef_score){
            case ($coef_score<=0.4):
                $grade = 2;
                break;
            case ($coef_score>=0.4 && $coef_score<0.6):
                $grade = 3;
                break;    
            case ($coef_score>=0.6 && $coef_score<0.8):
                $grade = 4;
                break;
            case ($coef_score>=0.8 && $coef_score<=1):
                $grade = 5;
                break;
        }
        
        $add_in_db = Grade::insert([
            'id_lesson'=>$this_test_id,
            'id_user'=>Auth::user()->id,
            'answers'=>json_encode($answers_array_to_db, JSON_UNESCAPED_UNICODE),
            'score'=>$score,
            'coef'=>$coef_score,
            'grade'=>$grade
        ]);

        if($add_in_db){
            $content = LessonTest::select('*')->where('id', '=', $this_test_id)->get()[0]->content;
            $course = Course::select('*')->where('id', '=', $pre_content->course_id)->get()[0];
            $next_title = null;
            if($request->next_id){
                $next_title = LessonTest::select('*')->where('id', '=', $request->next_id)->get()[0]->title;
                
            }
            $completed = User::select('completed_courses')->where('id', '=', Auth::user()->id)->get()[0]->completed_courses;
            if($completed != null){
                $completed = json_decode($completed)->courses;
                $completed = in_array($course->id, $completed);
            }
            $before_title = LessonTest::select('*')->where('id', '=', $this_test_id)->get()[0]->title;
            return view('student.result_test', ['before_id'=>$this_test_id, 'next_id'=>$request->next_id,'next_title'=>$next_title, 'before_title'=>$before_title,'course'=>$course, 'grade'=>$grade, 'percent'=>$coef_score*100, 'completed'=>$completed])->withErrors(['mess'=>'Вы завершили прохождение теста!']);
        }
        else{
            return view('student.result_test', ['before_id'=>$this_test_id, 'next_id'=>$request->id_tets])->withErrors(['mess'=>'Не удалось сохранить результаты теста!']);
        }
    }
    public function certificate($id_course){
        $course = Course::select('*')->where('id', '=', $id_course)->get()[0];
        return view('student.certificate', ['course'=>$course]);
    }
    public function progress_author(){
        $tests = DB::table('lesson_tests')->
        select('lesson_tests.*', 'courses.title as course', 'lesson_tests.title as test', DB::raw('COUNT(grades.id) as dones'))
        ->where('author', '=', Auth::user()->id)
        ->leftJoin('courses', 'courses.id', '=', 'lesson_tests.course_id')
        ->leftJoin('grades', 'grades.id_lesson', '=', 'lesson_tests.id')
        ->groupBy('lesson_tests.id')
        ->orderBy('course_id')->get();
        return view('author.progress', ['tests'=>$tests]);
    }
}
