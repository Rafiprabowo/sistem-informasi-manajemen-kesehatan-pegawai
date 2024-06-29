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
                     <div class="ms-auto text-muted">
                        Search:
                        <div class="ms-2 d-inline-block">
                              <div class="input-group mb-2 d-flex">
                                  <form action="" method="post" class="d-flex">
                                      @csrf
                                      <input type="text" class="form-control" placeholder="Search for…">
                                   <button class="btn btn-primary mx-1" type="submit">Cari</button>
                                  </form>
                              </div>
                        </div>
                      </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table card-table table-vcenter text-nowrap datatable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Appointment Date</th>
                        <th>Nama Pegawai</th>
                        <th>Diagnosis</th>
                        <th>Obat</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach ($appointments as $appointment)
                        <tr>
                            <td>{{ $appointment->id }}</td>
                            <td>{{ $appointment->appointment_date }}</td>
                            <td>{{ $appointment->employee->user->first_name }} {{ $appointment->employee->user->last_name }}</td>
                            <td>
                                @foreach ($appointment->diagnoses as $diagnosa)
                                    {{ $diagnosa->diagnosa }}
                                @endforeach
                            </td>
                            <td>
                                <ul>
                                    @foreach ($appointment->diagnoses as $diagnosa)
                                        @foreach ($diagnosa->medicines as $medicine)
                                             <ul class="list-group">
                                                 <li class="list-group-item">{{ $medicine->name }}</li>
                                                 <li class="list-group-item">Dosis : {{$medicine->pivot->dosis_obat}}</li>
                                             </ul>
                                        @endforeach
                                    @endforeach
                                </ul>
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

