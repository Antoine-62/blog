<?php
namespace App\Providers;
 
use Illuminate\Support\ServiceProvider;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\DbUserRepository;
use App\Repositories\ProductRepositoryInterface;
use App\Repositories\DbProductRepository;
 
class BackendServiceProvider extends ServiceProvider {
	
	public function register()
	{
		$this->app->bind(UserRepositoryInterface::class,DbUserRepository::class);
		$this->app->bind(ProductRepositoryInterface::class,DbProductRepository::class);
	}
}