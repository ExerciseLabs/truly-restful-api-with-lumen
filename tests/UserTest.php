<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

/**
 * Class UserTest
 */
class UserTest extends TestCase
{
    /**
     * Stup
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
     * Test can create a user
     *
     * @return void
     */
    public function testCanCreateUser()
    {
        $this->json(
            'POST', '/user', [
            'name' => 'Sally',
            'email' => 'sally@foo.com',
            'password' => 'salisg']
        )->seeJson(
            [
                'response' => [
                    'created' => true,
                    '_links' => [
                        'self' => 'http://book-ap.dev/user/6'
                    ]
                ]
            ]
        )->seeStatusCode(201);
    }

    /**
     * Test that name field is required
     *
     * @return void
     */
    public function testThatNameFieldIsRequiredToCreateAUser()
    {
        $this->json(
            'POST', '/user', [
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
            'POST', '/user', [
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
            'POST', '/user', [
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
     * Down method
     */
    public function tearDown()
    {
        $this->artisan('migrate:reset');
    }
}
