<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Account;
use App\Models\Character;
use Tests\TestCase;

class AccountManagementTest extends TestCase
{
    protected $admin;
    protected $account;
    protected $character;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');
        $this->account = Account::factory()->create(['user_id' => $this->admin->id]);
        $this->character = Character::factory()->create(['account_id' => $this->account->id]);
    }

    public function test_admin_can_fetch_accounts()
    {
        $response = $this->actingAs($this->admin)
            ->getJson('/api/admin/accounts');

        $response->assertStatus(200);
        $response->assertJsonStructure(['data']);
    }

    public function test_admin_can_ban_account()
    {
        $response = $this->actingAs($this->admin)
            ->postJson("/api/admin/accounts/{$this->account->id}/ban", [
                'reason' => 'Cheating detected',
                'until' => now()->addDays(7),
            ]);

        $response->assertStatus(200);
        $this->assertTrue($this->account->refresh()->is_banned);
    }

    public function test_admin_can_unban_account()
    {
        $this->account->update(['is_banned' => true]);

        $response = $this->actingAs($this->admin)
            ->postJson("/api/admin/accounts/{$this->account->id}/unban");

        $response->assertStatus(200);
        $this->assertFalse($this->account->refresh()->is_banned);
    }

    public function test_non_admin_cannot_ban_account()
    {
        $user = User::factory()->create();
        $user->assignRole('player');

        $response = $this->actingAs($user)
            ->postJson("/api/admin/accounts/{$this->account->id}/ban", [
                'reason' => 'Test',
            ]);

        $response->assertStatus(403);
    }
}
