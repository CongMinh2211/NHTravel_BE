<?php

namespace App\Http\Controllers;

use App\Models\BaiViet;
use Illuminate\Http\Request;

class BaiVietController
{
    /**
     * Danh sách bài viết (chỉ bài xuất bản).
     */
    public function index()
    {
        $baiViets = BaiViet::with('danhMuc')
            ->where('tinh_trang', 'xuat_ban')
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $baiViets
        ]);
    }

    /**
     * Thêm mới bài viết.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tieu_de'      => 'required|max:255',
            'mo_ta_ngan'   => 'required|max:500',
            'noi_dung'     => 'required',
            'hinh_anh'     => 'nullable|max:500',
            'tag'          => 'nullable|max:255',
            'id_danh_muc'  => 'required|integer',
            'tinh_trang'   => 'required|in:nhap,xuat_ban'
        ]);

        $bv = BaiViet::create($validated);

        return response()->json([
            'success' => true,
            'data' => $bv
        ]);
    }

    /**
     * Lấy chi tiết 1 bài viết.
     */
    public function show($id)
    {
        $baiViet = BaiViet::with('danhMuc')
            ->where('id', $id)
            ->where('tinh_trang', 'xuat_ban')
            ->first();

        if (!$baiViet) {
            return response()->json([
                'success' => false,
                'message' => 'Bài viết không tồn tại.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $baiViet
        ]);
    }

    /**
     * Cập nhật bài viết.
     */
    public function update(Request $request, $id)
    {
        $baiViet = BaiViet::find($id);

        if (!$baiViet) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy bài viết.'
            ], 404);
        }

        $validated = $request->validate([
            'tieu_de'      => 'sometimes|max:255',
            'mo_ta_ngan'   => 'sometimes|max:500',
            'noi_dung'     => 'sometimes',
            'hinh_anh'     => 'sometimes|max:500',
            'tag'          => 'sometimes|max:255',
            'id_danh_muc'  => 'sometimes|integer',
            'tinh_trang'   => 'sometimes|in:nhap,xuat_ban'
        ]);

        $baiViet->update($validated);

        return response()->json([
            'success' => true,
            'data' => $baiViet
        ]);
    }

    /**
     * Xóa bài viết.
     */
    public function destroy($id)
    {
        $baiViet = BaiViet::find($id);

        if (!$baiViet) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy bài viết.'
            ], 404);
        }

        $baiViet->delete();

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa bài viết.'
        ]);
    }

    public function related($id)
    {
        $baiViet = BaiViet::find($id);
        if (!$baiViet) {
            return response()->json(['message' => 'Bài viết không tồn tại'], 404);
        }

        $related = BaiViet::where('id_danh_muc', $baiViet->id_danh_muc)
            ->where('id', '!=', $id)
            ->where('tinh_trang', 'xuat_ban')   // <- NÊN THÊM DÒNG NÀY
            ->limit(5)
            ->get();

        return response()->json(['data' => $related]);
    }
}
