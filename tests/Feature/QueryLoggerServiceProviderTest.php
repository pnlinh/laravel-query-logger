<?php

namespace Pnlinh\QueryLogger\Tests\Feature;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Pnlinh\QueryLogger\QueryLoggerServiceProvider;
use Pnlinh\QueryLogger\Tests\TestCase;

class QueryLoggerServiceProviderTest extends TestCase
{
    /** @test */
    public function it_can_be_constructed()
    {
        $this->assertInstanceOf(ServiceProvider::class, new QueryLoggerServiceProvider($this->app));
    }

    /** @test */
    public function it_can_be_write_log()
    {
        User::create(['email' => 'foo@bar.com']);

        $path = storage_path('logs/laravel.log');
        $logContent = file_get_contents($path);

        $this->assertFileExists($path);
        $this->assertNotEmpty($logContent);
    }
}

class User extends Model
{
    /** @var string */
    protected $table = 'users';

    /** @var bool */
    public $timestamps = false;

    /** @var string[] */
    protected $fillable = ['email'];
}
