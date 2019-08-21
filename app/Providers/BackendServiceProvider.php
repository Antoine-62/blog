<?php
namespace App\Providers;
 
use Illuminate\Support\ServiceProvider;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\DbUserRepository;
use App\Repositories\ProductRepositoryInterface;
use App\Repositories\DbProductRepository;
use App\Repositories\ProductQRepositoryInterface;
use App\Repositories\DbProductQRepository;
use App\Repositories\FaqRepositoryInterface;
use App\Repositories\DbFaqRepository;
use App\Repositories\BasicPageRepositoryInterface;
use App\Repositories\DbBasicPageRepository;
use App\Repositories\PermissionRepositoryInterface;
use App\Repositories\DbPermissionRepository;
 
class BackendServiceProvider extends ServiceProvider {
	
	public function register()
	{
		$this->app->bind(UserRepositoryInterface::class,DbUserRepository::class);
		$this->app->bind(ProductRepositoryInterface::class,DbProductRepository::class);
		$this->app->bind(ProductQRepositoryInterface::class,DbProductQRepository::class);
		$this->app->bind(FaqRepositoryInterface::class,DbFaqRepository::class);
		$this->app->bind(BasicPageRepositoryInterface::class,DbBasicPageRepository::class);
		$this->app->bind(PermissionRepositoryInterface::class,DbPermissionRepository::class);
	}
}