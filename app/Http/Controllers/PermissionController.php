<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use App\Repositories\PermissionRepositoryInterface;
use App\Http\Resources\permissionsResource;

class PermissionController extends Controller
{
	 private $permissionRepository;
	 public function __construct(PermissionRepositoryInterface $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }
	
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
			$data = array();
			$data[1]= $request->get('Basic_page_id');
			$data[2]= $request->get('User_id');
			$data[3]= $slug;
			$this->permissionRepository->create($data);
	  
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
		
		$shares = $this->permissionRepository->all();
		return view("Permission.permission_list", compact('shares'));
		 
    }
	
	public function EditPermission($slug){
	
		$permission = $this->permissionRepository->getPermission($slug);
		$shares = DB::table('users')->join('role_user', 'users.id', '=', 'role_user.user_id')->where('role_id','2')->orderBy('role_user.id', 'asc')->get('users.*');
		$basics = DB::table('basic_page')->orderBy('id', 'asc')->get();
        return view("Permission.EditPermission", compact('permission', 'shares', 'basics'));
	}
	
	public function show()
	{
		 $posts = $this->permissionRepository->all();
		 return new permissionsResource($posts);
	}
	
	public function UpdatePermission(Request $request, $id){	
	
		$slug=str_slug('user-'.$request->get('User_id').'-to-basic-page-'.$request->get('Basic_page_id'));
		$conf = DB::table('permission')->where('slug', $slug)->value('id');
		if(!isset($conf))
		{
			$data = array();
			$data[1]= $request->get('Basic_page_id');
			$data[2]= $request->get('User_id');
			$data[3]= $slug;
			$this->permissionRepository->update($data,$id);
			
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
		
	  $this->permissionRepository->delete($id);
	  Session::flash('message', "You deleted a permission");
      return  redirect()->back();
    }
}
