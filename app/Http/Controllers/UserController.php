<?php


namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Requests\UserRequest2;
use App\Http\Requests\ImRequest;
use App\Http\Requests\ProductRequestImp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Role;
use App\Mail\ConfirmationEmail;
use Illuminate\Support\Facades\Mail;
use ZipArchive;
require_once('C:/xampp/htdocs/blog/vendor/autoload.php');
use FFMpeg;
use App\url_aliases;
use Hashids\Hashids;


class UserController extends Controller
{
	public function IndexA() {
		
        return view("user.BoardA");
    }
	
	public function Form2() {
		
        return view("user.FormR");
    }
	 public function SignI() {

        return view("auth.login");
    }
	
	public function Regist() {

        return view("auth.register");
    }
    public function DisplayUs() {
       
	    $shares = User::all();
		/*$shares = DB::table('users')->orderBy('id', 'desc')->get();*/
		/*DB::table('users')->join('role_user', 'users.id', '=', 'role_user.user_id')
		->join('roles', 'role_user.role_id', '=', 'roles.id')
		->select('users.*', 'roles.description')->distinct()->get();*/
        return view('user.Displ-users', compact('shares'));
    }
	
	/*If the admin want to add a new user*/
	public function storeUseradm(UserRequest $request) {
		
		$slug = str_slug($request->get('name'));
		$uest=DB::table('users')->where('slug',$slug)->count();
		$count=1;
		while($uest>0)
		{
			$count = $count +1;
			$count2 = '_'.$count;
			$slug = str_slug($request->get('name')).$count2;
			$uest=DB::table('users')->where('slug',$slug)->count();
		}

		$user = User::create([
            'name' =>  $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
			'slug'=>$slug,
        ]);
		 $user->roles()->attach($request['type']);
		 
	//	 Mail::to("antoine.landrieu62@gmail.com")->send(new ConfirmationEmail($user));

	  Session::flash('message', 'Congratulations, you add a new member!'.$slug.'');
	  return redirect('display-User');
    }
	
	/*For the user*/
	public function deleteUser($id) {
		
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
	
		$permission = DB::table('permission')->where('user_id',$id)->value('id');
		while(isset($permission))
		{
			DB::table('permission')->where('id',$permission)->delete();
			$permission = DB::table('permission')->where('user_id',$id)->value('id');
		}
	  $share =User::findOrFail($id);
	  $share->delete();

	  Session::flash('message', 'Congratulations, you deleted a member');
	  return redirect()->back();

    }
	
	/*For the user*/
		public function editUser($slug) {

		/*$hashids = new Hashids('',20);
		$id = $hashids->decode($idd);*/
		$idd = DB::table('users')->where('slug',$slug)->value('id');
		$share = User::find($idd);
		return view('user.EditU', compact('share'));
		
    }
	
	public function updateUser(UserRequest2 $request, $id) {
		
		$validator = Validator::make($request->all(), [
        'Name'=>'required',
        'Email'=> 'required',
      ]);
	  
	  if ($validator->fails()) {
        return redirect('UserEdit/'.$id)
		->withInput($request->all)
        ->withErrors($validator);
		}
		
		$slug = str_slug($request->get('Name'));
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
			$slug = str_slug($request->get('Name')).$count2;
			$uest=DB::table('users')->where('slug',$slug)->count();
		}
		
      $share = User::find($id);
      $share->name = $request->get('Name');
      $share->email=$request->get('Email');
	  $share->slug=$slug;
	  if(null !=$request->get('type'))
	  {
		  $products=DB::table('role_user')->where('user_id', $id)->delete();
		  $share->roles()->attach($request['type']);
	  }
      $share->save();
	  
