<?php

namespace App\Repositories;

use App\Models\Barrage;
use InfyOm\Generator\Common\BaseRepository;

class BarrageRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Barrage::class;
    }
}
