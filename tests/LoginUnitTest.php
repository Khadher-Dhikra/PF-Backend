<?php

use PHPUnit\Framework\TestCase;

class LoginUnitTest extends TestCase
{
    private function fakeLogin($email, $password)
    {
        // نفس منطق بسيط متاع backend (mock)
        if ($email === "bahajebali40@gmail.com" && $password === "123456") {
            return [
                "status" => "success",
                "token" => "fake_token",
                "refreshToken" => "fake_refresh",
                "user" => [
                    "id" => 4,
                    "email" => $email,
                    "role" => "student"
                ]
            ];
        }

        return [
            "status" => "error",
            "message" => "Invalid credentials"
        ];
    }

    public function testLoginSuccess()
    {
        $response = $this->fakeLogin("bahajebali40@gmail.com", "123456");

        $this->assertEquals("success", $response["status"]);
        $this->assertArrayHasKey("token", $response);
        $this->assertArrayHasKey("refreshToken", $response);
        $this->assertEquals("student", $response["user"]["role"]);
    }

    public function testLoginFail()
    {
        $response = $this->fakeLogin("wrong@gmail.com", "wrong");

        $this->assertEquals("error", $response["status"]);
        $this->assertEquals("Invalid credentials", $response["message"]);
    }
}