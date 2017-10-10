<?php

/**
 * Class UserTest
 */
class UserTest extends TestCase
{
    /**
     * Run migrations
     * Seed Adatabase
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->artisan('migrate');
        $this->artisan('db:seed');
    }

    /**
     * Test can get all the users
     *
     * @return void
     */
    public function testCanGetAllUsers()
    {
        $this->json('GET', '/users')->seeStatusCode(200);
    }

    /**
     * Test that name field is required
     *
     * @return void
     */
    public function testThatNameFieldIsRequiredToCreateAUser()
    {
        $this->json(
            'POST', '/users', [
                'name' => ' '
            ]
        )->seeJson(
            [
                'name' => [
                    'The name field is required.'
                ]
            ]
        )->seeStatusCode(422);
    }

    /**
     * Test that email field is required
     *
     * @return void
     */
    public function testThatEmailFieldIsRequiredToCreateAUser()
    {
        $this->json(
            'POST', '/users', [
                'email' => ' '
            ]
        )->seeJson(
            [
                'email' => [
                    'The email field is required.'
                ]
            ]
        )->seeStatusCode(422);
    }

    /**
     * Test that password field is required
     *
     * @return void
     */
    public function testThatPasswordFieldIsRequiredToCreateAUser()
    {
        $this->json(
            'POST', '/users', [
                'password' => ' '
            ]
        )->seeJson(
            [
                'password' => [
                    'The password field is required.'
                ]
            ]
        )->seeStatusCode(422);
    }

    /**
     * Reset Migrations
     *
     * @return void
     */
    public function tearDown()
    {
        $this->artisan('migrate:reset');
    }
}
