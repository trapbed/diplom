<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LessonController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\CourseController;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::middleware('no_admin_no_author')->group(function(){
    Route::get('/', [CourseController::class, 'main'])->name('main');
    Route::get('/courses/{search?}/{category?}/{order?}', [CourseController::class, 'main_courses'])->name('courses');
    Route::get('/one_course_main/{id_course}', [CourseController::class, 'one_course_main'])->name('one_course_main');
    Route::get('/categories_main', [CategoryController::class, 'categories_main'])->name('categories_main');
});
    

Route::middleware('no_auth')->group(function(){
    Route::get('/login', function(){return view('login');})->name('login');
    Route::post('/login_db', [AuthController::class, 'login_db'])->name('login_db');

    Route::get('/signup', function(){return view('signup');})->name('signup_form');
    Route::post('/signup', [AuthController::class, 'signup'])->name('signup');
    Route::get('/recover_acc', function(){return view('recover_acc');})->name('recover_acc');
    Route::post('/recover_acc', [AuthController::class, 'recover_acc'])->name('recover_acc');
});

// Route::post('/', [AuthController::class, 'login_modal']);


Route::middleware('auth')->group(function(){
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('account', [UserController::class, 'account_info'])->name('student_account');
    Route::post('edit_account', [UserController::class,'edit_account'])->name('edit_account');
    Route::post('/new_pass', [UserController::class, 'new_pass'])->name('new_pass');

    Route::middleware('admin')->group(function(){
        Route::get('admin/main', [UserController::class, 'all_users_admin'])->name('main_admin');
        Route::get('admin/courses', [CourseController::class, 'get_all_admin'])->name('courses_admin');
        Route::get('change_access_course/{access}/{id_course}', [CourseController::class, 'change_access_course'])->name('change_access_course');
        Route::get('change_blocked/{id_user}/{blocked}', [UserController::class, 'change_blocked'])->name('change_blocked');
        Route::get('admin/users_appl', [UserController::class, 'users_appl'])->name('users_appl');
        Route::get('change_role/{id_user}/{id_appl}/{role}/{status_appl}', [UserController::class, 'change_role'])->name('change_role');
        Route::get('admin/categories_admin', [CategoryController::class, 'categories_admin'])->name('categories_admin');
        Route::post('/create_category', [CategoryController::class, 'create_category'])->name('create_category');
        Route::get('/admin/edit_cat_show/{id}', [CategoryController::class, 'edit_cat_show'])->name('edit_cat_show');
        Route::post('/admin/edit_cat', [CategoryController::class, 'edit_cat'])->name('edit_cat');
        Route::get('change_exist_category/{exist}/{id}', [CategoryController::class, 'change_exist_category'])->name('change_exist_category');
        Route::get('/set_access/{id_course}/{id_appl}/{wish}/{act}', [CourseController::class, 'set_access'])->name('set_access');

        Route::get('/course_applications', [CourseController::class, 'get_course_applications'])->name('course_applications');
    });    
    
    Route::middleware('student')->group(function(){
        Route::get('start_study/{id_course}', [UserController::class, 'start_study'])->name('start_study');
        Route::get('complete_course/{id_course}', [UserController::class, 'complete_course'])->name('complete_course');
        Route::get('one_lesson_student/{id}/{course}', [LessonController::class, 'one_lesson_student'])->name('one_lesson_student');
        Route::get('/my_courses', [CourseController::class, 'my_courses'])->name('my_courses');
    });

    // $id_user, $id_appl, $role, $status_appl
    

    Route::middleware('author')->group(function(){

        Route::get('/author/courses', [CourseController::class, 'main_courses'])->name('main_author');
        Route::get('/create_course_show', [CourseController::class,'create_course_show'])->name('create_course_show');
        Route::post('/create_course', [CourseController::class,'create_course'])->name('create_course');
        Route::get('author/update_course_show/{id_course}', [CourseController::class, 'update_course_show'])->name('update_course_show');
        Route::post('/author/update_course', [CourseController::class, 'update_course'])->name('update_course');
        Route::get('/author_more_info_course/{id}', [CourseController::class, 'author_more_info_course'])->name('author_more_info_course');
        Route::get('/create_lesson_show/{id}', [CourseController::class, 'data_for_create_course'])->name('create_lesson_show');
        Route::post('/create_lesson', [LessonController::class, 'create_lesson'])->name('create_lesson');
        Route::get('/remove_lesson/{id_less}/{id_course}', [LessonController::class, 'remove_lesson'])->name('remove_lesson');
        Route::get('/one_lesson/{id}', [LessonController::class, 'one_lesson'])->name('one_lesson');

        Route::post('/add_to_dir', [LessonController::class, 'add_to_dir'])->name('add_to_dir');
        Route::get('/get_images_lesson', [LessonController::class, 'images_lesson'])->name('get_images_lesson');
        
        Route::get('/application_courses', [CourseController::class, 'application_courses'])->name('application_courses');
        Route::get('/send_access/{course_id}/{wish_access}', [CourseController::class, 'send_access'])->name('send_access');
    });
});



// Route::middleware('admin')->group(function () {
// });