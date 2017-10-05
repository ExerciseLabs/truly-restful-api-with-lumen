<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
  public function setUp()
  {
    parent::setUp();
     $this->artisan('migrate');
     $this->artisan('db:seed');
   }

   public function testCanGetAllUsers()
   {
     $this->json('GET', '/users')->seeStatusCode(200);
   }

   public function tearDown()
   {
     $this->artisan('migrate:reset');
   }
}
