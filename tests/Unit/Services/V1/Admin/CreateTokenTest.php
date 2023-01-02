<?php

namespace Tests\Unit\Services\V1\Admin;

use App\Models\AdminUser;
use App\Services\V1\Admin\Token\CreateTokenService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CreateTokenTest extends TestCase
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

    /**
     * @test
     **/
    public function credentialsIsValid()
    {
        $this->assertIsString((new CreateTokenService())->create(
            'admin@admin.com',
            'demo1234',
            'testing'
        ));
    }

    /**
     * @test
     **/
    public function credentialsIsNotValid()
    {
        $this->assertFalse((new CreateTokenService())->create(
            'admin@admin.com',
            'demo12345',
            'testing'
        ));
    }
}
