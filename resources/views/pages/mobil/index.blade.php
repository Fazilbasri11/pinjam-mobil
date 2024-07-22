@extends('layouts.main')

@section('content')
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
                    <div class="table-responsive pb-5">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Mobil</th>
                                    <th scope="col">Jenis</th>
                                    <th scope="col">Plat</th>
                                    <th scope="col">Warna</th>
                                    <th scope="col">Tahun</th>
                                    <th scope="col">Tgl pinjam</th>
                                    <th scope="col">Tgl kembali</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Sisa</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($mobil as $pinjam)
                                    <tr>
                                        <td>{{ $pinjam->mobil->nama_mobil }}</td>
                                        <td>{{ $pinjam->mobil->merekMobil->nama_merek }}</td>
                                        <td>{{ $pinjam->mobil->plat }}</td>
                                        <td>{{ $pinjam->mobil->warna }}</td>
                                        <td>{{ \Carbon\Carbon::parse($pinjam->mobil->tahun)->format('Y') }}</td>
                                        <td>{{ $pinjam->tgl_mulai }}</td>
                                        <td>{{ $pinjam->tgl_kembali }}</td>
                                        <td>
                                            @if ($pinjam->status == 'pinjam')
                                                <span class="badge bg-label-success me-1">{{ $pinjam->status }}</span>
                                            @elseif ($pinjam->status == 'pending')
                                                <span class="badge bg-label-warning me-1">Menunggu konfirmasi atasan</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($pinjam->status == 'pinjam')
                                                @php
                                                    $tglKembali = \Carbon\Carbon::parse($pinjam->tgl_kembali);
                                                    $today = \Carbon\Carbon::now();
                                                    $sisaHari = $today->diffInDays($tglKembali, false);
                                                @endphp
                                                @if ($sisaHari <= 0)
                                                    <span class="badge bg-label-danger me-1">0 hari</span>
                                                @else
                                                    {{ ceil($sisaHari) }} hari
                                                @endif
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if ($pinjam->status == 'pinjam')
                                                <a class="dropdown-item kirim-ulang" href="#"
                                                    onclick="kembalikanPeminjaman({{ $pinjam->id }})">
                                                    <i class="bx bx-car me-1"></i> Kembalikan
                                                </a>
                                            @else
                                                <div>
                                                    <a class="dropdown-item delete-laporan" href="#"
                                                        onclick="batalkanPeminjaman({{ $pinjam->id }})">
                                                        <i class="bx bx-trash me-1"></i> Batalkan
                                                    </a>
                                                </div>
                                            @endif
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
    {{-- tabel riwayat --}}
    <div class="row">
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Riwayat</h5>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="table-responsive pb-5">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Mobil</th>
                                    <th scope="col">Jenis</th>
                                    <th scope="col">Plat</th>
                                    <th scope="col">Warna</th>
                                    <th scope="col">Tahun</th>
                                    <th scope="col">Tgl pinjam</th>
                                    <th scope="col">Tgl kembali</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($riwayats as $riwayat)
                                    <tr>
                                        <td>{{ $riwayat->mobil->nama_mobil }}</td>
                                        <td>{{ $riwayat->mobil->merekMobil->nama_merek }}</td>
                                        <td>{{ $riwayat->mobil->plat }}</td>
                                        <td>{{ $riwayat->mobil->warna }}</td>
                                        <td>{{ \Carbon\Carbon::parse($riwayat->mobil->tahun)->format('Y') }}</td>
                                        <td>{{ $riwayat->tgl_mulai }}</td>
                                        <td>{{ $riwayat->tgl_kembali }}</td>
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
@endsection
@section('js_custom')
    <script>
        function batalkanPeminjaman(id) {
            console.log("ID yang diklik:", id);
            Swal.fire({
                title: 'Konfirmasi Pembatalan',
                text: 'Apakah Anda yakin ingin membatalkan peminjaman ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Batalkan!'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('/pinjam/' + id, {
                            data: {
                                _method: 'DELETE' // Mengirim _method sebagai bagian dari body request
                            }
                        })
                        .then((response) => {
                            Swal.fire(
                                'Berhasil!',
                                response.data.message,
                                'success'
                            );
                            // Lakukan refresh atau tindakan lainnya jika diperlukan
                            window.location.reload();
                        })
                        .catch((error) => {
                            console.error(error);
                            Swal.fire(
                                'Oops...',
                                'Terjadi kesalahan saat membatalkan peminjaman.',
                                'error'
                            );
                        });
                }
            });
        }



        function kembalikanPeminjaman(id) {
            Swal.fire({
                title: 'Konfirmasi Pengembalian',
                text: 'Apakah Anda yakin ingin mengembalikan mobil ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Kembalikan!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirim permintaan update ke backend menggunakan Axios
                    axios.post('/mobil/' + id, {
                            _method: 'PUT' // Menambahkan _method dengan nilai PUT
                        })
                        .then((response) => {
                            Swal.fire(
                                'Berhasil!',
                                'Mobil berhasil dikembalikan.',
                                'success'
                            );
                            // Lakukan refresh atau tindakan lainnya
                            window.location.reload();
                        })
                        .catch((error) => {
                            // Handle error jika diperlukan
                            console.error(error);
                            Swal.fire(
                                'Oops...',
                                'Terjadi kesalahan saat mengembalikan mobil.',
                                'error'
                            );
                        });
                }
            });
        }
    </script>
@endsection
