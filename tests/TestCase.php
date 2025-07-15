<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
abstract class TestCase extends BaseTestCase
{
    
    use CreatesApplication;

    protected function setUp():void{
        parent::setUp();
        DB::delete("delete from users");
        DB::delete("delete from educations");
        DB::delete("delete from projects");
        DB::delete("delete from experiences");
        DB::delete("delete from certifications");
    }

}
