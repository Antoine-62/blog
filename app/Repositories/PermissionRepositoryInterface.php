<?php
namespace App\Repositories;
 
interface PermissionRepositoryInterface {
	
	public function all();
	
	public function find($id);
	
	public function getPermission($slug);

    public function create(array $data);

    public function update(array $data, $id);

    public function delete($id);

	
}