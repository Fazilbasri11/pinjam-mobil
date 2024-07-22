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
                                    <th scope="col">Nama Peminjam</th>
                                    <th scope="col">Mobil</th>
                                    <th scope="col">Jenis</th>
                                    <th scope="col">Plat</th>
                                    <th scope="col">Warna</th>
                                    <th scope="col">Tahun</th>
                                    <th scope="col">Tgl pinjam</th>
                                    <th scope="col">Tgl kembali</th>
                                    <th scope="col">Status Konfirmasi</th>
                                    <th scope="col">Sisa</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($mobil as $pinjam)
                                    <tr>
                                        <td>{{ $pinjam->user->name }}</td>
                                        <td>{{ $pinjam->mobil->nama_mobil }}</td>
                                        <td>{{ $pinjam->mobil->merekMobil->nama_merek }}</td>
                                        <td>{{ $pinjam->mobil->plat }}</td>
                                        <td>{{ $pinjam->mobil->warna }}</td>
                                        <td>{{ \Carbon\Carbon::parse($pinjam->mobil->tahun)->format('Y') }}</td>
                                        <td>{{ $pinjam->tgl_mulai }}</td>
                                        <td>{{ $pinjam->tgl_kembali }}</td>
                                        {{-- <td>
                                            @if ($pinjam->status == 'pinjam')
                                                <span class="badge bg-label-success me-1">{{ $pinjam->status }}</span>
                                            @elseif ($pinjam->status == 'pending')
                                                <span class="badge bg-label-warning me-1">Menunggu konfirmasi</span>
                                            @endif
                                        </td> --}}
                                        <td>
                                            @if ($pinjam->status == 'pinjam')
                                                <span class="badge bg-label-success me-1">{{ $pinjam->status }}</span>
                                            @elseif ($pinjam->status == 'pending')
                                                <span class="badge bg-label-warning me-1">Menunggu konfirmasi</span>
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
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                                    id="dropdownMenuButton{{ $pinjam->id }}" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    {{ $pinjam->status }}
                                                </button>
                                                <ul class="dropdown-menu"
                                                    aria-labelledby="dropdownMenuButton{{ $pinjam->id }}">
                                                    <li><a class="dropdown-item" href="#"
                                                            onclick="updateStatus('{{ $pinjam->id }}', 'pinjam')">Setuju</a>
                                                    </li>
                                                    <li><a class="dropdown-item" href="#"
                                                            onclick="updateStatus('{{ $pinjam->id }}', 'tersedia')">Tolak</a>
                                                    </li>
                                                    <li><a class="dropdown-item" href="#"
                                                            onclick="updateStatus('{{ $pinjam->id }}', 'selesai')">Dikembalikan</a>
                                                    </li>
                                                </ul>
                                            </div>
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
                                    <th scope="col">Nama Peminjam</th>
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
                                        <td>{{ $riwayat->user->name }}</td>
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
        function updateStatus(pinjamId, status) {
            console.log(pinjamId, status);
            // Mengirim permintaan Ajax menggunakan Axios
            axios.put('/permintaan/' + pinjamId, {
                    status: status
                })
                .then(function(response) {
                    // Handle jika update berhasil
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Status berhasil diperbarui.'
                    });
                    // Misalnya, refresh tabel atau tindakan lainnya jika diperlukan
                    window.location.reload();
                })
                .catch(function(error) {
                    // Handle jika terjadi kesalahan
                    console.error(error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Gagal memperbarui status.'
                    });
                });
        }
    </script>
@endsection
