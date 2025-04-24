<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
class LessonController extends Controller
{
    //
    public function images_lesson(){
        // $all_lesson_images = Storage::disk('images')->files('lessons');
        // dump(($all_lesson_images));
        // foreach($all_lesson_images as $img=>$i){
        //     dump($img);
        //     dump($i);

        // }
        return view('author/images_lesson');
    }
    public function add_to_dir(Request $request){
        // dd(public_path().'/img/lessons'.$request->file('img')->getClientOriginalName());
        $data = ['img'=>$request->img];
        // dd($data);
        $rules = ['img'=>'required|mimes:jpeg,jpg,png'];
        // dd($rules);
        $mess = [
            'img.request'=>'Выберите изображение', 
            'img.mimes'=>'Тип файла должен быть изображением!'
        ];
        $validate = Validator::make($data, $rules, $mess);
        // dd($validate);
        if($validate->fails()){
            return view('author/images_lesson')
            ->withErrors($validate);
        }else{
            $image = $request->file('img')->getClientOriginalName();
            $upload = $request->file('img')->move(public_path() . "/img/lessons", $image);
            if($upload){
                return redirect('/author/courses')->withErrors(['success'=>'Успешное добавление изображения в директорию!']);
            }
            else{
                return back()->withErrors(['unupload'=>'Не удалось загрузить изображение']);
            }
        }
    }
    public function create_lesson(Request $request){
        $array_data = [];
        $id = $request->id_course;
        $texts = $request->request;
        $imgs = $request->files;
        $title = $request->title;
        foreach($texts as $text){
            if(gettype($text) == 'array'){
                foreach($text as $key=>$value){
                    $array_data[$key] =["txt"=> $value];
                }
            }            
        }
        foreach($imgs as $img){
            if(gettype($img) == 'array'){
                foreach($img as $key=>$value){
                    // dump($value);
                    $array_data[$key] = ["img"=>$value->getClientOriginalName()];
                }
            }
        }
        ksort($array_data);
        $array_data = json_encode($array_data);
        $create = Lesson::insert([
            'title'=>$title,
            'course_id'=>$id,
            'content'=>($array_data)
        ]);
        if($create){
            return redirect('author_more_info_course/'.$id)->withErrors(['success'=>'Урок создан!']);
        }
        else{
            return redirect('author_more_info_course/'.$id)->withErrors(['error'=>'Не удалось создать урок!']);
        }
    }

    public function remove_lesson($id_lesson, $id_course){
        $remove = Lesson::where('id', '=', $id_lesson)->delete();
        if($remove){
            return redirect('author_more_info_course/'.$id_course)->withErrors(['success'=>'Урок удален!']);
        }
        else{
            return redirect('author_more_info_course/'.$id_course)->withErrors(['success'=>'Не удалось удалить урок!']);
        }
    }

    public function one_lesson($id){
        $one_lesson = Lesson::select('lessons.id', 'lessons.title', 'courses.title as course', 'content')->join('courses', 'courses.id', '=', 'lessons.course_id')->where('lessons.id', '=', $id)->get()[0];
        $content = array( json_decode(($one_lesson->content)));
        $array_content = [];
        foreach($content as $key=>$value){
            foreach($value as $a=>$b){
                // dump($a);
                $array_content[$a] =get_object_vars($b);
            }
        }
        // dump($array_content);
        // dd($content);
        // dd($one_lesson);
// @extends('author.header')resources/views/author/one_lesson.blade.php
        
        return view('author/one_lesson',  ['lesson'=>$one_lesson, 'content'=>$array_content]);
        
    }

    public function one_lesson_student($id, $course){
        $completed = User::select('completed_courses')->where('id', '=', Auth::user()->id)->get()[0]->completed_courses;
        if($completed != null){
            $completed = json_decode($completed)->courses;
            $completed = in_array($course, $completed);
        }
        
        // dd($completed);
        $array_lessons = Lesson::select('id', 'title')->where('course_id','=', $course)->get();
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
        
        
        // dd($before_id, $before_title);
        
        // $next = 
        // dd($next_id, $next_title);
        $one_lesson = Lesson::select('courses.id as course_id','lessons.id', 'lessons.title', 'courses.title as course', 'content')->join('courses', 'courses.id', '=', 'lessons.course_id')->where('lessons.id', '=', $id)->get()[0];
        $content = array( json_decode(($one_lesson->content)));
        $array_content = [];
        foreach($content as $key=>$value){
            foreach($value as $a=>$b){
                // dump($a);
                $array_content[$a] = get_object_vars($b);
            }
        }
            
        return view('student/one_lesson',  ['lesson'=>$one_lesson, 'content'=>$array_content, 'next_id'=>$next_id, 'next_title'=>$next_title, 'before_id'=>$before_id, 'before_title'=>$before_title, 'completed'=>$completed]);
    }
}
