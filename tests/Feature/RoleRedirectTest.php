<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleRedirectTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_redirects_to_admin_dashboard()
    {
        $user = User::factory()->create(['role' => 'admin']);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/admin/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    public function test_college_redirects_to_college_dashboard()
    {
        $user = User::factory()->create(['role' => 'college']);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/college/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    public function test_student_redirects_to_dashboard()
    {
        $user = User::factory()->create(['role' => 'student']);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    public function test_admin_cannot_access_college_dashboard()
    {
        $user = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($user)->get('/college/dashboard');

        $response->assertStatus(403);
    }

    public function test_student_cannot_access_admin_dashboard()
    {
        $user = User::factory()->create(['role' => 'student']);

        $response = $this->actingAs($user)->get('/admin/dashboard');

        $response->assertStatus(403);
    }
}
