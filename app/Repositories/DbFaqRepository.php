<?php
namespace App\Repositories;
 
use App\faq;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;

 
class DbFaqRepository implements FaqRepositoryInterface {
	
	public function all()
	{
		return DB::table('faq')->orderBy('id', 'desc')->get();
	}
	
	public function findEdit($slug)
	{
		return DB::table('faq')->where('slug',$slug)->first();
	}
	
    public function create(array $data)
	{
		if($data[3] == null){
		$status = 0;
		} else {
		$status = $data[3];
		}
		
		$count = DB::table('faq')->where('Question',$data[1])->count();
		if($count == 0)
		{
			$count2='';
		}
		else
		{
			$count = $count+1;
			$count2 = '_'.$count;
		}
		$slug = str_slug($data[1]).$count2;
		$uest=DB::table('faq')->where('slug',$slug)->count();
		while($uest>0)
		{
			$count = $count +1;
			$count2 = '_'.$count;
			$slug = str_slug($data[1]).$count2;
			$uest=DB::table('faq')->where('slug',$slug)->count();
		}
		DB::table('faq')->insertGetId(
			['Question' => $data[1],
			 'Answer' => $data[2],
			 'Status'=> $status,
			 'slug' => $slug,
			 ]
		);
	}

    public function update(array $data, $id)
	{
		if($data[3] == null){
		$status = 0;
		} else {
		$status = $data[3];
		}
		
		$count = DB::table('faq')->where('Question',$data[1])->count();
		if($count == 0)
		{
			$count2='';
		}
		else
		{
			$count = $count+1;
			$count2 = '_'.$count;
		}
		$slug = str_slug($data[1]).$count2;
		$uest=DB::table('faq')->where('slug',$slug)->count();
		while($uest>0)
		{
			$count = $count +1;
			$count2 = '_'.$count;
			$slug = str_slug($data[1]).$count2;
			$uest=DB::table('faq')->where('slug',$slug)->count();
		}
		
			DB::table('faq')
				->where('id', $id)
				->update(['Question' => $data[1],
				'Answer' => $data[2],
				'Status'=> $status,
				 'slug' => $slug,
				]);
				
	}
	
    public function delete($id)
	{
		return DB::table('faq')->where('id', $id)->delete();
	}

}