@extends('template')

@section('title', 'Penjualan')

@section('content')

{{-- ADMIN --}}
<div class="card-body">
    <div class="mb-3 row text-start">
        <div class="col-auto">
            <a href="{{ url('sale/export-excel') }}" class="btn btn-info">Export Penjualan (.xlsx)</a>
        </div>
    </div>

    @if (Auth::user()->role == 'petugas')
        <div class="col-auto text-end">
            <a href="{{ route('purchases.product') }}" class="btn btn-primary">Tambah Penjualan</a>
        </div>
    @endif

    <div id="salesTable_wrapper" class="dataTables_wrapper no-footer">
        <div class="d-flex justify-content-between mb-3">
            <div>
                <label>
                    Tampilkan
                    <select name="salesTable_length" class="form-select form-select-sm">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    entri
                </label>
            </div>
            {{-- <div>
                <label>
                    Cari:
                    <input type="search" class="form-control form-control-sm" placeholder="Search...">
                </label>
            </div> --}}
        </div>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Pelanggan</th>
                    <th>Tanggal Penjualan</th>
                    <th>Total Harga</th>
                    <th>Dibuat Oleh</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($purchases as $purchase)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $purchase->member ?? 'Non Member' }}</td>
                    <td>{{ \Carbon\Carbon::parse($purchase->created_at)->format('d M Y') }}</td>
                    <td>Rp. {{ number_format($purchase->total_price ?? $purchase->total, 0, ',', '.') }}</td>
                    <td>{{ $purchase->user->name ?? 'Tidak Diketahui' }}</td>
                    <td>
                        <div class="d-flex justify-content-around">
                            <a href="{{ route('purchases.invoice', $purchase->id) }}" class="btn btn-warning">Lihat</a>
                            <a href="{{ url('sale/detail-print/print/' . $purchase->id) }}" class="btn btn-info">Unduh Bukti</a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data penjualan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
