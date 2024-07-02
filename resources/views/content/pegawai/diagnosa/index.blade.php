@extends('template')
@section('aside')
    @include('partials.aside.pegawai')
@endsection
@section('content')
    <div class="col-12">
        <div class="col-lg-auto d-inline-block mb-3">
        <a href="{{route('pegawai.dashboard')}}" class="btn btn-secondary">Kembali</a>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Hasil Diagnosa</h3>
        </div>

        <div class="card-body border-bottom py-3">
            <div class="d-flex">
                <div class="text-muted">
                    Show
                    <div class="mx-2 d-inline-block">
                        <input type="text" class="form-control form-control-sm" value="{{$appointments->total()}}" size="3" aria-label="Invoices count">
                    </div>
                    entries
                </div>
                <x-search-diagnosa
            action="{{route('diagnosaPegawai.search')}}"
            placeholderNama="Nama dokter"
            placeholderTanggal="Tanggal diagnosa"
            buttonText="Cari"
        />
            </div>
        </div>
        <div class="table-responsive">
            <table class="table card-table table-vcenter text-nowrap datatable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Appointment Date</th>
                        <th>Nama Dokter</th>
                        <th>Status Diagnosa</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach ($appointments as $appointment)
                        <tr>
                            <td>{{ $appointment->id }}</td>
                            <td>{{ $appointment->appointment_date }}</td>
                            <td>{{ $appointment->doctor->user->first_name }} {{ $appointment->doctor->user->last_name }}.{{$appointment->doctor->speciality->name}}</td>
                            <td>
                                @if($appointment->diagnosed == true)
                                    <p>Diagnosa Sudah ada</p>
                                     <a href="{{route('pegawai.myDiagnosisDetail', $appointment->id)}}" class="btn btn-secondary">Lihat Diagnosa</a>
                                @else
                                    Maaf belum didiagnosa oleh dokter
                                @endif
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
                   <div class="card-footer d-flex align-items-center">
                <p class="m-0 text-muted">Showing {{ $appointments->firstItem() }} to {{ $appointments->lastItem() }} of {{ $appointments->total() }} entries</p>
                {{ $appointments->links() }}
        </div>
    </div>
</div>
@endsection

