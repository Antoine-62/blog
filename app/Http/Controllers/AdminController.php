<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRequest;
use App\Http\Requests\AdminRequest2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\basic_page;
use App\banner_image;
use Illuminate\Support\Facades\Storage;
use Session;
use Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{
	
	private $globalV=5;
	
	
	//to get the form of banner Image
    public function FormBanIm() {
		$shares = DB::table('banner_image')->orderBy('id', 'desc')->get();
        return view("admin.FormBanIm", compact('shares'));
    }
	
	//HomePage
	public function FormBasicP($Home) {
        return view("admin.FormBasP", compact('Home'));
    }
	
	//About Page
	public function FormBasicP2() {
		$About="About"; 
        return view("admin.FormBasP2", compact('About'));
    }
	
	//Contact us page
	public function FormBasicP3() {
		$Contact="Contact"; 
        return view("admin.FormBasP3", compact('Contact'));
    }
	
	public function home() {
		session(['key' => '13']);
        $shares = DB::table('basic_page')->where('NamePage','Home')->get();
        return view('admin.home2', compact('shares'));
    }
	
	public function GlobalPage() {
		
        $value = config('Global-Variable.test');
		//$value=session('key');
	//	$value= $this->globalV;
        return view('admin.GlobVarTest', compact('value'));
    }
	
	public function UpdateGlobalV(Request $request) {
		
		Config::set('Global-Variable.test', $request->get('GlobVar'));
	    $value = config('Global-Variable.test');
		//Session::set('GlobV', $request->get('GlobVar'));
	//	session(['key' => $request->get('GlobVar')]);
	  //  $GLOBALS['globalV']= $request->get('GlobVar');
		//$value= $this->globalV;
        Session::flash('message', "You edited the variable to ".$value);
        return  redirect('getGlobalVariable');
    }
	
	public function ContactUs() {

        $shares = DB::table('basic_page')->where('NamePage','Contact')->get();
        return view('admin.Contact-us', compact('shares'));
		
    }
	
	public function AboutUs() {

        $shares = DB::table('basic_page')->where('NamePage','About')->get();
        return view('admin.About-us', compact('shares'));
    }
	
	public function storeBanIm(AdminRequest2 $request) {
		
		$na=$request->get('Name').'.'.$request->fileBI->getClientOriginalExtension();
	     $request->fileBI->move(public_path('/uploads'), $na);
		
		DB::table('banner_image')->insertGetId(
			['Name' => $na]
		);
	  
	  Session::flash('message', 'Congratulations, you added a Banner Image!');
	  return redirect()->back();
    }
	
	public function storeBasP(AdminRequest $request, $Home) {
		
		$slug = str_slug($Home.' '.$request->get('NamePage').' '.$request->get('Title'));
		$uest=DB::table('basic_page')->where('slug',$slug)->count();
		$count=1;
		while($uest>0)
		{
			$count = $count +1;
			$count2 = '_'.$count;
			$slug = str_slug($Home.' '.$request->get('Title')).$count2;
			$uest=DB::table('basic_page')->where('slug',$slug)->count();
		}

		DB::table('basic_page')->insertGetId(
			['Title' => $request->get('Title'),
			 'Content' => $request->get('Content'),
			 'NamePage'=>$Home,
			 'slug'=>$slug
			 ]);
	  
	  Session::flash('message', 'Congratulations, you added a basic Page!');
	  $page = $Home;
	  if($page == 'About')
      return  redirect('About-us');
  
	  if($page == 'Home')
      return  redirect('Home2');
  
  if($page == 'Contact')
      return  redirect('Contact-us');
    }
	
	public function deleteBasicCont($id) {
		
	  $content = DB::table('basic_page')->where('id', $id)->delete();
	  Session::flash('message', "You deleted a basic content");
      return  redirect()->back();
    }
	
		/*Basic Page Edit*/
	public function editBasicPage($slug) {
		$share = DB::table('basic_page')->where('slug',$slug)->first();
		return view('admin.EditBP', compact('share'));
    }
	
			/*Basic Page Edit*/
	public function updateBasicPage(AdminRequest $request, $id) {
		
		$home=DB::table('basic_page')->where('id',$id)->value('NamePage');
		$slug = str_slug($home.' '.$request->get('Title'));
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
			$slug = str_slug($home.' '.$request->get('Title')).$count2;
			$uest=DB::table('basic_page')->where('slug',$slug)->count();
		}
		
		DB::table('basic_page')
				->where('id', $id)
				->update([
				'Title' => $request->get('Title'),
				'Content' => $request->get('Content'),
				'slug' => $slug
				]);
				
	
	  Session::flash('message', "You edit your content");
	  $page = DB::table('basic_page')->where('id', $id)->value('NamePage');
	  if($page == 'About')
      return  redirect('About-us');
  
	  if($page == 'Home')
      return  redirect('Home2');
  
  if($page == 'Contact')
      return  redirect('Contact-us');
    }
	
	
	public function deleteBannerIm($id) {
		
	  $user_profile = DB::table('banner_image')->where('id', $id)->value('Name');
	  File::delete("uploads/".$user_profile);
	  $user_profile = DB::table('banner_image')->where('id', $id)->delete();
	  Session::flash('message', "You deleted a basic content");
      return  redirect()->back();
    }
	
	
}
