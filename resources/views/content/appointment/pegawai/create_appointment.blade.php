@extends('template')
@section('content-header')
    @include('partials.content-header.appointment.create')
@endsection
@if($user->role === "pegawai")
    @section('aside')
        @include('partials.aside.pegawai')
    @endsection
    @section('content')
        <div class="col-lg-12">
            @if(session()->has('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                    </div>
                    <div>
                        {{session('success')}}
                    </div>
                    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                </div>
            @endif
            @if(session()->has('error'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                    </div>
                    <div>
                        {{session('error')}}
                    </div>
                    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                </div>
            @endif
              <div class="row row-cards">
                <div class="col-12">
                  <form class="card" id="createAppointmentForm" action="{{route('appointment.store')}}" method="post">
                      @csrf
                    <div class="card-body">
                      <h3 class="card-title">Form Appointment</h3>
                        <hr>
                      <div class="row row-cards">
                          <h3>Biodata pegawai</h3>
                          <input type="hidden" id="employee_id" name="employee_id" value="{{$user->employee->id}}">
                        <div class="col-sm-6 ">
                          <div class="mb-3">
                            <label class="form-label">First Name</label>
                            <input type="text" class="form-control" disabled value="{{$user->first_name}}">
                          </div>
                        </div>
                        <div class="col-sm-6 ">
                          <div class="mb-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-control" disabled value="{{$user->last_name}}">
                          </div>
                        </div>
                          <div class="col-md-6">
                          <div class="mb-3">
                            <label class="form-label">Tanggal lahir</label>
                            <input type="date" class="form-control" disabled value="{{$user->employee->date_of_birth}}">
                          </div>
                        </div>
                          <div class="col-md-6">
                          <div class="mb-3">
                            <label class="form-label">Gender</label>
                            <input type="text" class="form-control" disabled value="{{$user->employee->gender}}">
                          </div>
                        </div>
                          <div class="col-md-4 ">
                          <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <input type="text" class="form-control" disabled="" value="{{$user->address}}">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="mb-3">
                            <label class="form-label">No Hp</label>
                            <input type="text" class="form-control" disabled="" value="{{$user->phone}}">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="mb-3">
                            <label class="form-label">Jabatan</label>
                            <input type="text" class="form-control" disabled value="{{$user->employee->position }}">
                          </div>
                        </div>
                          <div class="col-md-6">
                          <div class="mb-3">
                            <label class="form-label">Medical history</label>
                            <ul>
                                <li>{{$user->employee->medical_history}}</li>
                            </ul>
                          </div>
                        </div>
                          <hr>
                          <h3>Kontak darurat</h3>
                          <div class="col-md-6">
                          <div class="mb-3">
                            <label class="form-label">Nama kontak darurat</label>
                            <input type="text" class="form-control"  disabled value="{{$user->employee->emergency_contact_name}}">
                          </div>
                        </div>
                          <div class="col-md-6">
                          <div class="mb-3">
                            <label class="form-label">Hubungan dengan kontak darurat</label>
                            <input type="text" class="form-control" disabled value="{{$user->employee->emergency_contact_relationship}}">
                          </div>
                        </div>
                           <div class="col-md-6">
                          <div class="mb-3">
                            <label class="form-label">Nomor kontak darurat</label>
                            <input type="text" class="form-control"  disabled value="{{$user->employee->emergency_contact_number}}">
                          </div>
                        </div>
                          <div class="col-md-6">
                          <div class="mb-3">
                            <label class="form-label">Alamat kontak darurat</label>
                            <input type="text" class="form-control"  disabled value="{{$user->employee->emergency_contact_address}}">
                          </div>
                        </div>
                          <hr>
                            <h3>Detail appoitnment</h3>

                         <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Pilih Berdasarkan Spesialisasi</label>
                    <select class="form-select" id="select-specialization" name="specialization_id">
                        <option value="">-- Pilih spesialisasi --</option>
                        @foreach($specializations as $specialization)
                            <option value="{{$specialization->id}}">{{$specialization->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Pilih Dokter</label>
                    <select class="form-select" id="select-doctor" name="doctor_id">
                        <option value="">--Pilih dokter--</option>
                        @if($doctors->isEmpty())
                            <option value="">--Dokter not found--</option>
                        @else
                            @foreach($doctors as $doctor)
                                <option value="{{$doctor->id}}">{{$doctor->user->first_name}} {{$doctor->user->last_name}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Pilih Tanggal & Waktu</label>
                    <select class="form-select" id="select-schedule" name="schedule_id">
                    </select>
                </div>
            </div>
            <!-- Appointment Type and Notes -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Kategori Appointment</label>
                    <select class="form-select" id="appointment_type" name="appointment_type">
                        <option value="">Pilih tipe appointment</option>
                        <option value="consultation">Konsultasi</option>
                        <option value="checkup">Checkup</option>
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3 mb-0">
                    <label class="form-label">Deskripsi Appointment</label>
                    <textarea rows="5" class="form-control" id="note" name="note" placeholder="Deskripsi appointment"></textarea>
                </div>
            </div>
                      </div>
                    </div>
                    <div class="card-footer text-end">
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
    @endsection

    @section('script')
        <script>
            $(document).ready(function() {
    var token = $("meta[name='csrf-token']").attr("content");

    $('#select-specialization').change(function (){
        fetchDoctorWithSpesialization();
    });

    $('#select-doctor').change(function (){
        fetchDoctorSchedules();
    });

    $('#createAppointmentForm').submit(function (event) {
        event.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: {
                employee_id: $('#employee_id').val(),
                doctor_id: $('#select-doctor').val(),
                schedule_id: $('#select-schedule').val(),
                appointment_type: $('#appointment_type').val(),
                note: $('#note').val(),
                _token: token
            },
            success: function (response) {
                console.log(response); // Debugging response
                       if(response.status === 'success'){
                alert('Appointment created successfully');
                // Reset form
                $('#select-doctor').val('');
                $('#select-schedule').val('');
                $('#appointment_type').val('');
                $('#note').val('');

                // Redirect after 2 seconds
                setTimeout(function() {
                    window.location.href = ''; // Ganti dengan URL tujuan
                }, 2000);
            } else {
                alert('Failed to create appointment');
            }
            },
            error: function (xhr) {
                if(xhr.status === 422){
                    let errors = xhr.responseJSON.message;
                    let errorMessages = '';
                    $.each(errors, function (key, value){
                        errorMessages += value[0] + '\n';
                    });
                    alert(errorMessages);
                } else {
                    console.log(xhr); // Log full error response
                    alert('An error occurred while creating appointment');
                }
            }
        });
    });

    function fetchDoctorWithSpesialization() {
        let specializationId = $('#select-specialization').val();
        if(specializationId){
            $.ajax({
                url: "{{ route('fetchSpecializationsWithDoctor') }}",
                type: "POST",
                dataType: 'json',
                data: {
                    speciality_id: specializationId,
                    _token: token
                },
                success: function (response) {
                    console.log(response); // Debugging response
                    if (response.success && response.data.length > 0) {
                        let selectDoctor = $('#select-doctor');
                        selectDoctor.empty();
                        selectDoctor.html('<option value="">-- Pilih dokter --</option>');
                        $.each(response.data, function (key, doctor) {
                            selectDoctor.append('<option value="' + doctor.id + '">' + doctor.first_name + ' ' + doctor.last_name + '</option>');
                        });
                    } else {
                        alert('Dokter not found');
                    }
                },
                error: function (xhr) {
                    console.log(xhr); // Log full error response
                    alert('Gagal memuat dokter');
                }
            });
        }
    }

    function fetchDoctorSchedules() {
        let doctorId = $('#select-doctor').val();
        if(doctorId){
            $.ajax({
                url: "{{ route('fetchDoctorSchedule') }}",
                type: "POST",
                dataType: 'json',
                data: {
                    doctor_id: doctorId,
                    _token: token
                },
                success: function (response) {
                    console.log(response); // Debugging response
                    if (response.success && response.data.length > 0) {
                        let selectSchedule = $('#select-schedule');
                        selectSchedule.empty();
                        selectSchedule.html('<option value="">-- Pilih jadwal --</option>');

                        $.each(response.data, function (key, schedule) {
                            selectSchedule.append('<option value="' + schedule.id + '">' + schedule.date + ' ' + schedule.start_time + ' ' + schedule.end_time + '</option>');
                        });
                    } else {
                        alert('Jadwal Not found');
                    }
                },
                error: function (xhr) {
                    console.log(xhr); // Log full error response
                    alert('Gagal memuat jadwal');
                }
            });
        }
    }
});
        </script>
    @endsection
@endif
