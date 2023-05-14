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

class SportMatchTest extends TestCase
{
    use DatabaseMigrations;

    protected User $user;
    protected User $clubAdmin;
    protected Team $team;
    protected Club $club;
    protected SportMatch $sportMatch;

    public function setUp(): void
    {
        parent::setUp();

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        /* Create admin and user roles */
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);
        $this->club = Club::factory()->create(['logo' => '']);
        $club2 = Club::factory()->create(['logo' => '']);
        Team::factory()->create(['club_id' => $club2->id]);

        $this->team      = Team::factory()->create(['club_id' => $this->club->id]);
        $this->clubAdmin = User::factory()->admin()->create(['club_id' => $this->club->id]);
        $this->user      = User::factory()->user()->create(['club_id' => $this->club->id]);
        $this->sportMatch    = SportMatch::factory()->create(['club_id' => $this->user->club_id]);
    }

    /** @test */
    public function an_admin_user_can_see_the_match_view_screen()
    {
        $this->actingAs($this->clubAdmin);
        $response = $this->get(route('matches.show', $this->sportMatch));

        $response->assertStatus(200);
    }

    /** @test */
    public function an_admin_user_can_edit_a_match()
    {
        $this->actingAs($this->clubAdmin);
        $response = $this->get(route('matches.edit', $this->sportMatch));
        $response->assertStatus(200);

        $postResponse = $this->followingRedirects()->put(route('matches.update', $this->sportMatch), [
            'date' => '15-05-2099',
            'time' => '14:00',
            'location' => 'Athens',
            'home_team_id' => $this->sportMatch->home_team_id,
            'away_team_id' => $this->sportMatch->away_team_id,
            'home_team_score' => 1,
            'away_team_score' => 0
        ]);
        $postResponse->assertStatus(200);

        $postResponse->assertSee('Athens');
    }

    /** @test */
    public function an_admin_user_can_create_a_match()
    {
        $this->actingAs($this->clubAdmin);
        $response = $this->get(route('matches.create', $this->sportMatch));
        $response->assertStatus(200);

        $postResponse = $this->followingRedirects()->post(route('matches.store', $this->sportMatch),
            SportMatch::factory()->make(['club_id' => $this->user->club_id])->toArray());
        $postResponse->assertStatus(200);
    }

    /** @test */
    public function an_admin_user_can_delete_a_match()
    {
        $this->actingAs($this->clubAdmin);
        $newSportMatch = SportMatch::factory()->create(['club_id' => $this->user->club_id]);
        $response = $this->followingRedirects()->delete(route('matches.destroy', $newSportMatch));
        $response->assertStatus(200);
    }

    /** @test */
    public function a_user_can_see_the_match_view_screen()
    {
        $this->actingAs($this->user);
        $response = $this->get(route('matches.show', $this->sportMatch));

        $response->assertStatus(200);
    }

    /** @test */
    public function a_user_cannot_edit_a_match()
    {
        $this->actingAs($this->user);
        $response = $this->get(route('matches.edit', $this->sportMatch));

        $response->assertForbidden();
        $response->assertDontSee($this->sportMatch->location);
    }

    /** @test */
    public function an_user_cannot_create_a_match()
    {
        $this->actingAs($this->user);
        $response = $this->get(route('matches.create', $this->team));
        $response->assertForbidden();

        $postResponse = $this->followingRedirects()->post(route('matches.store', $this->sportMatch),
            SportMatch::factory()->make(['club_id' => $this->user->club_id])->toArray());
        $postResponse->assertForbidden();
    }

    /** @test */
    public function an_user_cannot_delete_a_match()
    {
        $this->actingAs($this->user);
        $newSportMatch = SportMatch::factory()->create(['club_id' => $this->user->club_id]);
        $response = $this->followingRedirects()->delete(route('matches.destroy', $newSportMatch));
        $response->assertForbidden();
    }
}
