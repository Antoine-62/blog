<?php
namespace App\Repositories;
 
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
 
class DbUserRepository implements UserRepositoryInterface {
	
	public function all()
	{
		return User::all();
	}
	
	public function find($id)
	{
		return User::find($id);
	}
	
	public function newVideo($id, $i, $filename1)
	{
		DB::table('users')
				->where('id', $id)
				->update(['VideoName'.$i =>$filename1,
				]);	
	}
	
	public function deleteVideo($id)
	{
		$formerName =DB::table('users')
				->where('id', $id)
				->value('VideoName');
	
			
		File::delete( $formerName);
	
		$formerName =DB::table('users')
				->where('id', $id)
				->value('VideoName2');
	
			
		File::delete( $formerName);
	
		$formerName =DB::table('users')
				->where('id', $id)
				->value('VideoName3');
	
			
		File::delete( $formerName);
	
		$formerName =DB::table('users')
				->where('id', $id)
				->value('VideoName4');
	
			
		File::delete( $formerName);
	
		$formerName =DB::table('users')
				->where('id', $id)
				->value('VideoName5');
		
		File::delete( $formerName);
	}
	

   public function create(array $data)
	{
		$slug = str_slug($data[1]);
		$uest=DB::table('users')->where('slug',$slug)->count();
		$count=1;
		while($uest>0)
		{
			$count = $count +1;
			$count2 = '_'.$count;
			$slug = str_slug($data[1]).$count2;
			$uest=DB::table('users')->where('slug',$slug)->count();
		}
		
		$user = User::create([
            'name' =>  $data[1],
            'email' => $data[2],
            'password' =>$data[3],
			'slug'=>$slug,
        ]);
		 $user->roles()->attach($data[4]);
	}

    public function update(array $data, $id)
	{
		$slug = str_slug($data[1]);
		$uest=DB::table('users')->where('slug',$slug)->count();
		if(DB::table('users')->where('id',$id)->value('slug')==$slug)
		{
			$uest=$uest-1;
		}
		$count=1;
		while($uest>0)
		{
			$count = $count +1;
			$count2 = '_'.$count;
			$slug = str_slug($data[1]).$count2;
			$uest=DB::table('users')->where('slug',$slug)->count();
		}
		
        $share = User::find($id);
        $share->name = $data[1];
        $share->email=$data[2];
	    $share->slug=$slug;
	    if(null !=$data[3])
	    {
		   $products=DB::table('role_user')->where('user_id', $id)->delete();
	   	   $share->roles()->attach($data[3]);
	    }
        $share->save();
	}
	
    public function delete($id)
	{
		return User::destroy($id);
	}

}