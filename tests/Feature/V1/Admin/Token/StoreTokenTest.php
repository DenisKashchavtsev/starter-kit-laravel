<?php

namespace Tests\Feature\V1\Admin\Token;

use App\Models\AdminUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class StoreTokenTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpUser();
    }

    /**
     * @return void
     */
    private function setUpUser(): void
    {
        if(!AdminUser::whereEmail('admin@admin.com')->exists()) {
            AdminUser::factory()->create([
                'email' => 'admin@admin.com',
                'password' => Hash::make('demo1234'),
            ]);
        }
    }

    /** @test */
    public function requiredFields()
    {
        $response = $this->postJson('/api/v1/admin/tokens');

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure([
                'errors' => [
                    'email',
                    'password',
                    'device_name',
                ],
            ]);
    }

    /** @test */
    public function storeCredentialsIsValid()
    {
        $response = $this->postJson('/api/v1/admin/tokens', [
            'email' => 'admin@admin.com',
            'password' => 'demo1234',
            'device_name' => 'testing',
        ]);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure([
                'token',
            ]);
    }

    /** @test */
    public function storeCredentialsIsNotValid()
    {
        $response = $this->postJson('/api/v1/admin/tokens', [
            'email' => 'admin@admin.com',
            'password' => Hash::make('demo'),
            'device_name' => 'testing',
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
