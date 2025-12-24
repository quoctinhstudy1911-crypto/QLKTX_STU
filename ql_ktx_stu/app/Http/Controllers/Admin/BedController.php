<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bed;
use App\Models\Room;
use Illuminate\Http\Request;

class BedController extends Controller
{
    // ======= DANH SÁCH GIƯỜNG =======
    public function index(Request $request)
    {
        $roomId = $request->room_id;

        $beds = Bed::with('room')
            ->when($roomId, fn($query) => $query->where('room_id', $roomId))
            ->orderBy('room_id')
            ->orderBy('bed_code')
            ->paginate(10);

        $rooms = Room::orderBy('room_number')->get();

        return view('admin.pages.beds.index', compact('beds', 'rooms', 'roomId'));
    }

    // ======= FORM THÊM =======
    public function create()
    {
        $rooms = Room::orderBy('room_number')->get();
        return view('admin.pages.beds.create', compact('rooms'));
    }

    // ======= LƯU =======
    public function store(Request $request)
    {
        $request->validate([
          'room_id' => 'nullable',
            'bed_code'  => 'required|max:50',
            'status'    => 'required|in:available,occupied,maintenance',
            'note'      => 'nullable'
        ], [
            'bed_code.regex' => 'Mã giường phải có dạng A1–A9, B1–B9, C1–C9 (ví dụ: A1, B5, C9)'
        ]);

        // Ngăn giường trùng code trong cùng room
        if (Bed::where('room_id', $request->room_id)
               ->where('bed_code', $request->bed_code)
               ->exists()) {
            return back()->withErrors(['bed_code' => 'Mã giường đã tồn tại trong phòng này!'])
                         ->withInput();
        }

        $bed = Bed::create($request->only('room_id', 'bed_code', 'status', 'note'));

        return redirect()->route('admin.beds.index')
            ->with('success', 'Thêm giường thành công!');
    }

    // ======= FORM SỬA =======
    public function edit(Bed $bed)
    {
        $rooms = Room::orderBy('room_number')->get();
        return view('admin.pages.beds.edit', compact('bed', 'rooms'));
    }

    // ======= CẬP NHẬT =======
    public function update(Request $request, Bed $bed)
    {
        $request->validate([
            'room_id'   => 'required|exists:rooms,id',
            'bed_code'  => 'required|regex:/^[ABC][1-9]$/',
            'status'    => 'required|in:available,occupied,maintenance',
            'note'      => 'nullable'
        ], [
            'bed_code.regex' => 'Mã giường phải có dạng A1–A9, B1–B9, C1–C9 (ví dụ: A1, B5, C9)'
        ]);

        // Kiểm tra trùng code (trừ chính nó)
        $exists = Bed::where('room_id', $request->room_id)
                      ->where('bed_code', $request->bed_code)
                      ->where('id', '!=', $bed->id)
                      ->exists();

        if ($exists) {
            return back()->withErrors(['bed_code' => 'Mã giường đã tồn tại trong phòng này!'])
                         ->withInput();
        }

        $bed->update($request->only('room_id', 'bed_code', 'status', 'note'));

        return redirect()->route('admin.beds.index')
            ->with('success', 'Cập nhật giường thành công!');
    }

    // ======= XOÁ =======
    public function destroy(Bed $bed)
    {
        // xóa record con trước
        $bed->dormitoryRecords()->delete();  
        $bed->delete();

        return redirect()->route('admin.beds.index')->with('success', 'Xóa giường thành công!');
    }
}
