<?php

namespace Tests\Browser;

use App\User;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\LoginPage;
use Tests\DuskTestCase;

class CreatePostTest extends DuskTestCase
{
    /**
     * Visiting the create post page.
     *
     * @return void
     */
    public function testVisitPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->on(new LoginPage)
                ->loginUser()
                ->visit('/')
                ->click('@create-post-link')
                ->assertSee('Title')
                ->assertSee('Description');
        });
    }

    /**
     * Testing the validation errors
     *
     * @return void
     */
    public function testValidationErrors()
    {
        $this->browse(function (Browser $browser) {
            $browser->on(new LoginPage)
                ->loginUser()
                ->visit('/post/create')
                ->waitUntil('app.__vue__._isMounted')
                ->press('Create')
                ->waitFor('.invalid-feedback')
                ->assertSee('The title field is required.')
                ->assertSee('The description field is required.');
        });
    }

    /**
     * Testing create post.
     *
     * @return void
     */
    public function testCreatePost()
    {
        $this->browse(function (Browser $browser) {
            $browser->on(new LoginPage)
                ->loginUser()
                ->visit('/post/create')
                ->waitUntil('app.__vue__._isMounted')
                ->type('#postTitleInput', 'The New Test Post')
                ->type('.simditor-body', 'Test Description')
                ->waitFor('.simditor')
                ->assertSee('Create')
                ->press('Create');
        });
    }

}
