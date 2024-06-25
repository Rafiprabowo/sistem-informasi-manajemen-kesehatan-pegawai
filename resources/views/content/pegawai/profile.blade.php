@extends('template')
@section('aside')
    @include('partials.aside.pegawai')
@endsection
@section('content')
        <div class="col-lg-8">
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
                  <form class="card" id="updateProfileEmployee" action="{{route('updateProfileEmployee')}}" method="post">
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
                            <input type="text" class="form-control" disabled  value="{{$user->first_name}}">
                          </div>
                        </div>
                        <div class="col-sm-6 ">
                          <div class="mb-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-control" disabled value="{{$user->last_name}}">
                          </div>
                        </div>

                          <div class="col-md-6 ">
                          <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <input type="text" class="form-control" disabled="" value="{{$user->address}}">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="mb-3">
                            <label class="form-label">No Hp</label>
                            <input type="text" class="form-control" disabled="" value="{{$user->phone}}">
                          </div>
                        </div>

                          <div class="col-md-4">
                          <div class="mb-3">
                            <label class="form-label">Tanggal lahir</label>
                            <input type="date" id="date_of_birth" name="date_of_birth" class="form-control" value="{{$user->employee->date_of_birth ?? ''}}">
                          </div>
                        </div>
                          <div class="col-md-4">
                          <div class="mb-3">
                            <label class="form-label">Gender</label>
                            <select class="form-select" id="gender" name="gender">
                                <option value="">--Pilih jenis kelamin--</option>
                                <option value="male" {{$user->employee->gender == "male" ? 'selected' : '' }}>Laki-laki</option>
                                <option value="female" {{$user->employee->gender == "female" ? 'selected' : '' }}>Perempuan</option>
                            </select>
                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="mb-3">
                            <label class="form-label">Jabatan</label>
                            <input type="text" id="position" name="position" class="form-control" value="{{$user->employee->position}}">
                          </div>
                        </div>
                          <hr>
                          <h3>Kontak darurat</h3>
                          <div class="col-md-6">
                          <div class="mb-3">
                            <label class="form-label">Nama kontak darurat</label>
                            <input type="text" value="{{$user->employee->emergency_contact_name }}" id="emergency_contact_name" name="emergency_contact_name" class="form-control" placeholder="nama kontak darurat" >
                          </div>
                        </div>
                          <div class="col-md-6">
                          <div class="mb-3">
                            <label class="form-label">Hubungan dengan kontak darurat</label>
                            <input type="text" value="{{$user->employee->emergency_contact_relationship}}" id="emergency_contact_relationship" name="emergency_contact_relationship" class="form-control" placeholder="hubungan dengan kontak darurat" >
                          </div>
                        </div>
                           <div class="col-md-6">
                          <div class="mb-3">
                            <label class="form-label">Nomor kontak darurat</label>
                            <input type="text" value="{{$user->employee->emergency_contact_number}}" id="emergency_contact_number" name="emergency_contact_number" class="form-control" placeholder="nomor kontak darurat">
                          </div>
                        </div>
                          <div class="col-md-6">
                          <div class="mb-3">
                            <label class="form-label">Alamat kontak darurat</label>
                            <input type="text" value="{{$user->employee->emergency_contact_address}}" id="emergency_contact_address" name="emergency_contact_address" class="form-control" placeholder="alamat kontak darurat">
                          </div>
                        </div>

                      </div>
                    </div>
                        <div class="card-footer d-flex justify-content-between">
                    <a href="{{route('pegawaiDashboard')}}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary ">Submit</button>
                </div>
                  </form>
                </div>
              </div>
            </div>
    @endsection
@section('script')
    <script>
        $(document).ready(function () {
    var token = $("meta[name='csrf-token']").attr("content");
    $('#updateProfileEmployee').on('submit', function (event) {
        event.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            dataType: 'json',
            data: {
                employee_id: $('#employee_id').val(),
                date_of_birth: $('#date_of_birth').val(),
                gender: $('#gender').val(),
                position: $('#position').val(),
                emergency_contact_name: $('#emergency_contact_name').val(),
                emergency_contact_relationship: $('#emergency_contact_relationship').val(),
                emergency_contact_number: $('#emergency_contact_number').val(),
                emergency_contact_address: $('#emergency_contact_address').val(),
                _token: token
            },
            success: function (response) {
                console.log(response);
                alert("Profile updated successfully!");
                $('#employee_id').val(response.data.employee_id)
                $('#date_of_birth').val(response.data.date_of_birth)
                $('#gender').val(response.data.gender)
                $('#position').val(response.data.position)
                $('#emergency_contact_name').val(response.data.emergency_contact_name)
                $('#emergency_contact_relationship').val(response.data.emergency_contact_relationship)
                $('#emergency_contact_number').val(response.data.emergency_contact_number)
                $('#emergency_contact_address').val(response.data.emergency_contact_address)
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessages = '';
                    $.each(errors, function (key, value) {
                        errorMessages += value[0] + '\n';
                    });
                    console.error('Validation errors:', errors);
                    alert(errorMessages);
                } else {
                    console.error('Unexpected error:', xhr);
                    alert("An unexpected error occurred. Please try again later.");
                }
            }
        });
    });
});

    </script>
@endsection
