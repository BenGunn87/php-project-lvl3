<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class UrlControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Http::fake();
        DB::table('urls')->insert([
            'name' => 'Test1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        DB::table('urls')->insert([
            'name' => 'Test2',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        Db::table('url_checks')->insert([
            'url_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'status_code' => '404'
        ]);
        Db::table('url_checks')->insert([
            'url_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'status_code' => 'test_200'
        ]);
    }

    public function testIndex()
    {
        $response = $this->get(route('urls.index'));

        $response->assertOk();
        $response->assertSeeText('Test1');
        $response->assertSeeText('Test2');
        $response->assertSeeText('test_200');
    }

    public function testCreate()
    {
        $response = $this->get(route('urls.create'));
        $response->assertOk();
    }

    public function testShow()
    {
        $response = $this->get(route('urls.show', ['id' => 1]));
        $response->assertOk();
        $response->assertSeeText('Test1');
    }

    public function testStore()
    {
        $data = ['url' => ['name' => 'https://Test3.ru']];
        $response = $this->post(route('urls.store'), $data);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('urls.index'));

        $this->assertDatabaseHas('urls', $data['url']);
    }

    public function testUrlsCheck()
    {
        $response = $this->post(route('urls.check', ['id' => 1]));
        $response->assertRedirect(route('urls.show', ['id' => 1]));
        $this->assertDatabaseHas('url_checks', ['id' => 3]);
    }
}
