<div class="modal fade" id="edit-mobil" tabindex="-1" role="dialog" aria-labelledby="editMobilLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit-mobil-id" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_mobil">Nama Mobil</label>
                        <input type="text" class="form-control" id="nama_mobil" name="nama_mobil">
                    </div>
                    <div class="form-group">
                        <label for="id_merek">Merek</label>
                        <select class="form-control" id="id_merek" name="id_merek">
                            @foreach ($merekMobils as $merekMobil)
                                <option value="{{ $merekMobil->id }}">{{ $merekMobil->nama_merek }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="plat">Plat</label>
                        <input type="text" class="form-control" id="plat" name="plat">
                    </div>
                    <div class="form-group">
                        <label for="warna">Warna</label>
                        <input type="text" class="form-control" id="warna" name="warna">
                    </div>
                    <div class="form-group">
                        <label for="tahun">Tahun</label>
                        <input type="date" class="form-control" id="tahun" name="tahun">
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
