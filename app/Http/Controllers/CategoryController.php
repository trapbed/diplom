<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use App\Models\Category;

class CategoryController extends Controller
{
    //
    public function categories_admin(){
        $categories = Category::select('id','title', 'exist')->get();
        return view('admin/categories', ['categories'=>$categories]);
    }

    public function create_category(Request $request){
        // dd($request);
        $data = [
            'title'=>$request->title
        ];
        $rules = [
            'title'=>'required|min:6|unique:categories'
        ];
        $messages = [
            'title.required'=>'Заполните поле!',
            'title.min'=>'Минимальная длина названия- 6 символов',
            'title.unique'=>'Название должно быть уникальным!'
        ];
        $validate = Validator::make($data, $rules, $messages);
        if($validate->fails()){
            // dd($validate);
            return redirect('admin/categories_admin')
            ->withErrors($validate)
            ->withInput();
        }
        else{
            $create_category = Category::insert(['title'=>$request->title]);
            // dd($create_category);
            if($create_category){
                return back()
                ->withErrors(['success'=>'Успешное создание категории!'])
                ->withInput();
            }
            else{
                return back()
                ->withErrors(['error_db'=>'Не удалось создать категорию!'])
                ->withInput();
            }
            // $user = User::create([
            //     'name'=>$request->name,
            //     'email'=>$request->email,
            //     'role'=>'student',
            //     'password'=>Hash::make($request->pass),
            // ]);
            // Auth::login($user);
            // if(Auth::user()->role == 'student'){
            //     return redirect()->route('main_student');

            // }
            // else if(Auth::user()->role == 'author'){
            //     return redirect()->route('main_author');

            // }
            // else if(Auth::user()->role == 'admin'){
            //     return redirect()->route('main_admin');

            // }
        }
    }

    public function change_exist_category($exist, $id){
        $change_exist_category = Category::where('id','=',$id)->update(['exist'=>$exist]);
        if($change_exist_category){
            return back()
            ->withErrors(['success'=>'Успешное обновление категории!'])
            ->withInput();
        }
        else{
            return back()
            ->withErrors(['error_db'=>'Не удалось обновить категорию!'])
            ->withInput();
        }
        // dd($exist, $id);
    }

    public function edit_cat_show($id){
        $cat_info = Category::select('*')->where('id','=', $id)->get()[0];
        return view('admin/edit_cat', ['cat'=>$cat_info]);
    }
    public function edit_cat(Request $request){
        $data = [
            'title'=>$request->title
        ];
        $rules = [
            'title'=>'required|min:6|unique:categories'
        ];
        $messages = [
            'title.required'=>'Заполните поле!',
            'title.min'=>'Минимальная длина названия- 6 символов',
            'title.unique'=>'Название должно быть уникальным!'
        ];
        $validate = Validator::make($data, $rules, $messages);
        if($validate->fails()){
            return redirect('admin/edit_cat_show/'.$request->id)
            ->withErrors($validate)
            ->withInput();
        }
        else{
            $update = Category::where('id', '=', $request->id)->update([
                'title'=>$request->title
            ]);
            if($update){
                return redirect('admin/categories_admin')->withErrors(['success'=>'Успешное изменение категории!']);
            }
            else{
                return redirect('admin/edit_cat_show/'.$request->id)->withErrors(['error'=>'Не удалось изменить данные!'])->withInput();
            }
        }
        // $edit_cat = '';
    }
}
