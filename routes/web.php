<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
	
define('TEST','');

/*****************************************************************Test web routes***************************************************/

/*/Route::get('form', function () {
	return view("hello");
});*/

/*Home*/
Route::get('/home', 'HomeController@index')->name('/home');

/*Product*/
Route::put('add', 'ProductController@storeUseradd')->name('store-submit');
Route::get('form', 'ProductController@Index')->name('form')/*->middleware('auth2')*/;
Route::get('ProducQ-Form', 'ProductController@FormPQ')->name('ProducQ-Form')/*->middleware('auth2')*/;
Route::get('ProductEdit/{slug}', 'ProductController@editPorductQ')->name('MemberEdit/{slug}');//productQ
Route::put('ProductEdit/EditProductConf/{id}', 'ProductController@updatePoductQ')->name('ProductEdit/EditProductConf/{id}');//productQ
Route::get('MemberEdit/{id}', 'ProductController@editMember')->name('MemberEdit/{id}');//member
Route::put('MemberEdit/EditMemberConf/{id}', 'ProductController@updateMember')->name('MemberEdit/EditMemberConf/{id}');//menber
Route::put('store-user/add', 'ProductController@storeMemberadd')->name('store-user-submit');
Route::put('store-productQ/add', 'ProductController@storeProductQ')->name('store-productQ-submit');
Route::get('display-Member', 'ProductController@Display')->name('display-Member');
Route::get('exportProductCSV', 'ProductController@exportProduct')->name('exportProductCSV');//export csv Product
Route::get('exportProductQCSV', 'ProductController@exportProductQ')->name('exportProductQCSV');//export csv ProductQ
Route::put('importProductCSV', 'ProductController@ImportProduct')->name('importProductCSV');//import csv Product
Route::put('importProductQCSV', 'ProductController@ImportProductQ')->name('importProductQCSV');//import csv ProductQ
Route::delete('Member/{id}', 'ProductController@deleteMember')->name('Member/{id}');
Route::delete('ProductQ/{id}', 'ProductController@deleteProductQ')->name('ProductQ/{id}');
Route::delete('ProductEdit/deleteProductQIm/{id}', 'ProductController@deleteImageProductQ')->name('ProductEdit/deleteProductQIm/{id}');
//Route::resource('form', 'ProductController');MemberEdit/EditMemberConf/13

/*User*/
Route::get('MyProfil/{slug}', 'UserController@Profil')->name('MyProfil/{slug}')->middleware('CheckUser');
Route::get('BoardAdmin', 'UserController@IndexA')->name('BoardAdmin')->middleware('is_admin');
Route::get('LogIn', 'UserController@SignI')->name('LogIn');
Route::get('progressFF', 'UserController@progressFFmpeg')->name('progressFF');
Route::get('Registration', 'UserController@Regist')->name('Registration')/*->middleware('test')*/;
Route::get('AddUser', 'UserController@Form2')->name('AddUser')->middleware('is_admin');
Route::get('UserEdit/{slug}', 'UserController@editUser')->name('UserEdit/{slug}')->middleware('is_admin');//admin
Route::get('MyProfil/UserEdit/{slug}', 'UserController@editUser')->name('MyProfil/UserEdit.show')->middleware('CheckUser');//user
Route::put('MyProfil/UserEdit/uploadIm/{id}', 'UserController@StoreImW')->name('MyProfil/UserEdit/uploadIm/{id}');//user
Route::post('MyProfil/UserEdit/uploadVid/{id}', 'UserController@StoreVidW')->name('uploadVid');//user
Route::get('MyProfil/UserEdit/getName/{id}/{numberVideo}', 'UserController@getNameV')->name('getName');//user
Route::put('UserEdit/EditUserConf/{id}', 'UserController@updateUser')->name('UserEdit/EditUserConf/{id}');//menber
Route::put('MyProfil/UserEdit/EditUserConf/{id}', 'UserController@updateUser')->name('MyProfil/UserEdit/EditUserConf/{id}');//menber
Route::put('store-user-adm/add', 'UserController@storeUseradm')->name('store-userAdm-submit');
Route::get('display-User', 'UserController@DisplayUs')->name('display-User')->middleware('is_admin');
Route::get('exportUserList', 'UserController@exportUserList')->name('exportUserList');//export csv user
Route::put('importUserCSV', 'UserController@ImportUserList')->name('importUserCSV');//export csv user
Route::delete('User/{id}', 'UserController@deleteUser')->name('User/{id}');
Route::post('MyProfil/UserEdit/deleteVid/uploads/video/{name}', 'UserController@DeleteVideo')->name('MyProfil/UserEdit/deleteVid/{name}');//to delete
Route::post('MyProfil/UserEdit/deleteVid/{name}', 'UserController@DeleteVideo')->name('MyProfil/UserEdit/{name}');//to delete
Route::delete('MyProfil/DeleteVideo/uploads/video/{name}', 'UserController@DeleteVideo')->name('MyProfil/DeleteVideo/{name}');
//Route::delete('MyProfil/UserEdit/deleteVid/uploads/{name}', 'UserController@DeleteVideo')->name('MyProfil/UserEdit/deleteVid/{name}');
Route::delete('UserEdit/deleteVid/uploads/video/{name}', 'UserController@DeleteVideo')->name('UserEdit/deleteVid/{name}')->middleware('is_admin');//admin

