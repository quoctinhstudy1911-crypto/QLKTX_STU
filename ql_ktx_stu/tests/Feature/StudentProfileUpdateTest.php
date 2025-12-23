<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\PersonalProfile;

class StudentProfileUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_hometown_is_saved_when_profile_updated()
    {
        $user = User::factory()->create();

        $profile = PersonalProfile::create([
            'user_id' => $user->id,
            'full_name' => 'Test Student',
            'student_code' => 'SV100',
            'phone' => '0123456789',
            'address' => 'Old address',
            'hometown' => 'Old town'
        ]);

        $this->actingAs($user)
             ->post(route('student.profile.update'), [
                 'phone' => '0987654321',
                 'address' => 'New address',
                 'hometown' => 'NewTown'
             ])
             ->assertRedirect()
             ->assertSessionHas('success');

        $this->assertDatabaseHas('personal_profiles', [
            'user_id' => $user->id,
            'hometown' => 'NewTown'
        ]);
    }
}
