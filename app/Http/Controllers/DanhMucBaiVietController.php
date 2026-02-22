<?php

namespace App\Http\Controllers;

use App\Models\DanhMucBaiViet;
use Illuminate\Http\Request;

class DanhMucBaiVietController
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => DanhMucBaiViet::all()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ten_danh_muc' => 'required|max:255',
            'mo_ta'        => 'nullable|max:500'
        ]);

        $dm = DanhMucBaiViet::create($validated);

        return response()->json([
            'success' => true,
            'data' => $dm
        ]);
    }

    public function show($id)
    {
        $dm = DanhMucBaiViet::find($id);

        if (!$dm) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy danh mục.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $dm
        ]);
    }

    public function update(Request $request, $id)
    {
        $dm = DanhMucBaiViet::find($id);

        if (!$dm) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy danh mục.'
            ], 404);
        }

        $validated = $request->validate([
            'ten_danh_muc' => 'sometimes|max:255',
            'mo_ta'        => 'sometimes|max:500'
        ]);

        $dm->update($validated);

        return response()->json([
            'success' => true,
            'data' => $dm
        ]);
    }

    public function destroy($id)
    {
        $dm = DanhMucBaiViet::find($id);

        if (!$dm) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy danh mục.'
            ], 404);
        }

        $dm->delete();

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa danh mục.'
        ]);
    }
}
