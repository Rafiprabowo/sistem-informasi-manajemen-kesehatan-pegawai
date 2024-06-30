@extends('template')
@section('content')
    <div class="col-md-6">
              <form class="card" action="{{route('dokters.store')}}" method="post">
                  @csrf
                <div class="card-header">
                  <h3 class="card-title">Tambah Dokter</h3>
                </div>
                <div class="card-body">
                    <h3 class="card-title">Buat akun dokter</h3>
                    <hr>

                    <div class="mb-3">
                        <label class="form-label">Spesialisasi</label>
                        <select id="role" name="speciality_id" class="form-select">
                            @foreach($specialities as $speciality)
                                <option value="{{$speciality->id}}">{{$speciality->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-footer text-end">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
@endsection
