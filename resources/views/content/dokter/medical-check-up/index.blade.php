@extends('template')
@section('aside')
    @include('partials.aside.dokter')
@endsection
@section('content')
    <div class="col-12">
        <div class="col-lg-auto d-inline-block mb-3">
        <a href="{{route('doctor.dashboard')}}" class="btn btn-secondary">Kembali</a>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Hasil Medical Record</h3>
        </div>
        <div class="card-body border-bottom py-3">
            <div class="d-flex">
                <div class="text-muted">
                    Show
                    <div class="mx-2 d-inline-block">
                        <input type="text" class="form-control form-control-sm" value="{{$medicalCheckUps->total()}}" size="3" aria-label="Invoices count">
                    </div>
                    entries
                </div>
            <x-search-form
                        action="{{route('medical-check-up.search')}}"
                        placeholder="Cari nama pegawai"
                        buttonText="Cari"
                    />
            </div>
        </div>
        <div class="table-responsive">
            <table class="table card-table table-vcenter text-nowrap datatable">
                <thead>
                    <tr>
                        <th>No Medical Record</th>
                                    <th>Nama Pegawai</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Usia</th>
                                    <th>Alamat</th>
                                    <th>Hasil MCU</th>
                    </tr>
                </thead>
                  <tbody>
                                @forelse($medicalCheckUps as $mcu)
                                    <tr>
                                        <td>{{$mcu->id}}</td>
                                        <td>{{$mcu->employee->user->first_name}} {{$mcu->employee->user->last_name}}</td>
                                        <td>{{$mcu->employee->gender}}</td>
                                        <td>{{\Carbon\Carbon::parse($mcu->employee->date_of_birth)->format('d-m-Y')}}</td>
                                        <td>{{$mcu->employee->age}}</td>
                                        <td>{{$mcu->date}}</td>
                                        <td>
                                            <a href="{{route('medical-check-up.show',$mcu->id)}}" class="btn btn-secondary">Detail Medical Check Up</a>
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                @empty
                                @endforelse
                                </tbody>
            </table>
                   <div class="card-footer d-flex align-items-center">
                <p class="m-0 text-muted">Showing {{ $medicalCheckUps->firstItem() }} to {{ $medicalCheckUps->lastItem() }} of {{ $medicalCheckUps->total() }} entries</p>
                {{ $medicalCheckUps->links() }}
        </div>
    </div>
</div>
@endsection

