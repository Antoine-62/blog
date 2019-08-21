<?php
namespace App\Repositories;
 
interface UserRepositoryInterface {
	
	public function all();
	
	public function find($id);
	
	public function deleteVideo($id);

    public function create(array $data);

    public function update(array $data, $id);

    public function delete($id);

	
}