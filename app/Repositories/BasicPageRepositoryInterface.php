<?php
namespace App\Repositories;
 
interface BasicPageRepositoryInterface {
	
	public function home();
	
	public function about();
	
	public function contact();

   public function create(array $data);

    public function update(array $data, $id);

    public function delete($id);

	
}