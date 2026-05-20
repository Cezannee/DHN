<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Nasirkhan\ModuleManager\Modules\Settings\Models\Setting;
use Tests\TestCase;

class BackendViewSuperAdminTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // seed the database
        $this->seed();

        // Get Super Admin
        $user = User::whereId(1)->first();

        $this->actingAs($user);
    }

    /**
     * Backend Dashboard Test.
     *
     * ---------------------------------------------------------------
     */
    public function test_super_admin_user_can_view_backend(): void
    {
        $response = $this->get('/admin');
        $response->assertStatus(200);

        $response = $this->get('/admin/dashboard');
        $response->assertStatus(200);
    }

    /**
     * Notifications Test.
     *
     * ---------------------------------------------------------------
     */
    public function test_super_admin_user_can_view_notifications_index(): void
    {
        $response = $this->get('/admin/notifications');

        $response->assertStatus(200);
    }

    /**
     * Settings Test.
     *
     * ---------------------------------------------------------------
     */
    public function test_super_admin_user_can_view_settings_index(): void
    {
        $response = $this->get('/admin/settings');

        $response->assertStatus(200);
        $response->assertDontSee('name=" show_credit"', false);
        $response->assertSee('name="show_credit"', false);
    }

    public function test_super_admin_user_can_udpate_settings(): void
    {
        $fields_data = [];

        foreach (config('settings.setting_fields') as $section => $fields) {
            foreach ($fields['elements'] as $field) {
                $name = $field['name'];
                $value = $field['value'];

                $fields_data[$name] = $value;
            }
        }

        $fields_data['app_name'] = 'Awesome Laravel Starter';

        $response = $this->postJson(route('backend.settings.store'), $fields_data);

        $response->assertStatus(302);
    }

    public function test_super_admin_user_settings_changes_are_persisted(): void
    {
        $fields_data = [];

        foreach (config('settings.setting_fields') as $section => $fields) {
            foreach ($fields['elements'] as $field) {
                $fields_data[$field['name']] = $field['value'];
            }
        }

        $fields_data['app_name'] = 'Digi Herba Updated';
        $fields_data['show_credit'] = '1';
        $fields_data['show_theme_dropdown'] = '0';
        $fields_data['website_url'] = 'https://digi-herba.test';

        $response = $this->post(route('backend.settings.store'), $fields_data);

        $response->assertRedirect();
        $this->assertSame('Digi Herba Updated', Setting::get('app_name'));
        $this->assertSame('1', Setting::get('show_credit'));
        $this->assertFalse(Setting::get('show_theme_dropdown'));
        $this->assertSame('Digi Herba Updated', app_name());
        $this->assertSame('https://digi-herba.test', app_url());
    }

    public function test_super_admin_user_can_upload_home_background_media(): void
    {
        $fields_data = [];

        foreach (config('settings.setting_fields') as $section => $fields) {
            foreach ($fields['elements'] as $field) {
                $fields_data[$field['name']] = $field['value'];
            }
        }

        $fields_data['home_background_media'] = 'background/existing.jpg';
        $fields_data['home_background_media_uploads'] = [
            UploadedFile::fake()->create('herbal-bg.jpg', 128, 'image/jpeg'),
        ];

        $response = $this->post(route('backend.settings.store'), $fields_data);

        $response->assertRedirect();

        $mediaPaths = preg_split('/[\r\n]+/', Setting::get('home_background_media')) ?: [];
        $uploadedPath = collect($mediaPaths)->first(fn ($path) => str_starts_with($path, 'background/') && $path !== 'background/existing.jpg');

        $this->assertContains('background/existing.jpg', $mediaPaths);
        $this->assertNotNull($uploadedPath);
        $this->assertTrue(File::exists(public_path($uploadedPath)));

        File::delete(public_path($uploadedPath));
    }

    public function test_super_admin_user_can_upload_home_gallery_images(): void
    {
        $fields_data = [];

        foreach (config('settings.setting_fields') as $section => $fields) {
            foreach ($fields['elements'] as $field) {
                $fields_data[$field['name']] = $field['value'];
            }
        }

        $fields_data['home_gallery_images'] = 'galeri produk/existing.jpg';
        $fields_data['home_gallery_images_uploads'] = [
            UploadedFile::fake()->create('produk-herbal.jpg', 128, 'image/jpeg'),
        ];

        $response = $this->post(route('backend.settings.store'), $fields_data);

        $response->assertRedirect();

        $mediaPaths = preg_split('/[\r\n]+/', Setting::get('home_gallery_images')) ?: [];
        $uploadedPath = collect($mediaPaths)->first(fn ($path) => str_starts_with($path, 'galeri produk/') && $path !== 'galeri produk/existing.jpg');

        $this->assertContains('galeri produk/existing.jpg', $mediaPaths);
        $this->assertNotNull($uploadedPath);
        $this->assertTrue(File::exists(public_path($uploadedPath)));

        File::delete(public_path($uploadedPath));
    }

    public function test_settings_home_media_lists_show_delete_controls(): void
    {
        Setting::add('home_background_media', 'background/delete-control-preview.jpg');
        Setting::add('home_gallery_images', 'galeri produk/delete-control-preview.jpg');

        $response = $this->get('/admin/settings');

        $response->assertStatus(200);
        $response->assertSee('name="delete_media[home_background_media][]"', false);
        $response->assertSee('name="delete_media[home_gallery_images][]"', false);
        $response->assertSeeText('Hapus media dicentang');
    }

    public function test_super_admin_user_can_delete_home_background_media(): void
    {
        $mediaPath = 'background/delete-test-'.uniqid().'.jpg';

        File::ensureDirectoryExists(public_path('background'));
        File::put(public_path($mediaPath), 'test');

        $fields_data = $this->settingsPayload();
        $fields_data['home_background_media'] = "background/keep.jpg\n{$mediaPath}";
        $fields_data['delete_media'] = [
            'home_background_media' => [$mediaPath],
        ];

        $response = $this->post(route('backend.settings.store'), $fields_data);

        $response->assertRedirect();
        $this->assertFalse(File::exists(public_path($mediaPath)));
        $this->assertSame('background/keep.jpg', Setting::get('home_background_media'));
    }

    public function test_super_admin_user_can_delete_home_gallery_image(): void
    {
        $mediaPath = 'galeri produk/delete-test-'.uniqid().'.jpg';

        File::ensureDirectoryExists(public_path('galeri produk'));
        File::put(public_path($mediaPath), 'test');

        $fields_data = $this->settingsPayload();
        $fields_data['home_gallery_images'] = "galeri produk/keep.jpg\n{$mediaPath}";
        $fields_data['delete_media'] = [
            'home_gallery_images' => [$mediaPath],
        ];

        $response = $this->post(route('backend.settings.store'), $fields_data);

        $response->assertRedirect();
        $this->assertFalse(File::exists(public_path($mediaPath)));
        $this->assertSame('galeri produk/keep.jpg', Setting::get('home_gallery_images'));
    }

    public function test_except_super_admin_user_can_not_udpate_settings(): void
    {
        $user = User::whereId(5)->first();

        $this->actingAs($user);

        $fields_data = [];

        foreach (config('settings.setting_fields') as $section => $fields) {
            foreach ($fields['elements'] as $field) {
                $name = $field['name'];
                $value = $field['value'];

                $fields_data[$name] = $value;
            }
        }

        $response = $this->postJson(route('backend.settings.store'), $fields_data);

        $response->assertStatus(403);
    }

    /**
     * Users Test.
     *
     * ---------------------------------------------------------------
     */
    public function test_super_admin_user_can_view_users_index(): void
    {
        $response = $this->get('/admin/users');

        $response->assertStatus(200);
    }

    public function test_super_admin_user_can_create_user(): void
    {
        $response = $this->get('/admin/users/create');

        $response->assertStatus(200);
    }

    public function test_super_admin_user_can_show_user(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            $response = $this->get('/admin/users/'.$i);

            $response->assertStatus(200);
        }
    }

    public function test_super_admin_user_can_edit_user(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            $response = $this->get('/admin/users/'.$i.'/edit');

            $response->assertStatus(200);
        }
    }

    public function test_super_admin_user_can_delete_user(): void
    {
        $model_id = 5;

        $user = User::find($model_id);

        $this->assertModelExists($user);

        $user->delete();

        $this->assertSoftDeleted($user);
    }

    public function test_super_admin_user_can_view_trashed_user(): void
    {
        $model_id = 5;

        $user = User::find($model_id);

        $this->assertModelExists($user);

        $user->delete();

        $this->assertDatabaseMissing('users', [
            'id' => $model_id,
            'deleted_at' => null,
        ]);
    }

    public function test_super_admin_user_can_restore_trashed_user(): void
    {
        $model_id = 5;

        $response = $this->delete('/admin/users/'.$model_id);

        $response->assertStatus(302);

        $response->assertRedirect('/admin/users');

        $user = User::withTrashed()->find($model_id)->first();

        $user->restore();

        $this->assertModelExists($user);
    }

    public function test_super_admin_user_can_restore_user(): void
    {
        $model_id = 5;

        $user = User::find($model_id);

        $this->assertModelExists($user);

        $user->delete();

        $this->assertSoftDeleted($user);
    }

    public function test_super_admin_user_can_view_change_password_user(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            $response = $this->get('/admin/users/'.$i.'/change-password');

            $response->assertStatus(200);
        }
    }

    public function test_super_admin_user_can_update_user_password(): void
    {
        $user_id = 5;

        $response = $this
            ->patchJson(route('backend.users.changePasswordUpdate', $user_id), [
                // '_method' => 'PATCH',
                'password' => '123456',
                'password_confirmation' => '123456',
            ]);

        $response->assertStatus(302);

        $response->assertRedirect(route('backend.users.show', $user_id));
    }

    /**
     * Roles Test.
     *
     * ---------------------------------------------------------------
     */
    public function test_super_admin_user_can_view_roles_index(): void
    {
        $response = $this->get('/admin/roles');

        $response->assertStatus(200);
    }

    public function test_super_admin_user_can_view_roles_count(): void
    {
        $this->assertDatabaseCount('roles', 5);
    }

    public function test_super_admin_user_can_create_role(): void
    {
        $response = $this->get('/admin/roles/create');

        $response->assertStatus(200);
    }

    public function test_super_admin_user_can_show_role(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            $response = $this->get('/admin/roles/'.$i);

            $response->assertStatus(200);
        }
    }

    public function test_super_admin_user_can_edit_role(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            $response = $this->get('/admin/roles/'.$i.'/edit');

            $response->assertStatus(200);
        }
    }

    public function test_super_admin_user_can_delete_role(): void
    {
        $model_id = 5;

        $user = Role::find($model_id);

        $this->assertModelExists($user);

        $user->delete();

        $this->assertModelMissing($user);
    }

    private function settingsPayload(): array
    {
        $fields_data = [];

        foreach (config('settings.setting_fields') as $section => $fields) {
            foreach ($fields['elements'] as $field) {
                $fields_data[$field['name']] = $field['value'];
            }
        }

        return $fields_data;
    }
}
