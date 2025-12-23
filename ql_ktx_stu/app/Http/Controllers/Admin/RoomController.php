<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class RoomController extends Controller
{
    // DANH SÁCH PHÒNG
    public function index(Request $request)
    {
        $keyword = $request->search;

        $rooms = Room::when($keyword, function ($query, $keyword) {
            return $query->where('room_number', 'like', "%$keyword%");
        })->paginate(10);

        return view('admin.pages.rooms.index', compact('rooms', 'keyword'));
    }

    // FORM THÊM PHÒNG
    public function create()
    {
        return view('admin.pages.rooms.create');
    }

    // LƯU PHÒNG
    public function store(Request $request)
    {
        $request->validate([
        'room_number' => [
            'required',
            'unique:rooms',
            'regex:#^P([1-9]|10)$#i',
        ],

        'gender' => 'required',
            'capacity' => [
                'required',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) use ($request) {
                    $type = $request->room_type;
                    if ($type === 'VIP' && $value > 30) {
                        $fail('Sức chứa tối đa cho phòng VIP là 30 giường.');
                    }
                    if ($type !== 'VIP' && $value > 27) {
                        $fail('Sức chứa tối đa mỗi phòng là 27 giường (3 dãy × 3 cụm × 3 giường)');
                    }
                },
            ],
        'floor' => 'required|in:1,2',
        'room_type' => 'required|in:Thường,VIP,Đặc biệt',
        'area' => 'nullable|numeric',
        'description' => 'nullable|string',
    ], 
    [
        'room_number.regex' => 'Số phòng phải có dạng P1 đến P10 (ví dụ: P1, P5, P10)',
        'floor.in' => 'Tầng chỉ được chọn 1 hoặc 2',
            //'capacity.max' => 'Sức chứa tối đa mỗi phòng là 27 giường (3 dãy × 3 cụm × 3 giường)',
        'room_type.in' => 'Loại phòng chỉ có thể là: Thường, VIP, Đặc biệt',
    ]
);

        $room = Room::create([
            'room_number' => $request->room_number,
            'gender' => $request->gender,
            'capacity' => $request->capacity,
            'floor' => $request->floor,
            'area' => $request->area,
            'room_type' => $request->room_type,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.rooms.index')->with('success', 'Thêm phòng thành công!');
    }

    // FORM SỬA
    public function edit(Room $room)
    {
        return view('admin.pages.rooms.edit', compact('room'));
    }

    // CẬP NHẬT
    public function update(Request $request, Room $room)
    {
            $request->validate([
            'room_number' => [
                'required',
                Rule::unique('rooms', 'room_number')->ignore($room->id),
                'regex:/^P([1-9]|10)$/i',
            ],
            'gender'      => 'required',
                'capacity'    => [
                    'required',
                    'integer',
                    'min:1',
                    function ($attribute, $value, $fail) use ($request) {
                        $type = $request->room_type;
                        if ($type === 'VIP' && $value > 30) {
                            $fail('Sức chứa tối đa cho phòng VIP là 30 giường.');
                        }
                        if ($type !== 'VIP' && $value > 27) {
                            $fail('Sức chứa tối đa mỗi phòng là 27 giường (3 dãy × 3 cụm × 3 giường)');
                        }
                    },
                ],
            'floor'       => 'required|in:1,2',
            'room_type'   => 'required|in:Thường,VIP,Đặc biệt',
            'area'        => 'nullable|numeric',
            'description' => 'nullable|string',
        ], [
            'room_number.regex' => 'Số phòng phải có định dạng P1 đến P10 (ví dụ: P1, P5, P10)',
            'floor.in'          => 'Tầng chỉ được chọn 1 hoặc 2',
                //'capacity.max' => 'Sức chứa tối đa mỗi phòng là 27 giường (3 dãy × 3 cụm × 3 giường)',
            'room_type.in' => 'Loại phòng chỉ có thể là: Thường, VIP, Đặc biệt',
        ]);

        $room->update([
            'room_number' => $request->room_number,
            'gender' => $request->gender,
            'capacity' => $request->capacity,
            'floor' => $request->floor,
            'area' => $request->area,
            'room_type' => $request->room_type,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.rooms.index')->with('success', 'Cập nhật thành công!');
    }

    // XOÁ
    public function destroy(Room $room)
    {
        // Nếu còn giường trong phòng
        if ($room->beds()->count() > 0) {
            return back()->with('error', 'Không thể xoá phòng vì còn giường liên kết.');
        }

        // Nếu giường đã nằm trong lịch sử lưu trú
        if (\DB::table('dormitory_records')->whereIn('bed_id', $room->beds()->pluck('id'))->exists()) {
            return back()->with('error', 'Không thể xoá phòng vì đã có sinh viên lưu trú trong phòng này.');
        }

        $room->delete();

        return redirect()
            ->route('admin.rooms.index')
            ->with('success', 'Xoá phòng thành công!');
    }
}
