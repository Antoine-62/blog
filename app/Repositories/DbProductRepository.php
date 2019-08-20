<?php
namespace App\Repositories;
 
use App\_product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;

 
class DbProductRepository implements ProductRepositoryInterface {
	
	public function all()
	{
		return _product::all();
	}
	
	public function find($id)
	{
		return _product::find($id);
	}
	

   public function create(array $data)
	{
		$slug = str_slug($data[2]);
		$uest=DB::table('_product')->where('slug',$slug)->count();
	  $count=1;
	  while($uest>0)
	  {
			$count = $count +1;
			$count2 = '_'.$count;
			$slug = str_slug($data[2]).$count2;
			$uest=DB::table('_product')->where('slug',$slug)->count();
	  }
	  
      $share = new _product;
	  $share->Title = $data[1];
      $share->FirstName = $data[2];
      $share->LastName=$data[3];
	  $share->Birth = $data[4];
      $share->City=$data[5];
	  $share->Country = $data[6];
      $share->Mail= $data[7];
	  $share->Phone= $data[8];
	  $share->PreferC= $data[9];
	  $share->Uid = $data[10];
	  $share->slug = $slug;
      $share->filename = $data[11];	 //we enter the name of the image in the database 
      $share->save();
	}

    public function update(array $data, $id)
	{
		 $slug = str_slug($data[2]);
	  $uest=DB::table('_product')->where('slug',$slug)->count();
	  $count=1;
	  if(DB::table('_product')->where('id',$id)->value('slug')==$slug)
	  {
			$uest=$uest-1;
      }
	  while($uest>0)
	  {
			$count = $count +1;
			$count2 = '_'.$count;
			$slug = str_slug($data[2]).$count2;
			$uest=DB::table('_product')->where('slug',$slug)->count();
	  }
	
      $share = _product::find($id);
	  $share->Title = $data[1];
      $share->FirstName = $data[2];
      $share->LastName=$data[3];
	  $share->Birth =$data[4];
      $share->City=$data[5];
	  $share->Country =$data[6];
      $share->Mail=$data[7];
	  $share->Phone=$data[8];
	  $share->PreferC= $data[9];
	  $share->slug=$slug;
	  if( $data[10] !== null)
	  {
			File::delete("uploads/".$share->filename);
			$file=$data[10];
			$filename = date(time()) . '-' . $file->getClientOriginalName();
			$image_resize = Image::make($file->getRealPath());  		
			$image_resize->resize(300, 300);
			$image_resize->save(public_path('uploads/Image-Resize/' .$filename));
			$file->move(public_path('/uploads'), $filename);
			$share->filename = $filename;
	  }
      $share->save();
	}
	
    public function delete($id)
	{
		return _product::destroy($id);
	}

}