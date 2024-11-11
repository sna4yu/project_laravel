@extends('layouts.app')
@section('title', __('kpi::lang.edit_indicator'))
@section('content')

@include('kpi::layouts.nav')

<!-- Content Header -->
<section class="content-header">
    <h1>@lang('kpi::lang.edit_indicator')</h1>
</section>

<!-- Main Content -->
<section class="content">
    {!! Form::model($indicator, ['route' => ['indicator.update', $indicator->id], 'method' => 'put']) !!}
    {{ csrf_field() }}

    <!-- Performance Appraisal Section -->
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-lg p-4 mb-5 bg-white rounded" style="border: 1px solid #e3e3e3; box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);">
                <h3 class="card-header bg-light" style="border-bottom: 2px solid #007bff;">Edit Indicator</h3>
                <div class="card-body">
                    <div class="form-group row justify-content-center">
                        <label for="title" class="col-sm-4 col-form-label text-right">Title <span class="text-danger">*</span></label>
                        <div class="col-sm-4">
                            <input type="text" id="title" name="title" class="form-control" value="{{ $indicator->title }}" required>
                        </div>
                    </div>
                    <div class="form-group row justify-content-center">
                        <label for="department" class="col-sm-4 col-form-label text-right">Department <span class="text-danger">*</span></label>
                        <div class="col-sm-4">
                            {{ Form::select('department', $department, $indicator->department_id, ['class' => 'form-control', 'placeholder' => 'Select Department', 'required' => true]) }}
                        </div>
                    </div>
                    <div class="form-group row justify-content-center">
                        <label for="designation" class="col-sm-4 col-form-label text-right">Designation</label>
                        <div class="col-sm-4">
                            {{ Form::select('designation', $designation, $indicator->designation_id, ['class' => 'form-control', 'placeholder' => 'Select Designation']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Technical Competencies Section -->
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-lg p-4 mb-5 bg-white rounded" style="border: 1px solid #e3e3e3; box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);">
                <h3 class="card-header bg-light" style="border-bottom: 2px solid #007bff;">Technical Competencies</h3>
                <div class="card-body">
                    <table class="table table-hover" id="technical-competencies-table">
                        <thead>
                            <tr class="bg-light">
                                <th style="width: 5%;">#</th>
                                <th style="width: 40%;">Indicator</th>
                                <th style="width: 25%;">Value</th>
                                <th style="width: 15%;">Score</th>
                                <th style="width: 10%;">Action</th>
                            </tr>
                        </thead>
                        <tbody id="technical-competencies-body">
                            @foreach ($indicator->competencies->where('type', 'technical') as $key => $competency)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td><input type="text" name="technical_indicators[{{ $key }}][name]" class="form-control" value="{{ $competency->name }}"></td>
                                    <td><input type="text" name="technical_indicators[{{ $key }}][value]" class="form-control" value="{{ $competency->value }}"></td>
                                    <td><input type="number" name="technical_indicators[{{ $key }}][score]" class="form-control form-control-sm" value="{{ $competency->score }}" placeholder="Score"></td>
                                    <td><button type="button" class="btn btn-danger btn-sm remove-row">Remove</button></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-primary btn-sm" id="add-technical-row">Add Technical Competency</button>
                </div>
            </div>
        </div>

        <!-- Behavioural Competencies Section -->
        <div class="col-md-6">
            <div class="card shadow-lg p-4 mb-5 bg-white rounded" style="border: 1px solid #e3e3e3; box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);">
                <h3 class="card-header bg-light" style="border-bottom: 2px solid #007bff;">Behavioural Competencies</h3>
                <div class="card-body">
                    <table class="table table-hover" id="behavioural-competencies-table">
                        <thead>
                            <tr class="bg-light">
                                <th style="width: 5%;">#</th>
                                <th style="width: 40%;">Indicator</th>
                                <th style="width: 25%;">Value</th>
                                <th style="width: 15%;">Score</th>
                                <th style="width: 10%;">Action</th>
                            </tr>
                        </thead>
                        <tbody id="behavioural-competencies-body">
                            @foreach ($indicator->competencies->where('type', 'behavioral') as $key => $competency)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td><input type="text" name="behavioral_indicators[{{ $key }}][name]" class="form-control" value="{{ $competency->name }}"></td>
                                    <td><input type="text" name="behavioral_indicators[{{ $key }}][value]" class="form-control" value="{{ $competency->value }}"></td>
                                    <td><input type="number" name="behavioral_indicators[{{ $key }}][score]" class="form-control form-control-sm" value="{{ $competency->score }}" placeholder="Score"></td>
                                    <td><button type="button" class="btn btn-danger btn-sm remove-row">Remove</button></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-primary btn-sm" id="add-behavioural-row">Add Behavioural Competency</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Submit Button -->
    <div class="row">
        <div class="col-xs-12 text-right">
            <div class="form-group">
                {{ Form::submit(__('messages.update'), ['class' => 'btn btn-success']) }}
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</section>

<script>
// JavaScript for adding/removing rows

document.getElementById('add-technical-row').addEventListener('click', function() {
    addCompetencyRow('technical-competencies-body', 'technical_indicators');
});

document.getElementById('add-behavioural-row').addEventListener('click', function() {
    addCompetencyRow('behavioural-competencies-body', 'behavioral_indicators');
});

function addCompetencyRow(tableBodyId, namePrefix) {
    let tableBody = document.getElementById(tableBodyId);
    let rowCount = tableBody.getElementsByTagName('tr').length;
    let newRow = `
        <tr>
            <td>${rowCount + 1}</td>
            <td><input type="text" name="${namePrefix}[${rowCount}][name]" class="form-control" placeholder="New Competency"></td>
            <td><input type="text" name="${namePrefix}[${rowCount}][value]" class="form-control" placeholder="Enter Value"></td>
            <td><input type="number" name="${namePrefix}[${rowCount}][score]" class="form-control form-control-sm" placeholder="Score"></td>
            <td><button type="button" class="btn btn-danger btn-sm remove-row">Remove</button></td>
        </tr>`;
    tableBody.insertAdjacentHTML('beforeend', newRow);
    addRemoveRowFunctionality();
}

function addRemoveRowFunctionality() {
    document.querySelectorAll('.remove-row').forEach(function(button) {
        button.addEventListener('click', function() {
            this.closest('tr').remove();
            updateRowNumbers();
        });
    });
}

function updateRowNumbers() {
    // Update row numbers for the technical competencies table
    document.querySelectorAll('#technical-competencies-table tbody tr').forEach((row, index) => {
        row.querySelector('td:first-child').textContent = index + 1;
    });

    // Update row numbers for the behavioural competencies table
    document.querySelectorAll('#behavioural-competencies-table tbody tr').forEach((row, index) => {
        row.querySelector('td:first-child').textContent = index + 1;
    });
}

addRemoveRowFunctionality();
</script>

@stop
