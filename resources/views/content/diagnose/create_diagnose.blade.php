@extends('template')

@section('aside')
    @include('partials.aside.dokter')
@endsection

@section('content')
    <div class="col-md-8">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="icon icon-tabler icon-tabler-check">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M5 12l5 5l10 -10"/>
                    </svg>
                </div>
                <div>
                    {{ session('success') }}
                </div>
                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="card">
            <div class="card-body">
                <h2 class="mb-4">Diagnosis Pegawai</h2>
                <h3 class="card-title">Profile Details</h3>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-label">Nama</div>
                        <p>{{ $appointment->employee->user->first_name }}</p>
                    </div>
                    <div class="col-md-6">
                        <div class="form-label">Alamat</div>
                        <p>{{ $appointment->employee->user->address }}</p>
                    </div>
                    <div class="col-md-6">
                        <div class="form-label">No Hp</div>
                        <p>{{ $appointment->employee->user->phone }}</p>
                    </div>
                </div>
                <form action="{{ route('diagnose.store', $appointment->id) }}" method="post">
                    @csrf
                    <h3 class="card-title mt-4">Diagnosis</h3>
                    <div class="mb-3">
                        <textarea name="diagnose" id="diagnosis" class="form-control" placeholder="Type something...">{{ $appointment->diagnoses->diagnosis ?? '' }}</textarea>
                    </div>
                    <h3 class="card-title mt-4">Medicines</h3>
                    <div id="medication-container">
                        <div class="row g-3 medication-row" data-index="0">
                            <div class="col-md-5 mb-3">
                                <select name="medications[0][medicine_id]" class="form-select">
                                    <option value="">Select Medication</option>
                                    @foreach($medicines as $med)
                                        <option value="{{ $med->id }}">{{ $med->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger btn-remove-medication">Remove</button>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary mt-3" id="btn-add-medication">Add Medication</button>
                    <div class="card-footer bg-transparent mt-auto">
                        <div class="btn-list justify-content-end">
                            <a href="#" class="btn">Cancel</a>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let medicationIndex = 1; // Starting index for new medication rows

            document.getElementById('btn-add-medication').addEventListener('click', function () {
                const container = document.getElementById('medication-container');
                const newRow = document.createElement('div');
                newRow.classList.add('row', 'g-3', 'medication-row');
                newRow.setAttribute('data-index', medicationIndex);

                newRow.innerHTML = `
                    <div class="col-md-5 mb-3">
                        <select name="medications[${medicationIndex}][medicine_id]" class="form-select">
                            <option value="">Select Medication</option>
                            @foreach($medicines as $med)
                                <option value="{{ $med->id }}">{{ $med->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger btn-remove-medication">Remove</button>
                    </div>
                `;

                container.appendChild(newRow);
                medicationIndex++;
            });

            document.getElementById('medication-container').addEventListener('click', function (e) {
                if (e.target && e.target.classList.contains('btn-remove-medication')) {
                    e.target.closest('.medication-row').remove();
                }
            });
        });
    </script>
@endsection
