<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Exception;

class GeminiService
{
    private $apiKey;
    private $apiUrl;
    private $model;
    private $timeout;

    public function __construct()
    {
        $this->apiKey = config('gemini.api_key');
        $this->apiUrl = config('gemini.api_url');
        $this->model = config('gemini.model');
        $this->timeout = config('gemini.timeout', 60);

        if (!$this->apiKey) {
            throw new Exception('GEMINI_API_KEY không được cấu hình trong .env');
        }
    }

    /**
     * Gọi Gemini API để tạo câu hỏi trắc nghiệm
     */
    public function generateQuestion(string $prompt): array
    {
        try {
            $response = Http::timeout($this->timeout)->post(
                "{$this->apiUrl}/{$this->model}:generateContent?key={$this->apiKey}",
                [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt]
                            ]
                        ]
                    ]
                ]
            );

            if ($response->failed()) {
                throw new Exception('Lỗi từ Gemini API: ' . $response->body());
            }

            $result = $response->json();
            $content = $result['candidates'][0]['content']['parts'][0]['text'] ?? '';

            // Parse JSON response
            return $this->parseQuestionResponse($content);
        } catch (Exception $e) {
            throw new Exception('Lỗi khi gọi Gemini API: ' . $e->getMessage());
        }
    }

    /**
     * Gọi Gemini API để tạo văn bản
     */
    public function generateTextFromPrompt(string $prompt): string
    {
        try {
            $response = Http::timeout($this->timeout)->post(
                "{$this->apiUrl}/{$this->model}:generateContent?key={$this->apiKey}",
                [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt]
                            ]
                        ]
                    ]
                ]
            );

            if ($response->failed()) {
                throw new Exception('Lỗi từ Gemini API: ' . $response->body());
            }

            $result = $response->json();
            return $result['candidates'][0]['content']['parts'][0]['text'] ?? '';
        } catch (Exception $e) {
            throw new Exception('Lỗi khi gọi Gemini API: ' . $e->getMessage());
        }
    }

    /**
     * Parse JSON response từ Gemini
     */
    private function parseQuestionResponse(string $content): array
    {
        try {
            // Loại bỏ markdown formatting nếu có
            $content = preg_replace('/```json\s*|\s*```/', '', $content);
            $content = trim($content);

            $parsed = json_decode($content, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('JSON không hợp lệ: ' . json_last_error_msg());
            }

            return is_array($parsed) ? $parsed : [$parsed];
        } catch (Exception $e) {
            throw new Exception('Lỗi parse JSON: ' . $e->getMessage());
        }
    }

    /**
     * Chat với chatbot
     */
    public function chat(string $userMessage): string
    {
        $systemPrompt = "Bạn là chatbot hỗ trợ khách hàng của NHTravel - một công ty du lịch chuyên tổ chức tour du lịch trong nước Việt Nam. "
            . "Website này CHỈ cung cấp các tour du lịch TRONG NƯỚC (miền Bắc, miền Trung, miền Nam). "
            . "NHTravel KHÔNG cung cấp tour du lịch nước ngoài.\n\n"
            . "Khi khách hỏi về tour nước ngoài, hãy:\n"
            . "1. Thông báo rõ ràng rằng NHTravel không có tour nước ngoài\n"
            . "2. Giới thiệu các tour du lịch trong nước thay thế phù hợp\n"
            . "3. Recommend các địa điểm/tour tương tự mà website có\n\n"
            . "Hãy trả lời một cách thân thiện, chuyên nghiệp, và luôn dựa trên dữ liệu thực tế của website. "
            . "Tránh đưa ra thông tin không có trong dữ liệu được cung cấp."
            . "Thông tin liên hệ của trang web NHTravel như sau:\n SDT: 01900 19000\n Email: support@nhtravel.com \n Địa chỉ: 52 Lê Đại Hành, Phường 15, Quận 11, TP.HCM."
            . "Cách thức thanh toán bao gồm: Thanh toán qua thẻ tín dụng, chuyển khoản ngân hàng VNPay, và thanh toán khi nhận dịch vụ.\n\n"
            . "Mã giảm giá hiện có:\n - GIAM10: Giảm 10% cho đơn hàng từ 5 triệu đồng trở lên.\n - GIAM20: Giảm 20% cho đơn hàng từ 10 triệu đồng trở lên.\n\n"
            . "Đặt tour phải đăng nhập tài khoản. Khách hàng có thể đăng ký tài khoản bằng email hoặc số điện thoại.\n\n";
        
        $prompt = "$systemPrompt\n\n$userMessage\n\nHãy trả lời ngắn gọn, rõ ràng và hữu ích.";

        return $this->generateTextFromPrompt($prompt);
    }
}
