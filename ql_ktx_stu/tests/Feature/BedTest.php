<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class BedTest extends TestCase
{
    public function test_cannot_create_bed_without_room_id()
    {
        // Login trước
        $this->actingAs(User::factory()->create());

        $response = $this->post('/admin/beds', [
            'bed_code' => 'A1',
            'status' => 'available'
        ]);

        $response->assertSessionHasErrors('room_id');
    }
}
