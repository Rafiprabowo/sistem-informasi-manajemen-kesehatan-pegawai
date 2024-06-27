@extends('template')

@section('content')
    <div class="card">
                  <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs nav-fill" data-bs-toggle="tabs">
                      <li class="nav-item">
                        <a href="#tabs-home-7" class="nav-link active" data-bs-toggle="tab"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l-2 0l9 -9l9 9l-2 0" /><path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" /><path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" /></svg>
                          Pegawai</a>
                      </li>
                      <li class="nav-item">
                        <a href="#tabs-profile-7" class="nav-link" data-bs-toggle="tab"><!-- Download SVG icon from http://tabler-icons.io/i/user -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /></svg>
                          Profile</a>
                      </li>
                      <li class="nav-item">
                        <a href="#tabs-activity-7" class="nav-link" data-bs-toggle="tab"><!-- Download SVG icon from http://tabler-icons.io/i/activity -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12h4l3 8l4 -16l3 8h4" /></svg>
                          Activity</a>
                      </li>
                    </ul>
                  </div>
                  <div class="card-body">
                    <div class="tab-content">
                      <div class="tab-pane active show" id="tabs-home-7">
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
                                    <th>Data Medical Record</th>
                                    <th>Aksi</th>
                                </tr>
                              </thead>
                              <tbody>
                                @forelse($medicalCheckUps as $mcu)
                                    <tr>
                                        <td>{{$mcu->id}}</td>
                                        <td>{{$mcu->employee->user->first_name}}</td>
                                        <td>{{$mcu->employee->position}}</td>
                                        <td>{{$mcu->employee->gender}}</td>
                                        <td>{{$mcu->employee->date_of_birth}}</td>
                                        <td>{{$mcu->employee->age}}</td>
                                        <td>{{$mcu->employee->user->address}}</td>
                                        <td>
                                            @foreach($mcu->pemeriksaanMinors as $pemeriksaanMinor)
                                                <ul class="list-group-flush">
                                                <li class="list-group-item">{{$pemeriksaanMinor->name}} - Hasil : {{$pemeriksaanMinor->pivot->result}}</li>
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
                      <div class="tab-pane" id="tabs-profile-7">
                        <h4>Profile tab</h4>
                        <div>Fringilla egestas nunc quis tellus diam rhoncus ultricies tristique enim at diam, sem nunc amet, pellentesque id egestas velit sed</div>
                      </div>
                      <div class="tab-pane" id="tabs-activity-7">
                        <h4>Activity tab</h4>
                        <div>Donec ac vitae diam amet vel leo egestas consequat rhoncus in luctus amet, facilisi sit mauris accumsan nibh habitant senectus</div>
                      </div>
                    </div>
                  </div>
                </div>
@endsection
