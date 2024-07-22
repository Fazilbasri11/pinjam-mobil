<div class="modal fade" id="add-mobil" tabindex="-1" aria-labelledby="add-mobil" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add-mobil">Tambah Mobil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('dataMobil.store') }}">
                    @csrf <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_mobil">Nama Mobil</label>
                            <input type="text" class="form-control" id="nama_mobil" name="nama_mobil" required>
                        </div>
                        <div class="form-group">
                            <label for="id_merek">Merek</label>
                            <select class="form-control" id="id_merek" name="id_merek" required>
                                @foreach ($merekMobils as $merekMobil)
                                    <option value="{{ $merekMobil->id }}">{{ $merekMobil->nama_merek }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="plat">Plat</label>
                            <input type="text" class="form-control" id="plat" name="plat" required>
                        </div>
                        <div class="form-group">
                            <label for="warna">Warna</label>
                            <input type="text" class="form-control" id="warna" name="warna" required>
                        </div>
                        <div class="form-group">
                            <label for="tahun">Tahun</label>
                            <input type="date" class="form-control" id="tahun" name="tahun" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
