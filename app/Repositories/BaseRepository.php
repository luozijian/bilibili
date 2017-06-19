<?php

namespace App\Repositories;

abstract class BaseRepository extends \InfyOm\Generator\Common\BaseRepository
{
    public function withOnly($relation, Array $columns)
    {
        return $this->model->with([$relation => function ($query) use ($columns){
            $query->select($columns);
        }]);
    }
}
