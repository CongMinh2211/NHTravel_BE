<?php

return [
    'api_key' => env('GEMINI_API_KEY'),
    
    'model' => 'gemini-2.0-flash',
    
    'api_url' => 'https://generativelanguage.googleapis.com/v1beta/models',
    
    'timeout' => env('GEMINI_TIMEOUT', 60),
    
    'chatbot' => [
        'system_prompt' => 'Bạn là một chatbot hỗ trợ khách hàng cho ứng dụng NHTravel - ứng dụng đặt tour du lịch. Hãy trả lời lịch sự, thân thiện và hữu ích. Nếu không biết, hãy hỏi lại hoặc gợi ý chuyển đến bộ phận hỗ trợ khách hàng.',
    ],
];
