<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->make('view')->composer('navigation.header', 'App\Http\ViewComposers\Navigation');
		$this->app->make('view')->composer('member.add', 'App\Http\ViewComposers\LocationsSelect');
		$this->app->make('view')->composer('member.add', 'App\Http\ViewComposers\DepartmentsSelect');
		$this->app->make('view')->composer('member.request-holiday', 'App\Http\ViewComposers\RequestDatePicker');
		$this->app->make('view')->composer('member.holiday-history', 'App\Http\ViewComposers\HolidayHistory');
		$this->app->make('view')->composer('beta', 'App\Http\ViewComposers\LocationsSelect');
		$this->app->make('view')->composer('beta', 'App\Http\ViewComposers\DepartmentsSelect');

//		$this->app->make('view')->composer('member.holiday-history', function($view) {
//			//$data contains category_id
//			$viewdata= $view->getData();
//
//			//Retrive based on category_id
//			$posts_related = Blog::posts_related($viewdata['category_id'],5);
//
//			//pass related post to view
//			$view->with('posts_related', $posts_related);
//		});
	}

}
