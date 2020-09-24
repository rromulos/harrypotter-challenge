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

    public function testCreate()
    {
        $responseData = Http::post(env('URL_LOCAL_API'), [
            'name' => 'Character 01',
            'role' => 'student',
            'school' => 'school 01',
            'house' => '5a05e2b252f721a3cf2ea33f',
            'patronus' => 'stag',
        ]);
        $response = json_decode($responseData);
        $responseGet = json_decode(Http::get(env('URL_LOCAL_API').$response->id));
        $this->assertNotEmpty($responseGet->id);
        $this->assertEquals('Character 01', $responseGet->name);
    }

    public function testTryToCreateWithInvalidHouse()
    {
        $response = json_decode(Http::post(env('URL_LOCAL_API'), [
            'name' => 'Character 02',
            'role' => 'student',
            'school' => 'school 02',
            'house' => 'aa5a05e2b252f721a3cf2ea33f',
            'patronus' => 'stag',
        ]));
        $this->assertEquals('The informed house is invalid', $response);
    }

    public function testDelete()
    {
        $responsePost = json_decode(Http::post(env('URL_LOCAL_API'), [
            'name' => 'Character 03',
            'role' => 'student',
            'school' => 'school 03',
            'house' => '5a05e2b252f721a3cf2ea33f',
            'patronus' => 'stag',
        ]));
        $this->assertNotEmpty($responsePost->id);
        $responseGet = json_decode(Http::get(env('URL_LOCAL_API').$responsePost->id));
        $this->assertEquals('Character 03', $responseGet->name);
        Http::delete(env('URL_LOCAL_API').$responsePost->id);
        $responseGetAfterPost = json_decode(Http::get(env('URL_LOCAL_API').$responsePost->id));
        $this->assertEquals('Character not found', $responseGetAfterPost->message);
    }

    public function testUpdate()
    {
        $responsePost = json_decode(Http::post(env('URL_LOCAL_API'), [
            'name' => 'Character 04',
            'role' => 'student',
            'school' => 'school 04',
            'house' => '5a05e2b252f721a3cf2ea33f',
            'patronus' => 'stag',
        ]));

        Http::put(env('URL_LOCAL_API').$responsePost->id, [
            'name' => 'Character 04 updated',
            'role' => 'student',
            'school' => 'school 04 updated',
            'house' => '5a05e2b252f721a3cf2ea33f',
            'patronus' => 'stag',
        ]);

        $responseGetAfterUpdate = json_decode(Http::get(env('URL_LOCAL_API').$responsePost->id));
        $this->assertEquals('Character 04 updated', $responseGetAfterUpdate->name);
    }

    public function testGetByValidHouse()
    {
        $responsePost = json_decode(Http::post(env('URL_LOCAL_API'), [
            'name' => 'Character 05',
            'role' => 'student',
            'school' => 'school 05',
            'house' => '5a05e2b252f721a3cf2ea33f',
            'patronus' => 'stag',
        ]));

        $responseGet = json_decode(Http::get(env('URL_LOCAL_API'), [
            'house' => '5a05e2b252f721a3cf2ea33f',
        ]));

        $this->assertIsArray($responseGet);
        $this->assertNotEmpty($responseGet);
    }

    public function testGetByInValidHouse()
    {
        $responsePost = json_decode(Http::post(env('URL_LOCAL_API'), [
            'name' => 'Character 06',
            'role' => 'student',
            'school' => 'school 06',
            'house' => '5a05e2b252f721a3cf2ea33f',
            'patronus' => 'stag',
        ]));

        $responseGet = json_decode(Http::get(env('URL_LOCAL_API'), [
            'house' => '75a05e2b252f721a3cf2ea33f',
        ]));

        $this->assertIsArray($responseGet);
        $this->assertEmpty($responseGet);
    }

    public function testGetAll()
    {
        $responsePost = json_decode(Http::post(env('URL_LOCAL_API'), [
            'name' => 'Character 07',
            'role' => 'student',
            'school' => 'school 07',
            'house' => '5a05e2b252f721a3cf2ea33f',
            'patronus' => 'stag',
        ]));

        $responseGet = json_decode(Http::get(env('URL_LOCAL_API')));

        $this->assertIsArray($responseGet);
        $this->assertNotEmpty($responseGet);
    }

    public function testGetHouseFromPotterApi()
    {
        $housePath = 'houses/';
        $house = '5a05e2b252f721a3cf2ea33f';
        $response = Http::get(env('POTTERAPI_BASE_URL').
            $housePath.
            $house.
            '?key='.
            env('POTTERAPI_KEY'));
        $responseDecode = json_decode($response);
        $this->assertNotEmpty($responseDecode);
        $this->assertIsArray($responseDecode);
        $this->assertEquals($response->status(), '200');
    }
}
