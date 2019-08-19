<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\faqtRequest;

class FaqController extends Controller
{
     public function getFaqForm() {

        return view("faq.faq-form-add");
    }
	
	public function DisplayFaq() {
		
		$shares = DB::table('faq')->orderBy('id', 'desc')->get();
        return view("faq.faq", compact('shares'));
    }
	
	public function storeFAQ(faqtRequest $request) {
		
		if($request->get('Status') == null){
		$status = 0;
		} else {
		$status = $request->get('Status');
		}
		
		$count = DB::table('faq')->where('Question',$request->get('Question'))->count();
		if($count == 0)
		{
			$count2='';
		}
		else
		{
			$count = $count+1;
			$count2 = '_'.$count;
		}
		$slug = str_slug($request->get('Question')).$count2;
		$uest=DB::table('faq')->where('slug',$slug)->count();
		while($uest>0)
		{
			$count = $count +1;
			$count2 = '_'.$count;
			$slug = str_slug($request->get('Question')).$count2;
			$uest=DB::table('faq')->where('slug',$slug)->count();
		}
		DB::table('faq')->insertGetId(
			['Question' => $request->get('Question'),
			 'Answer' => $request->get('Answer'),
			 'Status'=> $status,
			 'slug' => $slug,
			 ]
		);
		
	  
	  Session::flash('message', 'Congratulations, you create a new question!');
	  return redirect('faq');
    }
	
	public function editFaq($slug) {
		
		$share = DB::table('faq')->where('slug',$slug)->first();
        return view("faq.faq-form-edit", compact('share'));
    }
	
	public function updateFaq(faqtRequest $request, $id) {
		
		if($request->get('Status') == null){
		$status = 0;
		} else {
		$status = $request->get('Status');
		}
		
		$count = DB::table('faq')->where('Question',$request->get('Question'))->count();
		if($count == 0)
		{
			$count2='';
		}
		else
		{
			$count = $count+1;
			$count2 = '_'.$count;
		}
		$slug = str_slug($request->get('Question')).$count2;
		$uest=DB::table('faq')->where('slug',$slug)->count();
		while($uest>0)
		{
			$count = $count +1;
			$count2 = '_'.$count;
			$slug = str_slug($request->get('Question')).$count2;
			$uest=DB::table('faq')->where('slug',$slug)->count();
		}
		
			DB::table('faq')
				->where('id', $id)
				->update(['Question' => $request->get('Question'),
				'Answer' => $request->get('Answer'),
				'Status'=> $status,
				 'slug' => $slug,
				]);
				
			
		Session::flash('message', 'You edited the question n°'.$id.'!');
		return redirect('faq');
		 

    }
	
	public function deleteFaq($id) {
	
			$faqqq = DB::table('faq')->where('id', $id)->delete();


	  Session::flash('message', 'You deleted the question n°'.$id.'!');
	  
	  return redirect('faq');
    }
	
	
}