//http://localhost/blog/public/display-User	

/*Admin(+view website)*/
Route::get('AddBannerImage', 'AdminController@FormBanIm')->name('AddBannerImage')->middleware('is_admin');
Route::get('AddBasicPage/{About}', 'AdminController@FormBasicP')->name('AddBasicPage/{About}')->middleware('is_admin');
Route::get('AddBasicPage2', 'AdminController@FormBasicP2')->name('AddBasicPage2')->middleware('is_admin');
Route::get('AddBasicPage3', 'AdminController@FormBasicP3')->name('AddBasicPage3')->middleware('is_admin');
Route::put('AddBannerImage/Add', 'AdminController@storeBanIm')->name('AddBannerImage/Add');
Route::put('AddBasicPage/AddBasicPage/Add/{About}', 'AdminController@storeBasP')->name('AddBasicPage/AddBasicPage/Add/{About}');
Route::put('AddBasicPage/Add/{About}', 'AdminController@storeBasP')->name('AddBasicPage/Add/{About}');
Route::get('Home2', 'AdminController@home')->name('Home2');
Route::get('About-us', 'AdminController@AboutUs')->name('About-us');
Route::get('Contact-us', 'AdminController@ContactUs')->name('Contact-us');
Route::get('editContent/{slug}', 'AdminController@editBasicPage')->name('editContent/{slug}')->middleware('hasPermissions');
Route::get('getGlobalVariable', 'AdminController@GlobalPage')->name('getGlobalVariable')->middleware('is_admin');
Route::put('changeGlobalVariable', 'AdminController@UpdateGlobalV')->name('changeGlobalVariable')->middleware('is_admin');
Route::put('editContent/EditContentConf/{id}', 'AdminController@updateBasicPage')->name('editContent/EditContentConf/{id}');
Route::delete('deleteContent/{id}', 'AdminController@deleteBasicCont')->name('deleteContent/{id}');
Route::delete('deleteBannerI/{id}', 'AdminController@deleteBannerIm')->name('deleteBannerI/{id}');

/*Faq*/
Route::get('faq', 'FaqController@DisplayFaq')->name('faq');
Route::get('admin/add/faq', 'FaqController@getFaqForm')->name('admin/add/faq')->middleware('is_admin');
Route::put('admin/add/faq/confirmation', 'FaqController@storeFAQ')->name('admin/add/faq/confirmation')->middleware('is_admin');
Route::get('admin/edit/faq/{slug}', 'FaqController@editFaq')->name('admin/edit/faq/{id}')->middleware('is_admin');
Route::put('admin/edit/faq/confirmation/{id}', 'FaqController@updateFaq')->name('admin/edit/faq/confirmation/{id}')->middleware('is_admin');
Route::delete('Delete-Question/{id}', 'FaqController@deleteFaq')->name('Delete-Question/{id}');

/*Permission*/
Route::get('AddPermission', 'PermissionController@PermissionForm')->name('AddPermission')->middleware('is_admin');
Route::put('AddPermission/Add', 'PermissionController@StorePermission')->name('AddPermission/Add');
Route::get('display-Permission', 'PermissionController@displayPermission')->name('display-Permission')->middleware('is_admin');
Route::get('EditPermission/{slug}', 'PermissionController@EditPermission')->name('EditPermission/{slug}')->middleware('is_admin');
Route::put('EditPermission/UpdatePermission/{id}', 'PermissionController@UpdatePermission')->name('EditPermission/UpdatePermission/{id}')->middleware('is_admin');
Route::delete('Delete-permission/{id}', 'PermissionController@deletePermission')->name('Delete-permission/{id}')->middleware('is_admin');


/*Register*/
Route::get('/user/verify/{token}', 'Auth\RegisterController@verifyUser')->name('/user/verify/{token}');

/*Some tests*/
Route::get('co', 'ProductController@Confirmation')->name('co');
Route::get('co2', 'ProductController@Confirmation2')->name('co2');
Route::put('co3', 'ProductController@Confirmation3')->name('co3')->middleware('test');


?>

