<?php

namespace App\Providers;

use App\Criteria\MyClassCriteria;
use App\Criteria\WhereCriteria;
use App\Models\Category;
use App\Models\Community;
use App\Models\User;
use App\Repositories\ResourceRepository;
use App\Repositories\StudentClassRepository;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * 在容器內註冊所有綁定。
     *
     * @return void
     */
    public function boot()
    {
       
    }

    /**
     * 註冊服務提供者。
     *
     * @return void
     */
    public function register()
    {
        //
    }
}