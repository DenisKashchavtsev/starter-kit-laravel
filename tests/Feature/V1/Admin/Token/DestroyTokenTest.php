<?php

namespace Tests\Feature\V1\Admin\Token;

use App\Models\AdminUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Throwable;

class DestroyTokenTest extends TestCase
{
    use RefreshDatabase;

    private mixed $token;

    /**
     * @throws Throwable
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpUser();
    }

    /**
     * @return void
     * @throws Throwable
     */
    private function setUpUser(): void
    {
        if(!AdminUser::whereEmail('admin@admin.com')->exists()) {
            AdminUser::factory()->create([
                'email' => 'admin@admin.com',
                'password' => Hash::make('demo1234'),
            ]);
        }

        $response = $this->postJson('/api/v1/admin/tokens', [
            'email' => 'admin@admin.com',
            'password' => 'demo1234',
            'device_name' => 'testing',
        ]);

        $this->token = $response->decodeResponseJson()['token'];

    }

    /** @test */
    public function requiredFields()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $this->token,
            'Accept' => 'application/json'
        ])->deleteJson('/api/v1/admin/tokens');

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure([
                'errors' => [
                    'device_name',
                ],
            ]);
    }

    /** @test */
    public function destroy()
    {
        $admin = AdminUser::whereEmail('admin@admin.com')->first();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $this->token,
            'Accept' => 'application/json'
        ])->deleteJson('/api/v1/admin/tokens', [
            'device_name' => 'testing',
        ]);

        $this->assertFalse(
            $admin->tokens()->where('name', 'testing')->exists()
        );

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }
}
