@extends('layouts.app')
@section('title', __('socialmanagement::lang.social_audit'))

@section('content')

    @includeIf('socialmanagement::layouts.nav')

    <!-- Content Header (Page header) -->
    <section class="content-header no-print">
        <h1>
            @lang('socialmanagement::lang.social_audit_create')
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        @component('components.widget', ['class' => 'box-primary'])
            <!-- Filter form -->
            <form id="filter_form" action="{{ route('social_audits.create') }}" method="GET">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::select('user_id', $users, request('user_id'), [
                                'class' => 'form-control select2',
                                'placeholder' => __('messages.please_select'),
                                'required',
                                'style' => 'width: 100%;',
                                'onchange' => 'this.form.submit()',
                            ]) !!}
                        </div>
                    </div>
                </div>
            </form>

            @if ($socialAudits->isNotEmpty())
                <form action="{{ route('social_audits.update') }}" method="POST" id="social_audit_form">
                    @csrf
                    @method('PUT')
                    <h3 class="mt-4">@lang('socialmanagement::lang.social_today_for_audit')</h3>
                    <!-- Display existing social audits -->
                    <div class="content">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>@lang('name')</th>
                                    <th>@lang('socialmanagement::lang.morning_audit')</th>
                                    <th>@lang('socialmanagement::lang.morning_posted')</th>
                                    <th>@lang('socialmanagement::lang.morning_notes')</th>
                                    <th>@lang('socialmanagement::lang.evening_audited')</th>
                                    <th>@lang('socialmanagement::lang.evening_posted')</th>
                                    <th>@lang('socialmanagement::lang.evening_notes')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($socialAudits as $audit)
                                    <tr>
                                        <td>{{ $audit->social->name }}</td>
                                        <td><a href="{{ $audit->social->link }}" target="_blank">{{ $audit->social->link }}</a></td>
                                        
                                        <td>
                                            <input type="checkbox" class="input-icheck" id="social_audit_morning_{{ $loop->index }}"
                                                name="audits[{{ $loop->index }}][social_audit_morning]" value="1"
                                                {{ $audit->social_audit_morning ? 'checked' : '' }}>
                                        </td>
                                        <td>
                                            <input type="checkbox" class="input-icheck" id="posted_morning_{{ $loop->index }}"
                                                name="audits[{{ $loop->index }}][posted_morning]" value="1"
                                                {{ $audit->posted_morning ? 'checked' : '' }}>
                                        </td>
                                        <td>
                                            <input type="text" id="social_note_morning_{{ $loop->index }}"
                                                name="audits[{{ $loop->index }}][social_note_morning]" class="form-control"
                                                value="{{ $audit->social_note_morning }}" placeholder="@lang('socialmanagement::lang.notes')">
                                        </td>
                                        <td>
                                            <input type="checkbox" class="input-icheck" id="social_audit_afternoon_{{ $loop->index }}"
                                                name="audits[{{ $loop->index }}][social_audit_afternoon]" value="1"
                                                {{ $audit->social_audit_afternoon ? 'checked' : '' }}>
                                        </td>
                                        <td>
                                            <input type="checkbox" class="input-icheck" id="posted_afternoon_{{ $loop->index }}"
                                                name="audits[{{ $loop->index }}][posted_afternoon]" value="1"
                                                {{ $audit->posted_afternoon ? 'checked' : '' }}>
                                        </td>
                                        <td>
                                            <input type="text" id="social_note_afternoon_{{ $loop->index }}"
                                                name="audits[{{ $loop->index }}][social_note_afternoon]" class="form-control"
                                                value="{{ $audit->social_note_afternoon }}" placeholder="@lang('socialmanagement::lang.notes')">
                                        </td>
                                        <!-- Hidden fields -->
                                        <input type="hidden" name="audits[{{ $loop->index }}][id]" value="{{ $audit->id }}">
                                        <input type="hidden" name="audits[{{ $loop->index }}][user_id]" value="{{ $audit->user_id }}">
                                        <input type="hidden" name="audits[{{ $loop->index }}][business_id]" value="{{ $audit->business_id }}">
                                        <input type="hidden" name="audits[{{ $loop->index }}][social_id]" value="{{ $audit->social_id }}">
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-success btn-lg mt-4">@lang('socialmanagement::lang.submit')</button>
                        </div>
                    </div>
                </form>
            @elseif ($socials->isNotEmpty())
                <form action="{{ route('social_audits.store') }}" method="POST" id="social_audit_form">
                    @csrf
                    <h3 class="mt-4">@lang('socialmanagement::lang.socials_for_user_id') {{ $user }}</h3>
                    <!-- Transactions -->
                    <div class="content">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>@lang('socialmanagement::lang.social_name')</th>
                                    <th>@lang('socialmanagement::lang.link')</th>
                                    <th>@lang('socialmanagement::lang.morning_audited')</th>
                                    <th>@lang('socialmanagement::lang.morning_posted')</th>
                                    <th>@lang('socialmanagement::lang.morning_not_posted')</th>
                                    <th>@lang('socialmanagement::lang.morning_notes')</th>
                                    <th>@lang('socialmanagement::lang.evening_audited')</th>
                                    <th>@lang('socialmanagement::lang.evening_posted')</th>
                                    <th>@lang('socialmanagement::lang.evening_not_posted')</th>
                                    <th>@lang('socialmanagement::lang.evening_notes')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($socials as $social)
                                    <tr>
                                        <td>{{ $social->name }}</td>
                                        <td><a href="{{ $social->link }}" target="_blank">{{ $social->link }}</a></td>
                                        <td>
                                            <input type="checkbox" class="input-icheck" id="social_audit_morning_{{ $loop->index }}"
                                                name="audits[{{ $loop->index }}][social_audit_morning]" value="1"
                                                {{ old('audits.' . $loop->index . '.social_audit_morning') ? 'checked' : '' }}>
                                        </td>
                                         <td>
                                            <input type="checkbox" class="input-icheck" id="posted_morning_{{ $loop->index }}"
                                                name="audits[{{ $loop->index }}][posted_morning]" value="1"
                                                {{ old('audits.' . $loop->index . '.posted_morning') ? 'checked' : '' }}>
                                        </td>
                                        <td>
                                            <input type="checkbox" class="input-icheck" id="posted_morning_{{ $loop->index }}"
                                                name="audits[{{ $loop->index }}][posted_morning]" value="0"
                                                {{ old('audits.' . $loop->index . '.posted_morning') ? 'checked' : '' }}>
                                        </td>
                                         
                                        <td>
                                            <input type="text" id="social_note_morning_{{ $loop->index }}"
                                                name="audits[{{ $loop->index }}][social_note_morning]" class="form-control"
                                                value="{{ old('audits.' . $loop->index . '.social_note_morning') }}"
                                                placeholder="@lang('socialmanagement::lang.notes')">
                                        </td>
                                        <td>
                                            <input type="checkbox" class="input-icheck" id="social_audit_afternoon_{{ $loop->index }}"
                                                name="audits[{{ $loop->index }}][social_audit_afternoon]" value="1"
                                                {{ old('audits.' . $loop->index . '.social_audit_afternoon') ? 'checked' : '' }}>
                                        </td>
                                        <td>
                                            <input type="checkbox" class="input-icheck" id="posted_afternoon_{{ $loop->index }}"
                                                name="audits[{{ $loop->index }}][posted_afternoon]" value="1"
                                                {{ old('audits.' . $loop->index . '.posted_afternoon') ? 'checked' : '' }}>
                                        </td>
                                         <td>
                                            <input type="checkbox" class="input-icheck" id="posted_afternoon_{{ $loop->index }}"
                                                name="audits[{{ $loop->index }}][posted_afternoon]" value="0"
                                                {{ old('audits.' . $loop->index . '.posted_afternoon') ? 'checked' : '' }}>
                                        </td>
                                        <td>
                                            <input type="text" id="social_note_afternoon_{{ $loop->index }}"
                                                name="audits[{{ $loop->index }}][social_note_afternoon]" class="form-control"
                                                value="{{ old('audits.' . $loop->index . '.social_note_afternoon') }}"
                                                placeholder="@lang('socialmanagement::lang.notes')">
                                        </td>
                                        <!-- Hidden fields -->
                                        <input type="hidden" name="audits[{{ $loop->index }}][user_id]" value="{{ $social->assign_to }}">
                                        <input type="hidden" name="audits[{{ $loop->index }}][business_id]" value="{{ $social->business_id }}">
                                        <input type="hidden" name="audits[{{ $loop->index }}][social_id]" value="{{ $social->id }}">
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-success btn-lg mt-4">@lang('socialmanagement::lang.submit')</button>
                        </div>
                    </div>
                </form>
            @else
                <h3 class="mt-4">@lang('socialmanagement::lang.no_social_to_audit') {{ $userId }}</h3>
            @endif

        @endcomponent
    </section>

    <!-- Add Toastr JS and CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Toastr Notification -->
    <script>
        $(document).ready(function() {
            $('#social_audit_form').on('submit', function(event) {
                event.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: $(this).serialize(),
                    success: function(response) {
                        toastr.success(response.message);
                        setTimeout(function() {
                            location.reload();
                        }, 2000); // Reload after 2 seconds to show the toastr message
                    },
                    error: function(response) {
                        toastr.error('An error occurred while submitting social audits.');
                    }
                });
            });
        });
    </script>
@endsection