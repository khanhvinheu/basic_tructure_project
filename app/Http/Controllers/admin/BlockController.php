<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\admin\Blocks;
use DB;
use Datetime;

class BlockController extends Controller
{
    public function index()
    {
        $blocks = Blocks::all();
        return response()->json($blocks);
    }
    public function getIndex(){
        $lastBlock = Blocks::orderBy('index', 'desc')->first();
        $newIndex = $lastBlock ? $lastBlock->index + 1 : 1;
        return response()->json($newIndex);
    }
    public function getLast(){
        $lastBlock = Blocks::orderBy('index', 'desc')->first();
        return response()->json($lastBlock);
    }
    //
    public function store(Request $request)
    {
        // Sử dụng Validator thủ công để bắt lỗi chi tiết hơn (nếu cần)
        $validator = Validator::make($request->all(), [
            'index' => 'required|integer',
            'timestamp' => 'required|string',
            'data' => 'required|array',
            'previousHash' => 'required|string',
            'hash' => 'required|string',
            'signature' => 'required|string',
        ]);

        // Nếu không hợp lệ, trả về lỗi kèm thông tin chi tiết
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
             // Chuyển đổi mảng `data` thành JSON trước khi lưu vào MySQL
            $validatedData = $validator->validated();
            $validatedData['data'] = json_encode($validatedData['data']);
            $lastBlock = Blocks::orderBy('index', 'desc')->first();
            $newIndex = $lastBlock ? $lastBlock->index + 1 : 1;
            // Convert ISO 8601 timestamp to MySQL DATETIME format
            $validatedData['index'] = $newIndex;

            // Thực hiện lưu trữ vào MySQL
            DB::table('blocks')->insert($validatedData);

            return response()->json([
                'message' => 'Block lưu thành công!',
            ], 201);
        } catch (\Exception $e) {
            // Bắt các ngoại lệ nếu có lỗi xảy ra
            return response()->json([
                'error' => 'Lỗi trong quá trình lưu block!',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

}
