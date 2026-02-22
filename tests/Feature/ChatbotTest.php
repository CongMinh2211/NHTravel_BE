<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChatbotTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test hỏi câu hỏi chung (public endpoint)
     */
    public function test_ask_public_question()
    {
        $response = $this->postJson('/api/chatbot/ask', [
            'question' => 'Bạn là ai?'
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'success',
                     'answer'
                 ]);

        $this->assertTrue($response->json('success'));
    }

    /**
     * Test send message endpoint validation
     */
    public function test_send_message_validation()
    {
        $response = $this->postJson('/api/chatbot/send-message', []);

        $response->assertStatus(422);
    }

    /**
     * Test send message without authentication
     */
    public function test_send_message_requires_auth()
    {
        $response = $this->postJson('/api/chatbot/send-message', [
            'id_khach_hang' => 'test-id',
            'noi_dung' => 'Test message'
        ]);

        $response->assertStatus(401);
    }

    /**
     * Test get history without authentication
     */
    public function test_get_history_requires_auth()
    {
        $response = $this->getJson('/api/chatbot/history/test-id');

        $response->assertStatus(401);
    }

    /**
     * Test admin logs without authentication
     */
    public function test_admin_logs_requires_auth()
    {
        $response = $this->getJson('/api/admin/chatbot/logs');

        $response->assertStatus(401);
    }

    /**
     * Test GeminiService initialization
     */
    public function test_gemini_service_initialization()
    {
        $this->expectNotToPerformAssertions();

        // Nếu API key không được set, sẽ throw exception
        try {
            $service = app(\App\Services\GeminiService::class);
        } catch (\Exception $e) {
            $this->assertStringContainsString('GEMINI_API_KEY', $e->getMessage());
        }
    }
}
