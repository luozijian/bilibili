<?php

use Faker\Factory as Faker;
use App\Models\Barrage;
use App\Repositories\BarrageRepository;

trait MakeBarrageTrait
{
    /**
     * Create fake instance of Barrage and save it in database
     *
     * @param array $barrageFields
     * @return Barrage
     */
    public function makeBarrage($barrageFields = [])
    {
        /** @var BarrageRepository $barrageRepo */
        $barrageRepo = App::make(BarrageRepository::class);
        $theme = $this->fakeBarrageData($barrageFields);
        return $barrageRepo->create($theme);
    }

    /**
     * Get fake instance of Barrage
     *
     * @param array $barrageFields
     * @return Barrage
     */
    public function fakeBarrage($barrageFields = [])
    {
        return new Barrage($this->fakeBarrageData($barrageFields));
    }

    /**
     * Get fake data of Barrage
     *
     * @param array $postFields
     * @return array
     */
    public function fakeBarrageData($barrageFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $barrageFields);
    }
}
