@extends('template')
@section('aside')
    @include('partials.aside.dokter')
@endsection
@section('content-header')

@endsection

@section('content')
    <div class="col-md-6">
        <form class="card">
            <div class="card-header">
                <h3 class="card-title">Basic form</h3>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Pilih pegawai</label>
                    <select type="text" class="form-select" id="select-appointment" name="appointments_id">
                        @if($appointments)
                            @foreach($appointments as $appointment)
                                <option value="{{$appointment->id}}">{{$appointment->name}}</option>
                            @endforeach
                        @endif
                            <option value="">-- Janji temu tidak tersedia --</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label required">Name</label>
                    <div>
                        <input type="text" id="form-name" name="name" class="form-control" placeholder="nama">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label required">Alamat</label>
                    <div>
                        <input type="text" id="form-address" name="address" class="form-control" placeholder="alamat">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label required">Phone</label>
                    <div>
                        <input type="text" id="form-phone" name="phone" class="form-control" placeholder="masukkan nama">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal & Waktu</label>
                    <div>
                        <input type="datetime-local"
                               id="form-available-time"
                               class="form-fieldset @error('available_time') is-invalid @enderror"
                               name="available_time"
                        >
                        @error('available_time')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ubah status</label>
                    <div>
                        <select class="form-select" name="status" id="form-status">

                        </select>
                    </div>
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
        $(document).ready(function (){
            $('#select-appointment').on('change', function (){
                var appointmentId = this.value;

            })
        })
    </script>
@endsection
