@extends('template')
@section('content-header')
    @include('partials.content-header.appointment.create')
@endsection
@if($user->role === "pegawai")
    @section('aside')
        @include('partials.aside.pegawai')
    @endsection
    @section('content')
        <div class="col-md-6">
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
            <form class="card" action="{{route('appointment.store')}}" method="post">
                @csrf
                <div class="card-header">
                    <h3 class="card-title">Form Janji Temu</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Nama" value="{{  $user->name }}">
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" placeholder="Alamat" value="{{ $user->address }}" >
                        @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="+62xx" value="{{ $user->phone}}" >
                        @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pilih Dokter</label>
                        <select class="form-select @error('doctor_id') is-invalid @enderror" name="doctor_id" id="doctor-select">
                            <option value="">-- Pilih dokter --</option>
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>{{ $doctor->user->name }}</option>
                            @endforeach
                        </select>
                        @error('doctor_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pilih Tanggal & Waktu</label>
                        <select class="form-select @error('appointment_time') is-invalid @enderror" name="appointment_time" id="schedule-select" required>
                            <!-- Options akan diisi oleh jQuery -->
                        </select>
                        @error('appointment_time')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>

        </div>
    @endsection

    @section('script')
        <script>
            $(document).ready(function() {
                // Fungsi untuk mengambil jadwal dokter
                function fetchDoctorSchedules() {
                    var doctorId = $('#doctor-select').val();
                    if (doctorId) {
                        $.ajax({
                            url: "{{ url('api/fetch-doctor-schedules') }}",
                            type: "POST",
                            data: {
                                doctor_id: doctorId,
                                _token: '{{ csrf_token() }}' // Sertakan token CSRF untuk keamanan
                            },
                            dataType: 'json',
                            success: function(result) {
                                $('#schedule-select').html('<option value="">-- Pilih jadwal --</option>');
                                $.each(result.schedules, function(key, value) {
                                    $('#schedule-select').append('<option value="' + value.available_time + '">' + value.available_time + '</option>');
                                });
                            },
                            error: function(xhr, status, error) {
                                console.log(xhr.responseText);
                                alert('Gagal memuat jadwal');
                            }
                        });
                    } else {
                        $('#schedule-select').html('<option value="">-- Pilih jadwal --</option>');
                    }
                }

                // Setiap kali dokter dipilih, panggil fetchDoctorSchedules
                $('#doctor-select').change(function() {
                    fetchDoctorSchedules();
                });
            });
        </script>


    @endsection
@endif
