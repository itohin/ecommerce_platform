<?php

namespace Tests\Feature\Addresses;

use App\Models\Address;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddressStoreTest extends TestCase
{

    public function test_it_fails_if_authenticated()
    {
        $this->json('POST', 'api/addresses')
            ->assertStatus(401);
    }

    public function test_it_requires_a_name()
    {
        $user = factory(User::class)->create();

        $this->jsonAs($user,'POST', 'api/addresses')
            ->assertJsonValidationErrors(['name']);
    }

    public function test_it_requires_an_addess_1()
    {
        $user = factory(User::class)->create();

        $this->jsonAs($user,'POST', 'api/addresses')
            ->assertJsonValidationErrors(['address_1']);
    }

    public function test_it_requires_a_city()
    {
        $user = factory(User::class)->create();

        $this->jsonAs($user,'POST', 'api/addresses')
            ->assertJsonValidationErrors(['city']);
    }

    public function test_it_requires_a_postal_code()
    {
        $user = factory(User::class)->create();

        $this->jsonAs($user,'POST', 'api/addresses')
            ->assertJsonValidationErrors(['postal_code']);
    }

    public function test_it_requires_a_country_exists()
    {
        $user = factory(User::class)->create();

        $this->jsonAs($user,'POST', 'api/addresses', [
            'country_id' => 9999999
        ])
            ->assertJsonValidationErrors(['country_id']);
    }

    public function test_it_stores_an_address()
    {
        $user = factory(User::class)->create();

        $this->jsonAs($user,'POST', 'api/addresses',
            $address = factory(Address::class)->raw()
        );

        $this->assertDatabaseHas('addresses', array_merge($address, [
            'user_id' => $user->id
        ]));
    }

    public function test_it_returns_address_when_created()
    {
        $user = factory(User::class)->create();

        $response = $this->jsonAs($user,'POST', 'api/addresses',
            $address = factory(Address::class)->raw()
        );

        $response->assertJsonFragment([
            'id' => json_decode($response->getContent())->data->id
        ]);
    }
}
