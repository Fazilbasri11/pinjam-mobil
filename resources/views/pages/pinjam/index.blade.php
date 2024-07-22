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
                                    <th scope="col">Status Ketersediaan</th>
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
                                            @if ($lp->status == 'pinjam')
                                                <span class="badge bg-label-danger me-1">Dipinjam</span>
                                                @php
                                                    $tgl_kembali = \Carbon\Carbon::parse($lp->tgl_kembali);
                                                    $today = \Carbon\Carbon::now();
                                                    $estimasi_hari = max(
                                                        0,
                                                        ceil($today->diffInDays($tgl_kembali, false)),
                                                    );
                                                @endphp
                                                tersedia dalam : {{ $estimasi_hari }} hari
                                            @elseif ($lp->status == 'tersedia' || is_null($lp->status))
                                                <span class="badge bg-label-success me-1">Tersedia</span>
                                            @endif
                                        </td>

                                        @if ($lp->status == 'pinjam')
                                            <td>
                                                <div class="dropdown">
                                                    <button disabled type="button"
                                                        class="btn p-0 dropdown-toggle hide-arrow"
                                                        data-bs-toggle="dropdown">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        @else
                                            <td>
                                                <a class="dropdown-item kirim-ulang" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#add-pinjam" data-id="{{ $lp->id }}"
                                                    data-nama-mobil="{{ $lp->nama_mobil }}"
                                                    data-plat="{{ $lp->plat }}" data-tgl-mulai="{{ $lp->tgl_mulai }}"
                                                    data-tgl-selesai="{{ $lp->tgl_kembali }}">
                                                    <i class="bx bx-car me-1"></i> Pinjam
                                                </a>
                                            </td>
                                        @endif
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
    @include ('pages.pinjam.modal-add')
@endsection
@section('js_custom')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var modal = document.getElementById('add-pinjam');
            modal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget; // Button that triggered the modal
                var namaMobil = button.getAttribute('data-nama-mobil');
                var plat = button.getAttribute('data-plat');
                var tglMulai = button.getAttribute('data-tgl-mulai');
                var tglSelesai = button.getAttribute('data-tgl-selesai');

                // Update the modal's content.
                modal.querySelector('.modal-body #namaMobil').value = namaMobil;
                modal.querySelector('.modal-body #plat').value = plat;
                modal.querySelector('.modal-body #tglMulai').value = tglMulai;
                modal.querySelector('.modal-body #tglSelesai').value = tglSelesai;
            });
        });
    </script>
@endsection
