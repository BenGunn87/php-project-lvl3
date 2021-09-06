<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UrlControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
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
    }

    public function testIndex()
    {
        $response = $this->get(route('urls.index'));

        $response->assertOk();
        $response->assertSeeText('Test1');
        $response->assertSeeText('Test2');
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
}
