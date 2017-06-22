<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BarrageApiTest extends TestCase
{
    use MakeBarrageTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateBarrage()
    {
        $barrage = $this->fakeBarrageData();
        $this->json('POST', '/api/v1/barrages', $barrage);

        $this->assertApiResponse($barrage);
    }

    /**
     * @test
     */
    public function testReadBarrage()
    {
        $barrage = $this->makeBarrage();
        $this->json('GET', '/api/v1/barrages/'.$barrage->id);

        $this->assertApiResponse($barrage->toArray());
    }

    /**
     * @test
     */
    public function testUpdateBarrage()
    {
        $barrage = $this->makeBarrage();
        $editedBarrage = $this->fakeBarrageData();

        $this->json('PUT', '/api/v1/barrages/'.$barrage->id, $editedBarrage);

        $this->assertApiResponse($editedBarrage);
    }

    /**
     * @test
     */
    public function testDeleteBarrage()
    {
        $barrage = $this->makeBarrage();
        $this->json('DELETE', '/api/v1/barrages/'.$barrage->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/barrages/'.$barrage->id);

        $this->assertResponseStatus(404);
    }
}
