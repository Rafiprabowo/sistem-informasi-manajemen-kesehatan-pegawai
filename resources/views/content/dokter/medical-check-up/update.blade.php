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
                          <div class="table-responsive">
                            <table
                class="table table-vcenter card-table">
                              <thead>
                              <tr>
                                    <th>No Medical Record</th>
                                    <th>Nama Pegawai</th>
                                    <th>Jabatan</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Usia</th>
                                    <th>Alamat</th>
                                    <th>Tanggal MCU</th>
                                    <th>Hasil MCU</th>
                                  <th>Aksi</th>
                                </tr>
                              </thead>
                              <tbody>
                                    <tbody>
                                @forelse($medicalCheckUps as $mcu)
                                    <tr>
                                        <td>{{$mcu->id}}</td>
                                        <td>{{$mcu->employee->user->first_name}}</td>
                                        <td>{{$mcu->employee->position}}</td>
                                        <td>{{$mcu->employee->gender}}</td>
                                        <td>{{\Carbon\Carbon::parse($mcu->employee->date_of_birth)->format('d-m-Y')}}</td>
                                        <td>{{$mcu->employee->age}}</td>
                                        <td>{{$mcu->employee->user->address}}</td>
                                        <td>{{$mcu->date}}</td>
                                        <td>
                                            @foreach($mcu->pemeriksaanMinors as $pemeriksaanMinor)
                                                <ul class="list-group-flush">
                                                <li class="list-group-item">{{$pemeriksaanMinor->name.' | Hasil : '.$pemeriksaanMinor->pivot->result}}</li>
                                                </ul>
                                            @endforeach
                                        </td>
                                        <td>
                                            <a href="">
                                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                                Update
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                @endforelse
                                </tbody>
                            </table>
                          </div>
                        </div>
                      </div>

@endsection
