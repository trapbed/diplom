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
        $data = [
            'title'=>$request->title,
            // 'img'=>$request->img
        ];
        $rules = [
            'title'=>'required|min:2|unique:categories',
            // 'img'=>'required|image'
        ];
        $messages = [
            'title.required'=>'Заполните поле!',
            'title.min'=>'Минимальная длина названия- 2 символа',
            'title.unique'=>'Название должно быть уникальным!',
            // 'img.required'=>'Обязательное поле!',
            // 'img.image'=>'Выберите изображение',
        ];
        $validate = Validator::make($data, $rules, $messages);
        if($validate->fails()){
            return redirect('admin/categories_admin')
            ->withErrors($validate)
            ->withInput();
        }
        else{
            $create_category = Category::insert(['title'=>$request->title]);
            if($create_category){
                return back()
                ->withErrors(['mess'=>'Успешное создание категории!'])
                ->withInput();
            }
            else{
                return back()
                ->withErrors(['mess'=>'Не удалось создать категорию!'])
                ->withInput();
            }
        }
    }

    public function change_exist_category($exist, $id){
        $change_exist_category = Category::where('id','=',$id)->update(['exist'=>$exist]);
        if($change_exist_category){
            return back()
            ->withErrors(['mess'=>'Успешное обновление категории!'])
            ->withInput();
        }
        else{
            return back()
            ->withErrors(['mess'=>'Не удалось обновить категорию!'])
            ->withInput();
        }
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
            'title'=>'required|min:2|unique:categories'
        ];
        $messages = [
            'title.required'=>'Заполните поле!',
            'title.min'=>'Минимальная длина названия- 2 символа',
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
                return redirect('admin/categories_admin')->withErrors(['mess'=>'Успешное изменение категории!']);
            }
            else{
                return redirect('admin/edit_cat_show/'.$request->id)->withErrors(['mess'=>'Не удалось изменить данные!'])->withInput();
            }
        }
    }
}
