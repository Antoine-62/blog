<?php
namespace App\Repositories;
 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;

 
class DbPermissionRepository implements PermissionRepositoryInterface {
	
	public function all()
	{
		return DB::table('permission')->orderBy('id', 'asc')->get();
	}
	
	public function find($id)//find permission with user id
	{
		return DB::table('permission')->where('user_id',$id)->value('id');
	}
	
	public function getPermission($slug)
	{
		return DB::table('permission')->where('slug',$slug)->first();
	}
	
    public function create(array $data)
	{
		  DB::table('permission')->insertGetId(
			['basic_page_id' => $data[1],
			 'user_id' => $data[2],
			 'slug' => $data[3],
			 ]);
	}

    public function update(array $data, $id)
	{
		DB::table('permission')->where('id',$id)->update(
			['basic_page_id' => $data[1],
			 'user_id' => $data[2],
			 'slug' => $data[3],
			 ]);
	}
	
    public function delete($id)
	{
		return DB::table('permission')->where('id', $id)->delete();
	}

}