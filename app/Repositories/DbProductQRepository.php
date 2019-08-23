<?php
namespace App\Repositories;
 
use App\_product_q;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;

 
class DbProductQRepository implements ProductQRepositoryInterface {
	
	public function all()
	{
		return DB::table('_product_q')->orderBy('id', 'desc')->get();
	}
	
	public function find($id)
	{
		return _product_q::find($id);
	}
	

    public function create(array $data)
	{
		$slug = str_slug($data[1]);
		$uest=DB::table('_product_q')->where('slug',$slug)->count();
		$count=1;
		while($uest>0)
		{
			$count = $count +1;
			$count2 = '_'.$count;
			$slug = str_slug($data[1]).$count2;
			$uest=DB::table('_product_q')->where('slug',$slug)->count();
		}
	 
		DB::table('_product_q')->insertGetId(
			['Name' => $data[1],
			 'Category' => $data[2],
			 'Price'=> $data[3],
			 'ProductS'=> $data[4],
			 'Uid'=> $data[5],
			 'slug'=>$slug
			 ]
		);
		
		//$iddb=DB::table('_product_q')->where('Name',$request->get('Name'))->get();
		$files = $data[6];
		
		foreach($files as $file){	
		$idd = DB::table('_product_q')->where('slug',$slug)->value('id');
		$filename = date(time()) . '-' . $file->getClientOriginalName();
		$image_resize = Image::make($file->getRealPath());  		
		$image_resize->resize(300, 300);
		$image_resize->save(public_path('uploads/Image-Resize/' .$filename));
		$file->move(public_path('/uploads'), $filename);
		DB::table('files')->insertGetId(
		 ['name' =>  $filename,
		 'productQ_id'=>$idd]);
		 
		}
	}

    public function update(array $data, $id)
	{
		$slug = str_slug($data[1]);
		$uest=DB::table('_product_q')->where('slug',$slug)->count();
		$count=1;
		if(DB::table('_product_q')->where('id',$id)->value('slug')==$slug)
	    {
			$uest=$uest-1;
        }
		while($uest>0)
		{
			$count = $count +1;
			$count2 = '_'.$count;
			$slug = str::slug($data[1]).$count2;
			$uest=DB::table('faq')->where('slug',$slug)->count();
		}

		 if( $data[5] !== null)
		{
		
			DB::table('_product_q')
				->where('id', $id)
				->update(['Name' => $data[1],
				'Category' => $data[2],
				'Price'=> $data[3],
				'ProductS'=> $data[4],
				'slug'=>$slug,
				]);
			$files = $data[5];
		
			foreach($files as $file){	
			$idd = DB::table('_product_q')->where('Name',$data[1])->value('id');
			$filename = date(time()) . '-' . $file->getClientOriginalName();
			$image_resize = Image::make($file->getRealPath());  		
			$image_resize->resize(300, 300);
			$image_resize->save(public_path('uploads/Image-Resize/' .$filename));
			$file->move(public_path('/uploads'), $filename);
		 
			DB::table('files')->insertGetId(
			['name' =>  $filename,
			'productQ_id'=>$idd]);
		 
			}
		}
		else
			{
			DB::table('_product_q')
				->where('id', $id)
				->update(['Name' => $data[1],
				'Category' => $data[2],
				'Price'=> $data[3],
				'ProductS'=> $data[4],
				'slug'=>$slug,
				]);
		}
	}
	
    public function delete($id)
	{
		$files = DB::table('files')->where('productQ_id', $id)->get();
		foreach($files as $fil)
		{
				File::delete("uploads/".$fil->name);
				DB::table('files')->where('id', $fil->id)->delete();
					
		}
		$user_profile = DB::table('_product_q')->where('id', $id)->delete();
	}

}