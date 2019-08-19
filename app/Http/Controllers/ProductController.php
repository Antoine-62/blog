<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductRequest2;
use App\Http\Requests\ProductQRequest;
use App\Http\Requests\ProductQRequest2;
use App\Http\Requests\ProductRequestImp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\_product;
use App\_product_q;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Session;
use Illuminate\Support\Facades\Hash;
use Auth;
use url_aliases;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function Index() {

        return view("product.hello");
    }
	
	public function FormPQ() {

        return view("product.FormQ");
    }
	
	public function Authentif() {

        return view("product.Auth");
    }
	
	public function Confirmation() {

        return view("product.conf");
    }
	
		public function Confirmation2() {

        return view("product.conf2");
    }
	
	public function Confirmation3() {

        return view("product.conf3");
    }
	
	
	
	 public function Display() {
       
	    $shares = _product::all();
		$productQs = DB::table('_product_q')->orderBy('id', 'desc')->get();
		$fils = DB::table('files')->orderBy('id', 'desc')->get();
        return view('product.display', compact('shares','productQs','fils'));
    }
	
	
	  public function storeMemberadd(ProductRequest2 $request) {	

	  $slug = str_slug($request->get('FirstName'));
	  $uest=DB::table('_product')->where('slug',$slug)->count();
	  $count=1;
	  while($uest>0)
	  {
			$count = $count +1;
			$count2 = '_'.$count;
			$slug = str_slug($request->get('FirstName')).$count2;
			$uest=DB::table('_product')->where('slug',$slug)->count();
	  }
	  
      $share = new _product;
	  $share->Title = $request->get('Title');
      $share->FirstName = $request->get('FirstName');
      $share->LastName=$request->get('LastName');
	  $share->Birth = $request->get('Birth');
      $share->City=$request->get('City');
	  $share->Country = $request->get('Country');
      $share->Mail= $request->get('Mail');
	  $share->Phone= $request->get('Phone');
	  $share->PreferC= $request->get('PreferC');
	  $share->Uid = Auth::user()->id;
	  $share->slug = $slug;
	  
	  #To store the file and create resize image
	  $file=$request->fileU;//we get the image
	  $filename = date(time()) . '-' . $file->getClientOriginalName();//we give a name to the image
	  $image_resize = Image::make($file->getRealPath());  	//We create a second image from the image	
	  $image_resize->resize(300, 300);//we resize the image
	  $image_resize->save(public_path('uploads/Image-Resize/' .$filename));//we store the 2nd image in a specific directory
	  $file->move(public_path('/uploads'), $filename);//we store the 1rst image in uploads directory
      $share->filename = $filename;	 //we enter the name of the image in the database
	  
	  
      $share->save();
	  
	  Session::flash('message', 'Congratulations, you create a new member!');
	  return redirect('display-Member');
   }
   
   
   
   
	  
	/*For the member(yes It's no clear with the user, soory)*/
	public function deleteMember($id) {
		
	  $share = _product::findOrFail($id);	
	 // Storage::delete($share->filename);
	  File::delete("uploads/".$share->filename);
	  $share->delete();

	  Session::flash('message', 'Congratulations, you deleted a product');
	  return redirect('display-Member');
    }
	
	

	/*For the member*/
	public function editMember($slug) {
		
		$share = DB::table('_product')->where('slug',$slug)->first();
		return view('product.Edit', compact('share'));
    }
	
	
	public function updateMember(ProductRequest $request, $id) {
		
	  $slug = str_slug($request->get('FirstName'));
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
			$slug = str_slug($request->get('FirstName')).$count2;
			$uest=DB::table('_product')->where('slug',$slug)->count();
	  }
	
      $share = _product::find($id);
	  $share->Title = $request->get('Title');
      $share->FirstName = $request->get('FirstName');
      $share->LastName=$request->get('LastName');
	  $share->Birth = $request->get('Birth');
      $share->City=$request->get('City');
	  $share->Country = $request->get('Country');
      $share->Mail= $request->get('Mail');
	  $share->Phone= $request->get('Phone');
	  $share->PreferC= $request->get('PreferC');
	  $share->slug=$slug;
	  if( $request->file('fileU') !== null)
	  {
			//Storage::delete($share->filename);
			File::delete("uploads/".$share->filename);
			//$filename = $request->file('fileU')->storeAs('files',date('d-m-Y H:i:s',time()) . '-' . $request->fileU->getClientOriginalName());
			$file=$request->fileU;
			$filename = date(time()) . '-' . $file->getClientOriginalName();
			$image_resize = Image::make($file->getRealPath());  		
			$image_resize->resize(300, 300);
			$image_resize->save(public_path('uploads/Image-Resize/' .$filename));
			$file->move(public_path('/uploads'), $filename);
			$share->filename = $filename;
	  }
      $share->save();
	  Session::flash('message', 'You just made a cool edit to your product.');
	  return redirect('display-Member');

    }

	/*Store productQ*/

 public function storeProductQ(ProductQRequest $request) {
	 
	   
		$slug = str_slug($request->get('Name'));
		$uest=DB::table('_product_q')->where('slug',$slug)->count();
		$count=1;
		while($uest>0)
		{
			$count = $count +1;
			$count2 = '_'.$count;
			$slug = str_slug($request->get('Name')).$count2;
			$uest=DB::table('_product_q')->where('slug',$slug)->count();
		}
	 
		DB::table('_product_q')->insertGetId(
			['Name' => $request->get('Name'),
			 'Category' => $request->get('Category'),
			 'Price'=> $request->get('Price'),
			 'ProductS'=> $request->get('ProductS'),
			 'Uid'=> Auth::user()->id,
			 'slug'=>$slug
			 ]
		);
		
		//$iddb=DB::table('_product_q')->where('Name',$request->get('Name'))->get();
		$files = $request->file('photos');
		
		foreach($files as $file){	
		$idd = DB::table('_product_q')->where('slug',$slug)->value('id');
		$filename    = date(time()) . '-' . $file->getClientOriginalName();
		$image_resize = Image::make($file->getRealPath());  		
		$image_resize->resize(300, 300);
		$image_resize->save(public_path('uploads/Image-Resize/' .$filename));
		$file->move(public_path('/uploads'), $filename);
		DB::table('files')->insertGetId(
		 ['name' =>  $filename,
		 'productQ_id'=>$idd]);
		 
		}
		
	  
	  Session::flash('message', 'Congratulations, you create a new Product!');
	  return redirect('display-Member');
    }
	
	/*ProductQ Edit*/
	public function editPorductQ($slug) {
		//$productQs = _product::find($id);
		$productQs = DB::table('_product_q')->where('slug',$slug)->first();
		$fils = DB::table('files')->where('productQ_id',$productQs->id)->get();
		return view('product.EditQ', compact('productQs','fils'));
    }
	
	/*ProductQ update*/
	public function updatePoductQ(ProductQRequest2 $request, $id) {
		
		$slug = str_slug($request->get('Name'));
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
			$slug = str::slug($request->get('Name')).$count2;
			$uest=DB::table('faq')->where('slug',$slug)->count();
		}

		 if( $request->file('photos') !== null)
		{
		
			DB::table('_product_q')
				->where('id', $id)
				->update(['Name' => $request->get('Name'),
				'Category' => $request->get('Category'),
				'Price'=> $request->get('Price'),
				'ProductS'=> $request->get('ProductS'),
				'slug'=>$slug,
				]);
			$files = $request->file('photos');
		
			foreach($files as $file){	
			$idd = DB::table('_product_q')->where('Name',$request->get('Name'))->value('id');
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
				->update([
				'Name' => $request->get('Name'),
				'Category' => $request->get('Category'),
				'Price'=> $request->get('Price'),
				'ProductS'=> $request->get('ProductS'),
				'slug'=>$slug,
				]);
		}

    	Session::flash('message', 'You edit your ProductQ.');
	    return redirect('display-Member');

    }
	
	public function deleteProductQ($id) {
		
			$files = DB::table('files')->where('productQ_id', $id)->get();
			foreach($files as $fil)
			{
					File::delete("uploads/".$fil->id);
					DB::table('files')->where('id', $fil->id)->delete();
					
			}
			$user_profile = DB::table('_product_q')->where('id', $id)->delete();


	  Session::flash('message', 'You deleted your ProductQ');
	  
	  return redirect('display-Member');
    }
	
	public function deleteImageProductQ($id) {
		
			$user_profile = DB::table('files')->where('id', $id)->value('name');
			File::delete("uploads/".$user_profile);
			$user_profile = DB::table('files')->where('id', $id)->delete();
	  

	  Session::flash('message', "You deleted an image");
	  
	  return redirect()->back();
    }
	
	/*Export csv file product*/
	public function exportProduct(Request $request){       
    $products=DB::table('_product')->get();
    $tot_record_found=0;
    if(count($products)>0){
        $tot_record_found=1;
         
        $CsvData=array('Id, Title, First Name, Last Name, Birt Date, City, Country, Email, Phone, Prefer, FileName, Uid');          
        foreach($products as $product){              
            $CsvData[]=$product->id.','.$product->Title.','.$product->FirstName.','.$product->LastName.','.$product->birth.','.$product->City.','.$product->Country.','.$product->Mail.','.$product->Phone.','.$product->PreferC.','.$product->filename.','.$product->Uid;
        }
         
        $filename="ProductList".date('Y-m-d').".csv";
        $file_path=base_path().'/'.$filename;   
        $file = fopen($file_path,"w+");
        foreach ($CsvData as $exp_data){
          fputcsv($file,explode(',',$exp_data));
        }   
        fclose($file);          
 
        $headers = ['Content-Type' => 'application/csv'];
        return response()->download($file_path,$filename,$headers );
    }
	Session::flash('message', "You can't download the product list");	  
	return redirect()->back();
	}
	
		/*Export csv file productQ*/
	public function exportProductQ(Request $request){       
    $products=DB::table('_product_q')->get();
    $tot_record_found=0;
    if(count($products)>0){
        $tot_record_found=1;
         
        $CsvData=array('Id, Name, Category, Price, State of the product, User Id');          
        foreach($products as $product){              
            $CsvData[]=$product->id.','.$product->Name.','.$product->Category.','.$product->Price.','.$product->ProductS.','.$product->Uid;
        }
         
        $filename="ProductQList".date('Y-m-d').".csv";
        $file_path=base_path().'/'.$filename;   
        $file = fopen($file_path,"w+");
        foreach ($CsvData as $exp_data){
          fputcsv($file,explode(',',$exp_data));
        }   
        fclose($file);          
 
        $headers = ['Content-Type' => 'application/csv'];
        return response()->download($file_path,$filename,$headers );
    }
	Session::flash('message', "You can't download the productQ list");	  
	return redirect()->back();
	}
	
	/*Import CSV file for product*/
	public function ImportProduct(ProductRequestImp $request){
		
		$files = $request->file('photos');
		
		foreach($files as $fil){	
		 $filename = date(time()) . '-' . $fil->getClientOriginalName();
		$fil->move(public_path('/uploads'), $filename);
		$CsvPath[] = $filename;}

      $file = $request->file('file');

      // File Details 
      $filename = $file->getClientOriginalName();
      $extension = $file->getClientOriginalExtension();

          // File upload location
          $location = 'uploads';

          // Upload file
          $file->move($location,$filename);

          // Import CSV to Database
          $filepath = public_path($location."/".$filename);

          // Reading file
          $file = fopen($filepath,"r");

          $importData_arr = array();
          $i = 0;

          while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
             $num = count($filedata );
             for ($c=0; $c < $num; $c++) {
                $importData_arr[$i][] = $filedata [$c];
             }
             $i++;
          }
          fclose($file);

          // Insert to MySQL database
		  $c=0;
          foreach($importData_arr as $importData){

            $insertData = array(
               "Title"=>$importData[0],
               "FirstName"=>$importData[1],
               "LastName"=>$importData[2],
               "birth"=>$importData[3],
			   "City"=>$importData[4],
			   "Country"=>$importData[5],
			   "Mail"=>$importData[6],
			   "Phone"=>$importData[7],
			   "PreferC"=>$importData[8],
			   "filename"=>$CsvPath[$c],
			   "Uid"=>Auth::user()->id,
			   );
			DB::table('_product')->insertGetId($insertData);
			$c=$c+1;
          }
		  File::delete( $filepath);

          Session::flash('message','Import Successful.');



    // Redirect to index
    return redirect()->back();
  }
  
  	/*Import CSV file for product*/
	public function ImportProductQ(ProductRequestImp $request){

      $file = $request->file('file');

      // File Details 
      $filename = $file->getClientOriginalName();
      $extension = $file->getClientOriginalExtension();

          // File upload location
          $location = 'uploads';

          // Upload file
          $file->move($location,$filename);

          // Import CSV to Database
          $filepath = public_path($location."/".$filename);

          // Reading file
          $file = fopen($filepath,"r");

          $importData_arr = array();
          $i = 0;

          while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
             $num = count($filedata );
             for ($c=0; $c < $num; $c++) {
                $importData_arr[$i][] = $filedata [$c];
             }
             $i++;
          }
          fclose($file);

          // Insert to MySQL database
          foreach($importData_arr as $importData){

            $insertData = array(
               "Name"=>$importData[0],
               "Category"=>$importData[1],
               "Price"=>$importData[2],
               "ProductS"=>$importData[3],
			   "Uid"=>Auth::user()->id,
			   );
			DB::table('_product_q')->insertGetId($insertData);

          }
		  File::delete( $filepath);

          Session::flash('message','Import Successful.');



    // Redirect to index
    return redirect()->back();
  }
	
	
		

}

