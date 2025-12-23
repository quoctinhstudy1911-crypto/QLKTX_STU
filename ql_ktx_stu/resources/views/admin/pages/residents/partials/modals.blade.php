{{-- ===========================
⭐ MODAL: CHUYỂN PHÒNG
=========================== --}}
<div class="modal fade" id="changeRoomModal" tabindex="-1">
  <div class="modal-dialog">
    <form id="changeRoomForm" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Chuyển phòng</h5>
            <button class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
            <label>Chọn phòng</label>
            <select id="change_room_select" name="room_id" class="form-control mb-3" required>
                <option value="">-- Chọn phòng --</option>
                @foreach($rooms as $r)
                  <option value="{{ $r->id }}">{{ $r->room_number }} ({{ $r->gender_label }})</option>
                @endforeach
            </select>

            <label>Chọn giường</label>
            <select id="change_bed_select" name="bed_id" class="form-control" required>
                <option value="">-- Chọn giường --</option>
            </select>
        </div>

        <div class="modal-footer">
            <button class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
            <button class="btn btn-primary">Xác nhận</button>
        </div>
      </div>
    </form>
  </div>
</div>


{{-- ===========================
⭐ MODAL: GIA HẠN
=========================== --}}
<div class="modal fade" id="extendModal" tabindex="-1">
  <div class="modal-dialog">
    <form id="extendForm" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Gia hạn lưu trú</h5>
            <button class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
            <label>Ngày kết thúc mới</label>
            <input type="date" name="new_check_out" class="form-control" required>
        </div>

        <div class="modal-footer">
            <button class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
            <button class="btn btn-info">Gia hạn</button>
        </div>
      </div>
    </form>
  </div>
</div>


{{-- ===========================
⭐ MODAL: TRẢ PHÒNG
=========================== --}}
<div class="modal fade" id="checkoutModal" tabindex="-1">
  <div class="modal-dialog">
    <form id="checkoutForm" method="POST">
      @csrf
      <div class="modal-content">

        <div class="modal-header">
            <h5 class="modal-title">Trả phòng</h5>
            <button class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
            <label>Lý do trả / ghi chú</label>
            <textarea name="reason_leave" class="form-control"></textarea>

            <p class="text-danger mt-2">
                Khi xác nhận, giường sẽ được giải phóng và sinh viên rời KTX.
            </p>
        </div>

        <div class="modal-footer">
            <button class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
            <button class="btn btn-danger">Trả phòng</button>
        </div>

      </div>
    </form>
  </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    // ⭐ Data giường trống từ controller
    let roomBedMap = @json($roomBedMap);

    function loadBeds(roomId, selectEl) {
        selectEl.innerHTML = '<option value="">-- Chọn giường --</option>';
        let room = roomBedMap.find(r => r.id == roomId);
        if (!room) return;
        room.beds.forEach(b => {
            selectEl.innerHTML += `<option value="${b.id}">${b.code}</option>`;
        });
    }

    // ======================
    // 📌 MODAL CHUYỂN PHÒNG
    // ======================
    let changeRoomModal = document.getElementById('changeRoomModal');

    changeRoomModal.addEventListener('show.bs.modal', evt => {
        let btn = evt.relatedTarget;
        let recordId = btn.dataset.recordId;

        let oldRoom = btn.dataset.roomId;
        let form = document.getElementById('changeRoomForm');
        form.action = `/admin/residents/${recordId}/change-room`;

        let roomSelect = document.getElementById('change_room_select');
        let bedSelect  = document.getElementById('change_bed_select');

        roomSelect.value = oldRoom;
        loadBeds(oldRoom, bedSelect);
    });

    document.getElementById('change_room_select')
        .addEventListener('change', function () {
            loadBeds(this.value, document.getElementById('change_bed_select'));
        });


    // ======================
    // 📌 MODAL GIA HẠN
    // ======================
    let extendModal = document.getElementById('extendModal');

    extendModal.addEventListener('show.bs.modal', evt => {
        let btn = evt.relatedTarget;
        let recordId = btn.dataset.recordId;

        let form = document.getElementById('extendForm');
        form.action = `/admin/residents/${recordId}/extend`;
    });


    // ======================
    // 📌 MODAL TRẢ PHÒNG
    // ======================
    let checkoutModal = document.getElementById('checkoutModal');

    checkoutModal.addEventListener('show.bs.modal', evt => {
        let btn = evt.relatedTarget;
        let recordId = btn.dataset.recordId;

        let form = document.getElementById('checkoutForm');
        form.action = `/admin/residents/${recordId}/checkout`;
    });

});
</script>
