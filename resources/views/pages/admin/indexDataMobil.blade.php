@extends('layouts.main')

@section('content')
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '{{ session('error') }}',
            });
        </script>
    @endif
    {{-- tabel konten --}}
    <div class="row">
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">{{ $title }}</h5>
                    <button id="btn-add-mobil" type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#add-mobil">Tambah Mobil</button>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Mobil</th>
                                    <th scope="col">Jenis</th>
                                    <th scope="col">Plat</th>
                                    <th scope="col">Warna</th>
                                    <th scope="col">Tahun</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($mobil as $lp)
                                    <tr>
                                        <td>{{ $lp->nama_mobil }}</td>
                                        <td>{{ optional($lp->merekMobil)->nama_merek }}</td>
                                        <td>{{ $lp->plat }}</td>
                                        <td>{{ $lp->warna }}</td>
                                        <td>{{ \Carbon\Carbon::parse($lp->tahun)->format('Y') }}</td>
                                        <td>
                                            <a href="javascript:void(0);" class="btn btn-warning btn-edit"
                                                data-id="{{ $lp->id }}"><i class="bx bx-pencil"></i></a>
                                            <form id="form-delete-{{ $lp->id }}"
                                                action="{{ route('dataMobil.destroy', $lp->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-delete"
                                                    data-id="{{ $lp->id }}"><i class="bx bx-trash"></i></button>
                                            </form>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Data tidak ditemukan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include ('pages.admin.modal-add-mobil')
    @include ('pages.admin.modal-edit-mobil')
@endsection
@section('js_custom')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Menggunakan event delegation untuk menangani klik pada tombol Hapus
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('btn-delete')) {
                    var mobilId = e.target.getAttribute('data-id');

                    // Tampilkan SweetAlert konfirmasi
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data mobil akan dihapus permanen!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Submit form jika pengguna mengonfirmasi
                            document.getElementById('form-delete-' + mobilId).submit();
                        }
                    });
                }
            });


        });
        document.addEventListener('DOMContentLoaded', function() {
            $('.btn-edit').click(function() {
                var mobilId = $(this).data('id');

                $.ajax({
                    url: '/dataMobil/' + mobilId + '/edit',
                    method: 'GET',
                    success: function(response) {
                        if (response.error) {
                            alert(response.error);
                        } else {
                            $('#edit-mobil').modal('show');
                            $('#edit-mobil #edit-mobil-id').val(mobilId);
                            $('#edit-mobil #nama_mobil').val(response.nama_mobil);
                            $('#edit-mobil #id_merek').val(response.id_merek);
                            $('#edit-mobil #plat').val(response.plat);
                            $('#edit-mobil #warna').val(response.warna);
                            $('#edit-mobil #tahun').val(response.tahun);

                            var formAction = '/dataMobil/' + mobilId;
                            $('#edit-mobil form').attr('action', formAction);
                        }
                    },
                    error: function(err) {
                        console.log(err);
                        alert('Terjadi kesalahan saat memuat data mobil.');
                    }
                });
            });
        });
    </script>
@endsection
