<?php

use App\Models\Club;
use App\Models\Player;
use App\Models\SportMatch;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class AuthorisationTest extends TestCase
{
    use DatabaseMigrations;

    protected User $user;
    protected User $clubAdmin;

    protected User $user2;
    protected User $clubAdmin2;

    protected Club $club;
    protected Club $club2;

    protected Team $team;
    protected Team $team2;
    protected Player $player;
    protected Player $player2;
    protected SportMatch $sportMatch;
    protected SportMatch $sportMatch2;

    public function setUp(): void
    {
        parent::setUp();

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        /* Create admin and user roles */
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);
        $this->club = Club::factory()->create(['logo' => '']);
        $this->club2 = Club::factory()->create(['logo' => '']);

        $this->clubAdmin = User::factory()->admin()->create(['club_id' => $this->club->id]);
        $this->team      = Team::factory()->create(['club_id' => $this->club->id]);
        $this->user      = User::factory()->user()->create(['club_id' => $this->club->id]);
        $this->player    = Player::factory()->create(['user_id' => $this->user->id, 'team_id' => $this->team->id]);
        $this->sportMatch    = SportMatch::factory()->create(['club_id' => $this->user->club_id]);

        $this->clubAdmin2 = User::factory()->admin()->create(['club_id' => $this->club2->id]);
        $this->team2      = Team::factory()->create(['club_id' => $this->club2->id]);
        $this->user2      = User::factory()->user()->create(['club_id' => $this->club2->id]);
        $this->player2    = Player::factory()->create(['user_id' => $this->user2->id, 'team_id' => $this->team2->id]);
        $this->sportMatch2    = SportMatch::factory()->create(['club_id' => $this->user2->club_id]);

    }

    /** @test */
    public function an_admin_user_cannot_see_another_club()
    {
        $this->actingAs($this->clubAdmin);

        $response = $this->get(route('clubs.show', $this->club2));

        $response->assertForbidden();
    }

    /** @test */
    public function an_admin_user_cannot_edit_another_club()
    {
        $this->actingAs($this->clubAdmin);

        $response = $this->get(route('clubs.edit', $this->club2));

        $response->assertForbidden();
    }

    /** @test */
    public function an_admin_user_cannot_delete_another_club()
    {
        $this->actingAs($this->clubAdmin);

        $response = $this->get(route('clubs.destroy', $this->club2));

        $response->assertForbidden();
    }

    /** @test */
    public function an_admin_user_cannot_see_another_team()
    {
        $this->actingAs($this->clubAdmin);

        $response = $this->get(route('teams.show', $this->team2));

        $response->assertForbidden();
    }

    /** @test */
    public function an_admin_user_cannot_edit_another_team()
    {
        $this->actingAs($this->clubAdmin);

        $response = $this->get(route('teams.edit', $this->team2));

        $response->assertForbidden();
    }

    /** @test */
    public function an_admin_user_cannot_delete_another_team()
    {
        $this->actingAs($this->clubAdmin);

        $response = $this->get(route('teams.destroy', $this->team2));

        $response->assertForbidden();
    }

    /** @test */
    public function an_admin_user_cannot_see_another_clubs_player()
    {
        $this->actingAs($this->clubAdmin);

        $response = $this->get(route('players.show', $this->player2));

        $response->assertForbidden();
    }

    /** @test */
    public function an_admin_user_cannot_edit_another_clubs_player()
    {
        $this->actingAs($this->clubAdmin);

        $response = $this->get(route('players.edit', $this->player2));

        $response->assertForbidden();
    }

    /** @test */
    public function an_admin_user_cannot_delete_another_clubs_player()
    {
        $this->actingAs($this->clubAdmin);

        $response = $this->get(route('players.destroy', $this->player2));

        $response->assertForbidden();
    }

    /** @test */
    public function an_admin_user_cannot_see_another_clubs_matches()
    {
        $this->actingAs($this->clubAdmin);

        $response = $this->get(route('matches.show', $this->sportMatch2));

        $response->assertForbidden();
    }

    /** @test */
    public function an_admin_user_cannot_edit_another_clubs_matches()
    {
        $this->actingAs($this->clubAdmin);

        $response = $this->get(route('matches.edit', $this->sportMatch2));

        $response->assertForbidden();
    }

    /** @test */
    public function an_admin_user_cannot_delete_another_clubs_matches()
    {
        $this->actingAs($this->clubAdmin);

        $response = $this->get(route('matches.destroy', $this->sportMatch2));

        $response->assertForbidden();
    }

    /** @test */
    public function an_admin_user_can_see_his_club()
    {
        $this->actingAs($this->clubAdmin);

        $response = $this->get(route('clubs.show', $this->club));

        $response->assertStatus(200);
        $response->assertSeeText($this->club->name);
    }

    /** @test */
    public function an_admin_user_can_edit_his_club()
    {
        $this->actingAs($this->clubAdmin);

        $response = $this->get(route('clubs.edit', $this->club));

        $response->assertStatus(200);
    }

    /** @test */
    public function an_admin_user_can_delete_his_club()
    {
        $this->actingAs($this->clubAdmin);

        $response = $this->get(route('clubs.destroy', $this->club));

        $response->assertStatus(200);
    }

    /** @test */
    public function an_admin_user_can_see_his_team()
    {
        $this->actingAs($this->clubAdmin);

        $response = $this->get(route('teams.show', $this->team));

        $response->assertStatus(200);
    }

    /** @test */
    public function an_admin_user_can_edit_his_team()
    {
        $this->actingAs($this->clubAdmin);

        $response = $this->get(route('teams.edit', $this->team));

        $response->assertStatus(200);
    }

    /** @test */
    public function an_admin_user_can_delete_his_team()
    {
        $this->actingAs($this->clubAdmin);

        $response = $this->get(route('teams.destroy', $this->team));

        $response->assertStatus(200);
    }

    /** @test */
    public function an_admin_user_can_see_his_clubs_player()
    {
        $this->actingAs($this->clubAdmin);

        $response = $this->get(route('players.show', $this->player));

        $response->assertStatus(200);
    }

    /** @test */
    public function an_admin_user_can_edit_another_clubs_player()
    {
        $this->actingAs($this->clubAdmin);

        $response = $this->get(route('players.edit', $this->player));

        $response->assertStatus(200);
    }

    /** @test */
    public function an_admin_user_can_delete_his_clubs_players()
    {
        $this->actingAs($this->clubAdmin);

        $response = $this->get(route('players.destroy', $this->player));

        $response->assertStatus(200);
    }

    /** @test */
    public function an_admin_user_can_see_his_clubs_matches()
    {
        $this->actingAs($this->clubAdmin);

        $response = $this->get(route('matches.show', $this->sportMatch));

        $response->assertStatus(200);
    }

    /** @test */
    public function an_admin_user_can_edit_his_clubs_matches()
    {
        $this->actingAs($this->clubAdmin);

        $response = $this->get(route('matches.edit', $this->sportMatch));

        $response->assertStatus(200);
    }

    /** @test */
    public function an_admin_user_can_delete_his_clubs_matches()
    {
        $this->actingAs($this->clubAdmin);

        $response = $this->get(route('players.destroy', $this->sportMatch));

        $response->assertStatus(200);
    }

    /** @test */
    public function a_player_user_cannot_see_another_club()
    {
        $this->actingAs($this->user);

        $response = $this->get(route('clubs.show', $this->club2));

        $response->assertForbidden();
    }
}
