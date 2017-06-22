<?php

use App\Models\Barrage;
use App\Repositories\BarrageRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BarrageRepositoryTest extends TestCase
{
    use MakeBarrageTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var BarrageRepository
     */
    protected $barrageRepo;

    public function setUp()
    {
        parent::setUp();
        $this->barrageRepo = App::make(BarrageRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateBarrage()
    {
        $barrage = $this->fakeBarrageData();
        $createdBarrage = $this->barrageRepo->create($barrage);
        $createdBarrage = $createdBarrage->toArray();
        $this->assertArrayHasKey('id', $createdBarrage);
        $this->assertNotNull($createdBarrage['id'], 'Created Barrage must have id specified');
        $this->assertNotNull(Barrage::find($createdBarrage['id']), 'Barrage with given id must be in DB');
        $this->assertModelData($barrage, $createdBarrage);
    }

    /**
     * @test read
     */
    public function testReadBarrage()
    {
        $barrage = $this->makeBarrage();
        $dbBarrage = $this->barrageRepo->find($barrage->id);
        $dbBarrage = $dbBarrage->toArray();
        $this->assertModelData($barrage->toArray(), $dbBarrage);
    }

    /**
     * @test update
     */
    public function testUpdateBarrage()
    {
        $barrage = $this->makeBarrage();
        $fakeBarrage = $this->fakeBarrageData();
        $updatedBarrage = $this->barrageRepo->update($fakeBarrage, $barrage->id);
        $this->assertModelData($fakeBarrage, $updatedBarrage->toArray());
        $dbBarrage = $this->barrageRepo->find($barrage->id);
        $this->assertModelData($fakeBarrage, $dbBarrage->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteBarrage()
    {
        $barrage = $this->makeBarrage();
        $resp = $this->barrageRepo->delete($barrage->id);
        $this->assertTrue($resp);
        $this->assertNull(Barrage::find($barrage->id), 'Barrage should not exist in DB');
    }
}
