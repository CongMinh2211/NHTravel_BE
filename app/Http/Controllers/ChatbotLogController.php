<?php

namespace App\Http\Controllers;

use App\Models\ChatbotLog;
use App\Models\TourDuLich;
use App\Models\DanhMuc;
use App\Services\GeminiService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ChatbotLogController extends Controller
{
    private $geminiService;

    public function __construct(GeminiService $geminiService)
    {
        $this->geminiService = $geminiService;
    }

    /**
     * Lấy lịch sử chat của khách hàng
     */
    public function getHistory($userId): JsonResponse
    {
        try {
            $chatLogs = ChatbotLog::where('id_khach_hang', $userId)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $chatLogs
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Lỗi khi lấy lịch sử chat: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Gửi tin nhắn cho chatbot
     */
    public function sendMessage(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'id_khach_hang' => 'required|uuid',
                'noi_dung' => 'required|string'
            ]);

            $userId = $request->input('id_khach_hang');
            $userMessage = $request->input('noi_dung');

            // Lưu tin nhắn của người dùng
            ChatbotLog::create([
                'id_khach_hang' => $userId,
                'noi_dung' => $userMessage,
                'loai_tin_nhan' => 'user'
            ]);

            // Gọi Gemini để lấy phản hồi
            $response = $this->geminiService->chat($userMessage);

            // Lưu phản hồi của chatbot
            ChatbotLog::create([
                'id_khach_hang' => $userId,
                'noi_dung' => $response,
                'loai_tin_nhan' => 'bot'
            ]);

            return response()->json([
                'success' => true,
                'message' => $response
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Lỗi khi gửi tin nhắn: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Xóa lịch sử chat
     */
    public function clearHistory($userId): JsonResponse
    {
        try {
            ChatbotLog::where('id_khach_hang', $userId)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Xóa lịch sử chat thành công'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Lỗi khi xóa lịch sử: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Hỏi câu hỏi chung (không yêu cầu đăng nhập)
     */
    public function askQuestion(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'question' => 'required|string'
            ]);

            $question = $request->input('question');
            
            // Lấy dữ liệu tour để cung cấp context cho chatbot
            $tours = TourDuLich::select('ten_tour', 'mo_ta', 'gia_nguoi_lon', 'ngay_di', 'ngay_ve')
                ->with('danhMuc:id,ten_danh_muc')
                ->where('trang_thai', 'hoat_dong')
                ->limit(20)
                ->get();
            
            // Lấy danh mục tour
            $categories = DanhMuc::select('id', 'ten_danh_muc')->get();
            
            // Format dữ liệu tour thành string
            $toursInfo = "Danh sách tour du lịch trong nước hiện có:\n";
            if ($tours->isNotEmpty()) {
                foreach ($tours as $tour) {
                    $category = $tour->danhMuc ? $tour->danhMuc->ten_danh_muc : 'Không xác định';
                    $toursInfo .= "- {$tour->ten_tour} ({$category}): {$tour->mo_ta}\n";
                    $toursInfo .= "  Giá: " . ($tour->gia_nguoi_lon ? number_format($tour->gia_nguoi_lon) . " VNĐ" : "Liên hệ") . ", ";
                    $toursInfo .= "Ngày: {$tour->ngay_di} - {$tour->ngay_ve}\n";
                }
            } else {
                $toursInfo .= "Hiện chưa có tour nào\n";
            }
            
            $categoriesInfo = "Các loại tour: " . ($categories->isNotEmpty() ? $categories->pluck('ten_danh_muc')->implode(', ') : "Chưa có danh mục");
            
            // Thêm context vào câu hỏi
            $contextQuestion = "Thông tin về NHTravel:\n"
                . $toursInfo . "\n"
                . $categoriesInfo . "\n\n"
                . "Câu hỏi của khách hàng: " . $question;
            
            $response = $this->geminiService->chat($contextQuestion);

            return response()->json([
                'success' => true,
                'answer' => $response
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Lỗi khi xử lý câu hỏi: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Index - lấy danh sách chat logs
     */
    public function index(): JsonResponse
    {
        try {
            $logs = ChatbotLog::orderBy('created_at', 'desc')->paginate(20);
            return response()->json($logs);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Lỗi: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Xóa một chat log
     */
    public function destroy($id): JsonResponse
    {
        try {
            $log = ChatbotLog::find($id);
            
            if (!$log) {
                return response()->json([
                    'success' => false,
                    'error' => 'Không tìm thấy chat log'
                ], 404);
            }

            $log->delete();

            return response()->json([
                'success' => true,
                'message' => 'Xóa thành công'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Lỗi khi xóa: ' . $e->getMessage()
            ], 500);
        }
    }
}
