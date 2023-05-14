<?php

use App\Models\Club;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class TeamTest extends TestCase
{
    use DatabaseMigrations;

    protected User $user;
    protected User $clubAdmin;
    protected Team $team;
    protected Club $club;

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
    }

    /** @test */
    public function an_admin_user_can_see_the_team_view_screen()
    {
        $this->actingAs($this->clubAdmin);
        $response = $this->get(route('teams.show', $this->team));

        $response->assertStatus(200);
    }

    /** @test */
    public function an_admin_user_can_edit_a_team()
    {
        $this->actingAs($this->clubAdmin);
        $response = $this->get(route('teams.edit', $this->team));
        $response->assertStatus(200);

        $postResponse = $this->put(route('teams.update', $this->team), [
            'name' => 'edited',
        ]);
        $postResponse->assertStatus(302);

        $this->assertEquals('edited', $this->team->fresh()->name);
    }

    /** @test */
    public function an_admin_user_can_create_a_team()
    {
        $this->actingAs($this->clubAdmin);
        $response = $this->get(route('teams.create', $this->team));
        $response->assertStatus(200);

        $postResponse = $this->followingRedirects()->post(route('teams.store', $this->team), [
            'name' => 'new team',
            'club_id' => $this->club->id
        ]);
        $postResponse->assertStatus(200);
        $postResponse->assertSee('new team');
    }

    /** @test */
    public function an_admin_user_can_delete_a_team()
    {
        $this->actingAs($this->clubAdmin);
        $team = Team::factory()->create(['club_id' => $this->club->id]);
        $response = $this->followingRedirects()->delete(route('teams.destroy', $team));
        $response->assertStatus(200);
    }

    /** @test */
    public function a_user_can_see_the_team_view_screen()
    {
        $this->actingAs($this->user);
        $response = $this->get(route('teams.show', $this->team));

        $response->assertStatus(200);
    }

    /** @test */
    public function a_user_cannot_edit_a_team()
    {
        $this->actingAs($this->user);
        $response = $this->get(route('teams.edit', $this->team));

        $response->assertForbidden();
        $response->assertDontSee($this->team->name);
    }

    /** @test */
    public function an_user_cannot_create_a_team()
    {
        $this->actingAs($this->user);
        $response = $this->get(route('teams.create', $this->team));
        $response->assertForbidden();

        $postResponse = $this->followingRedirects()->post(route('teams.store', $this->team), [
            'name' => 'new team',
            'club_id' => $this->club->id
        ]);
        $postResponse->assertForbidden();
    }

    /** @test */
    public function a_user_cannot_delete_a_team()
    {
        $this->actingAs($this->user);
        $team = Team::factory()->create(['club_id' => $this->club->id]);
        $response = $this->delete(route('teams.destroy', $team));

        $response->assertForbidden();
    }
}