	  Session::flash('message', 'You just made a cool edit to the profile.');
	  return redirect('Home2');

    }
	
	public function Profil($slug) {
		
		$idd = DB::table('users')->where('slug',$slug)->value('id');
		$share = User::find($idd);
        return view('user.profil', compact('share'));

    }
	
	/*Export csv file userlist*/
	public function exportUserList(Request $request){       
    $products=DB::table('users')->join('role_user', 'users.id', '=', 'role_user.user_id')->join('roles', 'role_user.role_id', '=', 'roles.id')->select('users.*', 'roles.description')->distinct()->get();//$products because copy past from an another code of the project
    $tot_record_found=0;
    if(count($products)>0){
        $tot_record_found=1;
		$memb='member';
		$admin='Admin';
         
        $CsvData=array('id, name, email, Description');          
        foreach($products as $product){
			
			$CsvData[]=$product->id.','.$product->name.','.$product->email.','.$product->description;
        }
         
        $filename="User-List".date('Y-m-d').".csv";
        $file_path=base_path().'/'.$filename;   
        $file = fopen($file_path,"w+");
        foreach ($CsvData as $exp_data){
          fputcsv($file,explode(',',$exp_data));
        }   
        fclose($file);          
 
        $headers = ['Content-Type' => 'application/csv'];
        return response()->download($file_path,$filename,$headers );
    }
	Session::flash('message', "You can't download the User list");	  
	return redirect()->back();
	}
	
	/*Import CSV file for userList*/
	public function ImportUserList(ProductRequestImp $request){

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

           $user = User::create([
               "name"=>$importData[0],
               "email"=>$importData[1],
               "password"=>Hash::make($importData[2]),
			   ]);
			 $rol=DB::table('roles')->where('name', 'Member')->value('id');
			 $user->roles()->attach($rol);

          }
		  File::delete( $filepath);

          Session::flash('message','Import Successful.');



    // Redirect to index
    return redirect()->back();
  }
  
	/********************************************Test webcam with library webcam.js***************************************/
  	public function StoreImW(ImRequest $request, $id) {	
	
		$filename = date(time()).'-'.$id.".jpg";
		
		DB::table('users')
				->where('id', $id)
				->update(['VideoName' => $filename,
				]);
				
	$mydata = $request->get('mydata');
	$binary_data = base64_decode( $mydata );
	
	$result = file_put_contents('uploads/'.$filename, $binary_data );
	
	//$result->move(public_path('/uploads'), $filename);
    
	  
	  Session::flash('message', 'Congratulations, you took a video with your webcam!');
	  return redirect('profile/{$id}');
    }
	
	
	/*To store video took by webcam*/
	
	public function StoreVidW(Request $request, $id) {
			
			$i=$request->get('VideoNb');//i = number of the video(VideoName2 or VideoName3 or ...)
			if($i==1)//We have "VideoName" and no "VideoName1" in  our database table
			{
				$i='';
			}
			//we delete the former video
			$formerName =DB::table('users')
				->where('id', $id)
				->value('VideoName'.$i);
				
			//$formerName = $formerName;
	
			
			File::delete( $formerName);
			
			$filename1 = date(time()).'-'.$i.'-'.$id.".webm";
	
			$filename = 'uploads/video/'.$filename1;			
	
		// pull the raw binary data from the POST array
		$data = substr($request->get('dataBlob'), strpos($request->get('dataBlob'), ",") + 1);

		// decode it
		$decodedData = base64_decode($data);
		// print out the raw data,
		// write the data out to the file
		$fp = fopen($filename1, 'wb');
		fwrite($fp, $decodedData);
		fclose($fp);
		
		//Then we store the video no compressing in the server and database
		//in the waiting of the process to compress video in  back-end(which can take many time)
		DB::table('users')
				->where('id', $id)
				->update(['VideoName'.$i =>$filename1,
				]);	
				
		
		//And only now we begin to compress video
		$ffmpeg = FFMpeg\FFMpeg::create(array( 
		'ffmpeg.binaries'  => 'C:/ffmpeg/bin/ffmpeg.exe',
		'ffprobe.binaries' => 'C:/ffmpeg/bin/ffprobe.exe',
		'timeout'          => 3600, // The timeout for the underlying process
		'ffmpeg.threads'   => 12,   // The number of threads that FFMpeg should use
	));
		
		//We launch the process to compress video
		//We enter the process state in text file
		$VideoName2=str_replace("webm","txt",$filename);
		$VideoName3='uploads/video/output2.txt';
		File::delete($VideoName2);
		exec("ffmpeg -i ".$filename1." -c:v libvpx-vp9 -quality realtime -speed 10 -crf 34 -b:v 0 ".$filename." 1>".$VideoName3." 2>&1");
		copy($VideoName3,$VideoName2);
		
		//When the video is compressed, we update the video name in the database
		DB::table('users')
				->where('id', $id)
				->update(['VideoName'.$i =>$filename,
				]);	
		//And we delete the video no compressed
		File::delete($filename1);
		
	}
	
	public function progressFFmpeg()
	{
		sleep(2);
		$content = file_get_contents('uploads/video/output2.txt');

            if($content){
            //get the time in the file that is already encoded
            preg_match_all("/time=(.*?) bitrate/", $content, $matches);

            $rawTime = array_pop($matches);

            //this is needed if there is more than one match
            if (is_array($rawTime)){$rawTime = array_pop($rawTime);}

            //rawTime is in 00:00:00.00 format. This converts it to seconds.
            $ar = array_reverse(explode(":", $rawTime));
            $time = floatval($ar[0]);
            if (!empty($ar[1]))
			{
				$time += intval($ar[1]) * 60;
			}
			}
			else
			{
			$time="Problem!";}

		$myJSON = json_encode($time);
		return $myJSON;
			
	}
	
	public function DeleteVideo($VideoName1) {	//Function to delete video
		
			//We delete the videofile
			$VideoName=	"uploads/video/".$VideoName1;
			
			
			//we update the name in the database
				DB::table('users')
					->where('VideoName', $VideoName)
					->update(['VideoName' =>NULL,
					]);	
				
				DB::table('users')
					->where('VideoName2', $VideoName)
					->update(['VideoName2' =>NULL,
					]);	
				
				DB::table('users')
					->where('VideoName3', $VideoName)
					->update(['VideoName3' =>NULL,
					]);	
				
				DB::table('users')
					->where('VideoName4', $VideoName)
					->update(['VideoName4' =>NULL,
					]);	
				
				DB::table('users')
					->where('VideoName5', $VideoName)
					->update(['VideoName5' =>NULL,
					]);	
					
			//And then the server will delete the compressed video
			$VideoName2=str_replace("webm","txt",$VideoName);
			
			//$lines = @file_get_contents($VideoName2);
			// What to look for
			$search = 'subtitle';
			// Read from file
			$lines = file($VideoName2);
			$conf=false;
			//while($conf == false)
			//{
				foreach($lines as $line)
				{
				// Check if the line contains the string we're looking for, and print if it does
				if(strpos($line, $search) !== false)
					$conf=true;
				}
				//if(preg_match_all("subtitle", $content, $matches))
				if($conf==true)
				{
					File::delete($VideoName2);
					File::delete($VideoName);
					Session::flash('message', 'You deleted the Video '.$VideoName1.'!');
		
				}
				else
				{
					Session::flash('message', 'Sorry, the process to compress video "'.$VideoName1.'" is no finished yet, please wait and try later');
					//exit("Problem!");
				}
			//}
  
			return redirect()->back();
	
	}
	
		/*get the filename*/
	
	public function getNameV($id, $numberVideo) {
		
		
		
		if($numberVideo==1){
			$numberVideo='';
		}
			
			$name="VideoName".$numberVideo.'';
			//We send the name by using Json
			$NameVideo =DB::table('users')->where('id',$id)->value($name);		
			$myJSON = json_encode($NameVideo);
			return $myJSON;
	}

	
	
	
}

