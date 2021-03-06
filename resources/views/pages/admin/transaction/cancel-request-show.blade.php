@extends('layouts.admin') 
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid toNewWindow">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            Detail Transaksi {{ $item->user->name }}
        </h1>
        <a href="#!" class="btn d-print-none btn-primary print">Print</a>
    </div>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>Paket Sehat Yang Dipilih</th>
                    <td>{{ $item->health_package->package_name . ' ' . $item->title }}</td>
                </tr>
                <tr>
                    <th>Pembeli</th>
                    <td>{{ $item->user->name }}</td>
                </tr>
                <tr>
                    <th>Total Transaksi</th>
                    <td>Rp{{ $item->transaction_total }}</td>
                </tr>
                <tr>
                    <th>Status Transaksi</th>
                    <td>{{ $item->transaction_status }}</td>
                </tr>
                @if (! is_null($item->transfer_proof))
                    <tr>
                        <th>Bukti Pembayaran</th>
                        <td>
                            <a data-fslightbox="gallery" href="{{ config('app.url') . Storage::url($item->transfer_proof) }}">
                            Lihat bukti
                            </a>
                        </td>
                    </tr>
                @endif
                <tr>
                    <th>Pembelian</th>
                    <td>
                        <table class="table table-bordered">
                            <tr>
                                <th>Antrian</th>
                                <th>Hewan Peliharaan</th>
                                <th>Tanggal Pesan</th>
                                <th>Estimasi waktu datang</th>
                                <th>Estimasi waktu selesai</th>
                            </tr>

                            @foreach ($item->details as $detail)
                            <tr>
                                <td>{{ $detail->queue }}</td>
                                <td>{{ $detail->pet }}</td>
                                <td>{{ $detail->package_date }}</td>
                                <td>{{ $detail->estimation_time->format('d M Y H:i') }}</td>
                                <td>{{ $detail->finished_at->format('d M Y H:i') }}</td>
                            </tr>
                            @endforeach
                        </table>
                    </td>
                </tr>
                <tr>
                    <th>Action</th>
                    <td>
                        <a href="{{ route('transaction.cancel-request.refund', $item->id) }}" class="btn btn-success">Success Refund</a>
                        </td>
                </tr>
            </table>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fslightbox/3.0.9/index.js" integrity="sha512-2VqLVM3WCyaqUgQb2hpoWHSus021RIN0Jq0wfrLqqLh+anm1kW/H4Yw7HVu3D5W4nbdUQmAA2mqQv2JEoy+kPA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(function() {

            $(".print").click(function () {
                window.print()
            })
        });
    </script>
@endpush
