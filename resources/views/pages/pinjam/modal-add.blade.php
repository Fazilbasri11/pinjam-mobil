<div class="modal fade" id="add-pinjam" tabindex="-1" role="dialog" aria-labelledby="addPinjamLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('pinjam.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="namaMobil">Nama Mobil</label>
                        <input type="text" class="form-control" id="namaMobil" name="namaMobil">
                    </div>
                    <div class="form-group">
                        <label for="plat">Plat</label>
                        <input type="text" class="form-control" id="plat" name="plat">
                    </div>
                    <div class="form-group">
                        <label for="tglMulai">Tgl Mulai</label>
                        <input type="date" class="form-control" id="tglMulai" name="tglMulai">
                    </div>
                    <div class="form-group">
                        <label for="tglSelesai">Tgl Selesai</label>
                        <input type="date" class="form-control" id="tglSelesai" name="tglSelesai">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
