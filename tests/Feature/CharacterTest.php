<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CharacterTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function getService()
    {
        return $this->app->make("App\Services\Interfaces\ICharacterService");
    }

    public function testCreate()
    {
        $request = new Request();
        $request->request->add(['name' => 'Character 01']);
        $request->request->add(['role' => 'student']);
        $request->request->add(['school' => 'school 01']);
        $request->request->add(['house' => '5a05e2b252f721a3cf2ea33f']);
        $request->request->add(['patronus' => 'stag']);

        $characterService = $this->getService();
        //$characterService->create($request);

        $response = Http::post('http://127.0.0.1/api/characters', [
            'name' => 'Character 01',
            'role' => 'student',
            'school' => 'school 01',
            'house' => '5a05e2b252f721a3cf2ea33f',
            'patronus' => 'stag',
        ]);

        $requestDbCount = $characterService->getAll();
        $this->assertCount(1, $requestDbCount);

    }

}
