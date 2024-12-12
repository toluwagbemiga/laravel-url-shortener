<?php

namespace Tests\Feature;

use App\Models\Url;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UrlTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_short_url()
    {
        $response = $this->postJson('/api/v1/urls', [
            'original_url' => 'https://example.com/very-long-url'
        ]);

        $response->assertStatus(201)
                ->assertJsonStructure([
                    'success',
                    'data' => [
                        'id',
                        'original_url',
                        'short_code',
                        'short_url',
                        'clicks',
                        'created_at'
                    ]
                ]);

        $this->assertDatabaseHas('urls', [
            'original_url' => 'https://example.com/very-long-url'
        ]);
    }

    public function test_can_redirect_to_original_url()
    {
        $url = Url::create([
            'original_url' => 'https://example.com',
            'short_code' => 'test123'
        ]);

        $response = $this->get('/test123');
        $response->assertRedirect('https://example.com');

        $url->refresh();
        $this->assertEquals(1, $url->clicks);
    }

    public function test_can_get_url_stats()
    {
        $url = Url::create([
            'original_url' => 'https://example.com',
            'short_code' => 'test123'
        ]);

        $response = $this->getJson('/api/v1/urls/test123/stats');
        
        $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'data' => [
                        'original_url' => 'https://example.com',
                        'short_code' => 'test123',
                        'clicks' => 0
                    ]
                ]);
    }
}