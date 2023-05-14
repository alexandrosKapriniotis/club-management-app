<?php

use App\Models\Club;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class ClubsTest extends TestCase
{
    use DatabaseMigrations;

    protected User $user;
    protected User $clubAdmin;
    protected Club $club;

    public function setUp(): void
    {
        parent::setUp();

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        /* Create admin and user roles */
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);
        $this->club = Club::factory()->create(['logo' => '']);

        $this->clubAdmin = User::factory()->admin()->create(['club_id' => $this->club->id]);
        $this->user      = User::factory()->user()->create(['club_id' => $this->club->id]);
    }

    /** @test */
    public function an_admin_user_can_see_the_club_view_screen()
    {
        $this->actingAs($this->clubAdmin);
        $response = $this->get(route('clubs.show', $this->club));

        $response->assertStatus(200);
    }

    /** @test */
    public function an_admin_user_can_edit_a_club()
    {
        $this->actingAs($this->clubAdmin);
        $response = $this->get(route('clubs.edit', $this->club));
        $response->assertStatus(200);

        $postResponse = $this->put(route('clubs.update', $this->club), [
            'name' => 'edited',
        ]);
        $postResponse->assertStatus(302);

        $this->assertEquals('edited', $this->club->fresh()->name);
    }

    /** @test */
    public function a_user_can_see_the_club_view_screen()
    {
        $this->actingAs($this->user);
        $response = $this->get(route('clubs.show', $this->club));

        $response->assertStatus(200);
    }

    /** @test */
    public function a_user_cannot_edit_a_club()
    {
        $this->actingAs($this->user);
        $response = $this->get(route('clubs.edit', $this->club));

        $response->assertForbidden();
        $response->assertDontSee($this->club->name);
    }


}
