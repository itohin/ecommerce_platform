<?php

namespace Tests\Feature\Addresses;

use App\Models\Address;
use App\Models\Country;
use App\Models\ShippingMethod;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddressShippingTest extends TestCase
{
    public function test_it_fails_if_not_authenticated()
    {
        $this->json('GET', "api/addresses/1/shipping")
            ->assertStatus(401);
    }

    public function test_it_fails_if_address_cant_be_found()
    {
        $user = factory(User::class)->create();

        $this->jsonAs($user, 'GET', "api/addresses/1/shipping")
            ->assertStatus(404);
    }

    public function test_it_fails_if_address_does_not_belongs_to_user()
    {
        $user = factory(User::class)->create();
        $address = factory(Address::class)->create([
            'user_id' => factory(User::class)
        ]);

        $this->jsonAs($user, 'GET', "api/addresses/{$address->id}/shipping")
            ->assertStatus(403);
    }

    public function test_it_shows_shipping_methods_for_given_address()
    {
        $user = factory(User::class)->create();
        $address = factory(Address::class)->create([
            'user_id' => $user->id,
            'country_id' => ($country = factory(Country::class)->create())->id
        ]);

        $country->shippingMethods()->save(
            $shipping = factory(ShippingMethod::class)->create()
        );

        $this->jsonAs($user, 'GET', "api/addresses/{$address->id}/shipping")
            ->assertJsonFragment([
                'id' => $shipping->id
            ]);
    }
}
