<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\faqtRequest;
use App\Repositories\FaqRepositoryInterface;
use App\Http\Resources\faqsResource;


class FaqController extends Controller
{
	 private $faqRepository;
	 public function __construct(FaqRepositoryInterface $faqRepository)
    {
        $this->faqRepository = $faqRepository;
    }
	
	
     public function getFaqForm() {

        return view("faq.faq-form-add");
    }
	
	public function DisplayFaq() {
		
		$shares = $this->faqRepository->all();
        return view("faq.faq", compact('shares'));
    }
	
	public function storeFAQ(faqtRequest $request) {
		
		$data = array();
	  $data[1]= $request->get('Question');
	  $data[2]= $request->get('Answer');
      $data[3]= $request->get('Status');
	  $this->faqRepository->create($data);		
	  
	  Session::flash('message', 'Congratulations, you create a new question!');
	  return redirect('faq');
    }
	
	public function show()
	{
		 $posts = $this->faqRepository->all();
		 return new faqsResource($posts);
	}
	
	public function editFaq($slug) {
		
		$share = $this->faqRepository->findEdit($slug);
        return view("faq.faq-form-edit", compact('share'));
    }
	
	public function updateFaq(faqtRequest $request, $id) {
		
		$data = array();
	    $data[1]= $request->get('Question');
	    $data[2]= $request->get('Answer');
        $data[3]= $request->get('Status');
	    $this->faqRepository->update($data,$id);	
			
		Session::flash('message', 'You edited the question n°'.$id.'!');
		return redirect('faq');
		 

    }
	
	public function deleteFaq($id) {
	
	  $this->faqRepository->delete($id);
	  
	  Session::flash('message', 'You deleted the question n°'.$id.'!');
	  
	  return redirect('faq');
    }
	
	
}
