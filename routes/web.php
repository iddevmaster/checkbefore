<?php

use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminConfigController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\CompanyController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();
Route::prefix('admin')->group(function(){
    Route::get('/dashboard',[AdminHomeController::class, 'index'])->name('admin_index');   
    
    //ฟอร์มเช็ค     
    Route::get('/form',[AdminHomeController::class, 'list_form'])->name('admin_form');
    Route::get('/create_form',[AdminHomeController::class, 'create_form'])->name('admin_create_form');
    Route::post('/insert_form',[AdminHomeController::class, 'insert_form'])->name('admin_insert_form');
    Route::get('/frmDetail/{id}',[AdminHomeController::class, 'formDetail'])->name('admin_formDetail');
    Route::get('/frmPreview/{id}',[AdminHomeController::class, 'formPreview'])->name('admin_formPreview');

    //ข้อตรวจ
    Route::get('/frmDetailChoice/{id}',[AdminHomeController::class, 'formDetailChoice'])->name('admin_formDetailChoice');
    Route::get('/add_choice/{id}',[AdminHomeController::class, 'add_chk_choice'])->name('admin_AddChoice');
    Route::post('/insert_choice/{id}',[AdminHomeController::class, 'insert_choice'])->name('admin_InsertChoice');
    route::get('frmChoiceEdit/{id}',[AdminHomeController::class, 'formChoiceEdit'])->name('admin_ChoiceEdit');
    Route::post('/frmChoiceUpdate/{id}',[AdminHomeController::class, 'formChoiceUpdate'])->name('admin_ChoiceUpdate');
    Route::get('/frmChoiceDelete/{id}/{cid}',[AdminHomeController::class, 'formChoiceDelete'])->name('admin_ChoiceDelete');

    //หมวดหมู่
    route::get('frmCategoryEdit/{id}',[AdminHomeController::class, 'formCategoryEdit'])->name('admin_CategoryEdit');
    Route::post('/frmCategoryUpdate/{id}',[AdminHomeController::class, 'formCategoryUpdate'])->name('admin_CategoryUpdate');
    Route::get('/frmCategoryDelete/{cid}/{form_id}',[AdminHomeController::class, 'formCategoryDelete'])->name('admin_CategoryDelete');

    //User
    Route::get('/user',[AdminUserController::class, 'UserList'])->name('admin_Userlist');
    Route::get('/CreateUser',[AdminUserController::class, 'CreateUser'])->name('admin_CreateUser');
    Route::post('/InsertUser',[AdminUserController::class, 'InsertUser'])->name('admin_InsertUser');
    Route::get('/UserDetail/{id}',[AdminUserController::class, 'UserDetail'])->name('admin_UserDetail');

    Route::get('/AgentCreateUser/{id}',[AdminUserController::class, 'CreateAgentUser'])->name('admin_CreateAgentUser');
    Route::post('/AgentInsertUser/{id}',[AdminUserController::class, 'AgentInsertUser'])->name('admin_AgentInsertUser');

    //Config
    Route::get('/ConfigDashboard/{id}',[AdminConfigController::class, 'ConfigDashboard'])->name('admin_ConfigDashboard');
    Route::post('/InsertConfig/{id}',[AdminConfigController::class, 'InsertConfig'])->name('admin_InsertConfig');
    Route::get('/ConfigForm/{id}',[AdminConfigController::class, 'ConfigForm'])->name('admin_ConfigForm');
    Route::post('/InsertConfigForm/{id}',[AdminConfigController::class, 'InsertConfigForm'])->name('admin_InsertConfigForm');
    Route::delete('/UnlistForm',[AdminConfigController::class, 'UnlistForm'])->name('admin_UnlistForm');

})->middleware(['auth','role:admin']);

//role_User
Route::prefix('user')->group(function(){

    Route::get('/front',[UserController::class, 'index'])->name('user_index'); 
    Route::get('/frmchk',[UserController::class, 'FormChk'])->name('user_FormChk');
   
    Route::get('/newchk/{form_id}',[UserController::class, 'NewFormChk'])->name('user_NewFormChk');
    Route::post('/chkinsert/{form_id}',[UserController::class, 'UserChkInsert'])->name('user_ChkInsert');

    Route::get('/list_chk',[UserController::class, 'ListChk'])->name('user_ListChk');  
    Route::get('/formview/{round}',[UserController::class, 'FormView'])->name('user_FormView'); 
    Route::get('/printpreview/{round}',[UserController::class, 'preview_print'])->name('user_printpreview');  

})->middleware(['auth','role:user']);

//role_Company
Route::prefix('company')->group(function(){

    Route::get('/home',[CompanyController::class, 'index'])->name('company_index'); 
    Route::get('/listform',[CompanyController::class, 'ListForm'])->name('company_listform'); 

    Route::get('/groupuser',[CompanyController::class, 'GroupUser'])->name('company_groupuser'); 
 

    Route::get('/setform/{form_id}',[CompanyController::class, 'SettingForm'])->name('company_setform'); 
    Route::post('/insertcar/{form_id}',[CompanyController::class, 'InsertCarData'])->name('company_insertcar');
    Route::get('/updatestatuscar/{form_id}/{id}/{status}',[CompanyController::class, 'UpdateStatusCar'])->name('company_updatestatuscar'); 
    Route::get('/DelCar/{form_id}/{id}',[CompanyController::class, 'DeleteCar'])->name('company_DeleteCar'); 
    Route::get('/editcar/{id}',[CompanyController::class, 'EditCar'])->name('company_editcar'); 
    Route::post('/updatecar/{id}/{form_id}',[CompanyController::class, 'UpdateCar'])->name('company_updatecar');
    Route::get('/formper/{form_id}',[CompanyController::class, 'FormPer'])->name('company_formper');
    
    Route::post('/insertper',[CompanyController::class, 'InsertPer'])->name('company_InsertPer');
    Route::get('/listchkform/{form_id}',[CompanyController::class, 'ListChk'])->name('company_listchkform');
    Route::get('/chkdetail/{round}',[CompanyController::class, 'ChkFormDetail'])->name('company_chkdetail');

    Route::get('/compchk/{form_id}',[CompanyController::class, 'CompanyChk'])->name('company_chk'); 

})->middleware(['auth','role:company']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/printpreview/{round}',[App\Http\Controllers\HomeController::class, 'preview_print'])->name('printpreview');  

