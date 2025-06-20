<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;

class RoomController extends Controller
{

    public function index()
    {
        return response()->json(Room::all());
    }
    //thêm
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                'regex:/^[A-Za-z0-9\s\-]+$/',
                'unique:rooms,name'
            ],
            'type' => [
                'required',
                'string',
                'in:2D,3D,IMAX'
            ],
            'seat_count' => [
                'required',
                'integer',
                'min:1',
                'max:500'
            ],
            'status' => [
                'required',
                'integer',
                'in:0,1,2'
            ],
        ], [
            'name.regex' => 'Tên phòng chỉ được chứa chữ cái, số, khoảng trắng và dấu gạch ngang.',
        ]);


        $room = Room::create($validated);
        return response()->json([
            'message' => 'Đã tạo phòng thành công',
            'room' => $room
        ]);
    }

    //xoá
    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();
        return response()->json(['message' => 'Đã xoá phòng']);
    }

    //Cập nhật
    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);
        $validated = $request->validate([
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:100',
                'regex:/^[A-Za-z0-9\s\-]+$/',
                'unique:rooms,name,' . $id
            ],
            'type' => 'sometimes|required|string|in:2D,3D,IMAX',
            'seat_count' => 'sometimes|required|integer|min:1|max:500',
            'status' => 'sometimes|required|integer|in:0,1,2',
        ]);


        $room->update($validated);
        return response()->json([
            'message' => 'Cập nhật phòng thành công',
            'room' => $room
        ]);
    }

    //Tìm kiếm theo tên
    public function search(Request $request)
    {
        $query = Room::query();
        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        $rooms = $query->get();
        return response()->json($rooms);
    }

    //Thống kê tổng số phòng theo trạng thái
    public function statistics()
    {
        $total = Room::count();
        $active = Room::where('status', '0')->count();
        $inactive = Room::where('status', '1')->count();
        $under_maintenance = Room::where('status', '2')->count();

        return response()->json([
            'total' => $total,
            'active' => $active,
            'inactive' => $inactive,
            'under_maintenance' => $under_maintenance
        ]);
    }
}