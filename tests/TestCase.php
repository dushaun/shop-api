<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tymon\JWTAuth\Contracts\JWTSubject;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;

    protected $dropViews;

    /**
     * TestCase constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->dropViews = true;
    }

    /**
     * JSON as a logged in user.
     *
     * @param JWTSubject $user
     * @param $method
     * @param $endpoint
     * @param array $data
     * @param array $headers
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function jsonAs(JWTSubject $user, $method, $endpoint, $data = [], $headers = [])
    {
        $token = auth()->tokenById($user->id);

        return $this->json($method, $endpoint, $data, array_merge($headers, [
            'Authorization' => "Bearer {$token}"
        ]));
    }
}
