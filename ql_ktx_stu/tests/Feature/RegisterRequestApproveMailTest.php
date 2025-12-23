<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\RegisterRequest;
use App\Models\Room;
use App\Models\Bed;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\StudentAccountCreated;

class RegisterRequestApproveMailTest extends TestCase
{
    use RefreshDatabase;

    public function test_approving_request_sends_account_email()
    {
        Mail::fake();

        $admin = User::factory()->create(['role' => 'admin']);

        $room = Room::create(['room_number' => '101', 'gender' => 'male', 'capacity' => 2]);
        $bed = Bed::create(['room_id' => $room->id, 'bed_code' => 'B1', 'status' => 'available']);

        $req = RegisterRequest::create([
            'full_name' => 'Test Student',
            'student_code' => 'SV12345',
            'gender' => 'male',
            'dob' => '2000-01-01',
            'phone' => '0123456789',
            'address' => 'Somewhere',
            'status' => 'pending'
        ]);

           $response = $this->actingAs($admin)
               ->post(route('admin.register.approve', $req->id), ['bed_id' => $bed->id]);

           $response->assertRedirect();
           $response->assertSessionHasNoErrors();

        $expectedEmail = $req->student_code . '@student.stu.edu.vn';

        // Ensure a user was created
        $this->assertDatabaseHas('users', ['email' => $expectedEmail]);

        // Ensure register request marked approved
        $this->assertDatabaseHas('register_requests', ['id' => $req->id, 'status' => 'approved']);

        // Ensure bed was marked occupied
        $this->assertDatabaseHas('beds', ['id' => $bed->id, 'status' => 'occupied']);

        // Finally assert mail was sent
        Mail::assertSent(StudentAccountCreated::class, function ($mail) use ($expectedEmail) {
            return $mail->hasTo($expectedEmail);
        });
    }
}
