<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nasirkhan\ModuleManager\Modules\Settings\Models\Setting;
use Tests\TestCase;

class FrontendPublicViewTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_public_view(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $value = app_name();

        $response->assertSeeText($value, $escxaped = true);
    }

    public function test_homepage_uses_application_meta_settings(): void
    {
        Setting::add('app_name', 'Old App Name');
        Setting::add('app_description', 'Old app description.');
        Setting::add('meta_site_name', 'Digi Herba Nusantara');
        Setting::add('meta_description', 'Perusahaan herbal Indonesia.');

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSeeText('Digi Herba Nusantara');
        $response->assertSeeText('Perusahaan herbal Indonesia.');
        $response->assertDontSeeText('Old App Name');
        $response->assertDontSeeText('Old app description.');
        $response->assertSee('property="og:site_name" content="Digi Herba Nusantara"', false);
        $response->assertSee('property="og:description" content="Perusahaan herbal Indonesia."', false);
    }

    public function test_homepage_uses_configured_home_media_settings(): void
    {
        Setting::add('home_background_media', "img/default_banner.jpg\nimg/logo-with-text.jpg");
        Setting::add('home_gallery_images', "img/logo-square.jpg\nimg/logo.jpg");

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('data-home-background-slider', false);
        $response->assertSee('img/default_banner.jpg', false);
        $response->assertSee('img/logo-with-text.jpg', false);
        $response->assertSeeText('Galeri Produk');
        $response->assertDontSeeText('Screenshots of the project');
        $response->assertSee('img/logo-square.jpg', false);
        $response->assertSee('img/logo.jpg', false);
    }

    public function test_login_page_public_view(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);

        $value = __('Log in');

        $response->assertSeeText($value, $escxaped = true);
        $response->assertSee('id="theme-toggle"', false);
        $response->assertSee('id="theme-toggle-dark-icon"', false);
        $response->assertSee('id="theme-toggle-light-icon"', false);
    }

    public function test_registration_page_public_view(): void
    {
        $response = $this->get('/register');

        if (config('app.user_registration')) {
            $response->assertStatus(200);

            $value = 'Register';

            $response->assertSeeText($value, $escxaped = true);
        } else {
            $response->assertStatus(404);
        }
    }

    public function test_forget_password_page_public_view(): void
    {
        $response = $this->get('/forgot-password');

        $response->assertStatus(200);

        $value = 'Email password reset link';

        $response->assertSeeText($value, $escxaped = true);
    }

    public function test_privacy_policy_page_public_view(): void
    {
        $response = $this->get('/privacy');

        $response->assertStatus(200);

        $value = 'Privacy Policy';

        $response->assertSeeText($value, $escxaped = true);
    }

    public function test_terms_page_public_view(): void
    {
        $response = $this->get('/terms');

        $response->assertStatus(200);

        $value = 'Terms and Conditions ';

        $response->assertSeeText($value, $escxaped = true);
    }
}
