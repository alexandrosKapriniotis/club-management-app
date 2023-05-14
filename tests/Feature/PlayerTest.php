<?php

use App\Models\Club;
use App\Models\Player;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class PlayerTest extends TestCase
{
    use DatabaseMigrations;

    protected User $user;
    protected User $clubAdmin;
    protected Team $team;
    protected Club $club;
    protected Player $player;

    public function setUp(): void
    {
        parent::setUp();

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        /* Create admin and user roles */
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);
        $this->club = Club::factory()->create(['logo' => '']);
        $this->team      = Team::factory()->create(['club_id' => $this->club->id]);
        $this->clubAdmin = User::factory()->admin()->create(['club_id' => $this->club->id]);
        $this->user      = User::factory()->user()->create(['club_id' => $this->club->id]);
        $this->player    = Player::factory()->create(['user_id' => $this->user->id, 'team_id' => $this->team->id]);
    }

    /** @test */
    public function an_admin_user_can_see_the_player_view_screen()
    {
        $this->actingAs($this->clubAdmin);
        $response = $this->get(route('players.show', $this->player));

        $response->assertStatus(200);
    }

    /** @test */
    public function an_admin_user_can_edit_a_player()
    {
        $this->actingAs($this->clubAdmin);
        $response = $this->get(route('players.edit', $this->player));
        $response->assertStatus(200);

        $postResponse = $this->followingRedirects()->put(route('players.update', $this->player), [
            'name' => 'edited',
            'position' => 'CF',
            'user' => [
                'email' => 'new_email@player.com',
            ],
            'team_id' => $this->team->id
        ]);
        $postResponse->assertStatus(200);

        $postResponse->assertSee('edited');
    }

    /** @test */
    public function an_admin_user_can_create_a_player()
    {
        $this->actingAs($this->clubAdmin);
        $response = $this->get(route('players.create', $this->player));
        $response->assertStatus(200);

        $postResponse = $this->followingRedirects()->post(route('players.store', $this->player), [
            'name' => 'new player',
            'position' => 'CF',
            'user' => [
                'email' => 'new_email@player.com',
                'password' => 'password',
                'password_confirmation' => 'password'
            ],
            'team_id' => $this->team->id
        ]);
        $postResponse->assertStatus(200);
        $postResponse->assertSee('new player');
    }

    /** @test */
    public function an_admin_user_can_delete_a_player()
    {
        $this->actingAs($this->clubAdmin);
        $newPlayer = Player::factory()->create(['user_id' => $this->user->id, 'team_id' => $this->team->id]);
        $response = $this->followingRedirects()->delete(route('players.destroy', $newPlayer));
        $response->assertStatus(200);
    }

    /** @test */
    public function a_user_can_see_the_player_view_screen()
    {
        $this->actingAs($this->user);
        $response = $this->get(route('players.show', $this->player));

        $response->assertStatus(200);
    }

    /** @test */
    public function a_user_cannot_edit_a_player()
    {
        $this->actingAs($this->user);
        $response = $this->get(route('players.edit', $this->player));

        $response->assertForbidden();
        $response->assertDontSee($this->player->name);
    }

    /** @test */
    public function an_user_cannot_create_a_player()
    {
        $this->actingAs($this->user);
        $response = $this->get(route('players.create', $this->team));
        $response->assertForbidden();

        $postResponse = $this->followingRedirects()->post(route('players.store', $this->player), [
            'name' => 'new player',
            'position' => 'CF',
            'user' => [
                'email' => 'new_email@player.com',
                'password' => 'password',
                'password_confirmation' => 'password'
            ],
            'team_id' => $this->team->id
        ]);
        $postResponse->assertForbidden();
    }

    /** @test */
    public function an_user_cannot_delete_a_player()
    {
        $this->actingAs($this->user);
        $newPlayer = Player::factory()->create(['user_id' => $this->user->id, 'team_id' => $this->team->id]);
        $response = $this->followingRedirects()->delete(route('players.destroy', $newPlayer));
        $response->assertForbidden();
    }
}
