<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class PermissionController extends Controller
{
    public function PermissionForm() {
		
		$shares = DB::table('users')->join('role_user', 'users.id', '=', 'role_user.user_id')->where('role_id','2')->orderBy('role_user.id', 'asc')->get('users.*');
		$basics = DB::table('basic_page')->orderBy('id', 'asc')->get();
        return view("Permission.permission", compact('shares', 'basics'));
    }
	
	public function StorePermission(Request $request){	
		
		$slug = str_slug('user-'.$request->get('User_id').'-to-basic-page-'.$request->get('Basic_page_id'));
		$conf = DB::table('permission')->where('slug', $slug)->value('id');
		if(!isset($conf))
		{
			DB::table('permission')->insertGetId(
			['basic_page_id' => $request->get('Basic_page_id'),
			 'user_id' => $request->get('User_id'),
			 'slug' => $slug,
			 ]
			);
		
	  
			Session::flash('message', 'You created a new permission');
			return redirect('AddPermission');
		}
		else
		{
			Session::flash('message', 'You already created this permission');
			return redirect('AddPermission');
		}
		
	}
	
	 public function displayPermission() {
		
		$shares = DB::table('permission')->orderBy('id', 'asc')->get();
		return view("Permission.permission_list", compact('shares'));
		 
    }
	
	public function EditPermission($slug){
	
		$permission = DB::table('permission')->where('slug',$slug)->first();
		$shares = DB::table('users')->join('role_user', 'users.id', '=', 'role_user.user_id')->where('role_id','2')->orderBy('role_user.id', 'asc')->get('users.*');
		$basics = DB::table('basic_page')->orderBy('id', 'asc')->get();
        return view("Permission.EditPermission", compact('permission', 'shares', 'basics'));
	}
	
	public function UpdatePermission(Request $request, $id){	
	
		$slug=str_slug('user-'.$request->get('User_id').'-to-basic-page-'.$request->get('Basic_page_id'));
		$conf = DB::table('permission')->where('slug', $slug)->value('id');
		if(!isset($conf))
		{
			DB::table('permission')->where('id',$id)->update(
			['basic_page_id' => $request->get('Basic_page_id'),
			 'user_id' => $request->get('User_id'),
			 'slug' => $slug,
			 ]
			);
		  Session::flash('message', 'You edit a permission');
		  return redirect('display-Permission');
		 }
		else
		{
			Session::flash('message', 'You already created this permission, you cannot create 2 identical permissions');
			return redirect('AddPermission');
		}
	}
	
	
	public function deletePermission($id) {
		
	  $permission = DB::table('permission')->where('id', $id)->delete();
	  Session::flash('message', "You deleted a permission");
      return  redirect()->back();
    }
}
