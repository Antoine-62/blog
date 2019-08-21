<?php
namespace App\Repositories;
 
use App\basic_page;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;

 
class DbBasicPageRepository implements BasicPageRepositoryInterface {
	
	public function home()
	{
		return DB::table('basic_page')->where('NamePage','Home')->get();
	}
	
	public function about()
	{
		return DB::table('basic_page')->where('NamePage','About')->get();
	}
	
	public function contact()
	{
		return DB::table('basic_page')->where('NamePage','Contact')->get();
	}

    public function create(array $data)
	{
		$slug = str_slug($data[3].' '.$data[1]);
		$uest=DB::table('basic_page')->where('slug',$slug)->count();
		$count=1;
		while($uest>0)
		{
			$count = $count +1;
			$count2 = '_'.$count;
			$slug = str_slug($data[3].' '.$data[1]).$count2;
			$uest=DB::table('basic_page')->where('slug',$slug)->count();
		}

		DB::table('basic_page')->insertGetId(
			['Title' => $data[1],
			 'Content' => $data[2],
			 'NamePage'=>$data[3],
			 'slug'=>$slug
			 ]);
	  
	}

    public function update(array $data, $id)
	{
		$home=DB::table('basic_page')->where('id',$id)->value('NamePage');
		$slug = str_slug($home.' '.$data[1]);
		$uest=DB::table('basic_page')->where('slug',$slug)->count();
		if(DB::table('basic_page')->where('id',$id)->value('slug')==$slug)
		{
			$uest=$uest-1;
		}
		$count=1;
		while($uest>0)
		{
			$count = $count +1;
			$count2 = '_'.$count;
			$slug = str_slug($home.' '.$data[1]).$count2;
			$uest=DB::table('basic_page')->where('slug',$slug)->count();
		}
		
		DB::table('basic_page')
				->where('id', $id)
				->update([
				'Title' => $data[1],
				'Content' => $data[2],
				'slug' => $slug
				]);
				
	}
	
    public function delete($id)
	{
		 return DB::table('basic_page')->where('id', $id)->delete();
	}

}