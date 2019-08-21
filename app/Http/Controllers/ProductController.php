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
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;
use App\Repositories\ProductRepositoryInterface;
use App\Repositories\ProductQRepositoryInterface;


class ProductController extends Controller
{
	
	private $productRepository;
	private $productQRepository;
	
    public function __construct(ProductRepositoryInterface $productRepository,ProductQRepositoryInterface $productQRepository)
    {
        $this->productRepository = $productRepository;
		$this->productQRepository = $productQRepository;
    }
	
    public function Index() {

        return view("product.hello");
    }
	
	public function FormPQ() {

        return view("product.FormQ");
    }
	
	public function Authentif() {

        return view("product.Auth");
    }	
	
	 public function Display() {
       
	    $shares = $this->productRepository->all();
		$productQs = $this->productQRepository->all();
		$fils = DB::table('files')->orderBy('id', 'desc')->get();
        return view('product.display', compact('shares','productQs','fils'));
    }
	
	
	  public function storeMemberadd(ProductRequest2 $request) {	
	  
	  #To store the file and create resize image
	  $file=$request->fileU;//we get the image
	  $filename = date(time()) . '-' . $file->getClientOriginalName();//we give a name to the image
	  $image_resize = Image::make($file->getRealPath());  	//We create a second image from the image	
	  $image_resize->resize(300, 300);//we resize the image
	  $image_resize->save(public_path('uploads/Image-Resize/' .$filename));//we store the 2nd image in a specific directory
	  $file->move(public_path('/uploads'), $filename);//we store the 1rst image in uploads directory  
	  
	  $data = array();
	  $data[1]= $request->get('Title');
	  $data[2]= $request->get('FirstName');
      $data[3]= $request->get('LastName');
	  $data[4] = $request->get('Birth');
	  $data[5] =$request->get('City');
	  $data[6] = $request->get('Country');
	  $data[7] =  $request->get('Mail');
	  $data[8] = $request->get('Phone');
	  $data[9] = $request->get('PreferC');
	  $data[10] = Auth::user()->id;
	  $data[11] = $filename;	 //we enter the name of the image in the database
	  $this->productRepository->create($data);
	  
	  Session::flash('message', 'Congratulations, you create a new member!');
	  return redirect('display-Member');
   }
   
   
   
   
	  
	/*For the member(yes It's no clear with the user, soory)*/
	public function deleteMember($id) {
		
	  $share = $this->productRepository->find($id);	
	 // Storage::delete($share->filename);
	  File::delete("uploads/".$share->filename);
	  $this->productRepository->delete($id);

	  Session::flash('message', 'Congratulations, you deleted a product');
	  return redirect('display-Member');
    }
	
	

	/*For the member*/
	public function editMember($slug) {
		
		$share = DB::table('_product')->where('slug',$slug)->first();
		return view('product.Edit', compact('share'));
    }
	
	
	public function updateMember(ProductRequest $request, $id) {
		
      $data = array();
	  $data[1] = $request->get('Title');
      $data[2] = $request->get('FirstName');
      $data[3]=$request->get('LastName');
	  $data[4] = $request->get('Birth');
      $data[5]=$request->get('City');
	  $data[6] = $request->get('Country');
      $data[7]= $request->get('Mail');
	  $data[8]= $request->get('Phone');
	  $data[9]= $request->get('PreferC');
	  $data[10]=$request->file('fileU');
	  $this->productRepository->update($data,$id);
	
	  Session::flash('message', 'You just made a cool edit to your product.');
	  return redirect('display-Member');

    }

	/*Store productQ*/

 public function storeProductQ(ProductQRequest $request) {
	 
	    $data = array();
	    $data[1] = $request->get('Name');
        $data[2] = $request->get('Category');
        $data[3]=$request->get('Price');
	    $data[4] = $request->get('ProductS');
        $data[5]= Auth::user()->id;
	    $data[6]=$request->file('photos');
	    $this->productQRepository->create($data);
	  
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
		
		
	    $data = array();
	    $data[1] = $request->get('Name');
        $data[2] = $request->get('Category');
        $data[3]=$request->get('Price');
	    $data[4] = $request->get('ProductS');
	    $data[5]=$request->file('photos');
	    $this->productQRepository->update($data,$id);
		
    	Session::flash('message', 'You edit your ProductQ.');
	    return redirect('display-Member');

    }
	
	public function deleteProductQ($id) {
		
		$this->productQRepository->delete($id);
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

