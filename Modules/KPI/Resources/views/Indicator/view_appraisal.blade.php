<div class="modal-dialog" role="document">
    <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title text-center" style="color: #024cd7;">View Appraisal</h4>
            <button type="button" class="close btn-dan" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        
        <!-- Modal Body -->
        <div class="modal-body" id="printableArea">
            <div class="text-center mb-4">
                <p><strong>Indicator Title:</strong> {{ $appraisalData[0]->indicator_title ?? 'N/A' }}</p>
                <p><strong>Department:</strong> {{ $appraisalData[0]->department_name ?? 'N/A' }}</p>
                <p><strong>Designation:</strong> {{ $appraisalData[0]->designation_name ?? 'N/A' }}</p>
                <p><strong>Employee Username:</strong> {{ $appraisalData[0]->employee_username ?? 'Not Available' }}</p>
            </div>

            <div class="card mb-4">
                <div class="card-header text-center" style="color: #0056b3;">
                    Technical Competencies
                </div>
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th style="text-align: center;">#</th>
                            <th style="width: 20%;">Competency Name</th>
                            <th>Value</th>
                            <th>Score</th>
                            <th>Actual Value</th>
                            <th>Actual Score (%)</th>
                            <th style="width: 40%;">Note</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $techIndex = 1; @endphp
                        @foreach($appraisalData as $score)
                            @if($score->competency_type === 'technical')
                                <tr>
                                    <td style="text-align: center;">{{ $techIndex++ }}</td>
                                    <td style="width: 20%;">{{ $score->competency_name ?? 'N/A' }}</td>
                                    <td>{{ number_format($score->expect_value, 2) ?? 'N/A' }}</td>
                                    <td>{{ number_format($score->expect_score, 2) ?? 'N/A' }}</td>
                                    <td>{{ $score->actual_value ?? 'N/A' }}</td>
                                    <td>
                                        @if($score->actual_score !== null)
                                            {{ number_format(($score->actual_score * 10), 2) }}%
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>{{ $score->note ?? 'N/A' }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card">
                <div class="card-header text-center" style="color: #0056b3;">
                    Behavioral Competencies
                </div>
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th style="text-align: center;">#</th>
                            <th style="width: 20%;">Competency Name</th>
                            <th>Value</th>
                            <th>Score</th>
                            <th>Actual Value</th>
                            <th>Actual Score (%)</th>
                            <th style="width: 40%;">Note</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $behaviorIndex = 1; @endphp
                        @foreach($appraisalData as $score)
                            @if($score->competency_type === 'behavioral')
                                <tr>
                                    <td style="text-align: center;">{{ $behaviorIndex++ }}</td>
                                    <td style="width: 20%;">{{ $score->competency_name ?? 'N/A' }}</td>
                                    <td>{{ number_format($score->expect_value, 2) ?? 'N/A' }}</td>
                                    <td>{{ number_format($score->expect_score, 2) ?? 'N/A' }}</td>
                                    <td>{{ $score->actual_value ?? 'N/A' }}</td>
                                    <td>
                                        @if($score->actual_score !== null)
                                            {{ number_format(($score->actual_score * 10), 2) }}%
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>{{ $score->note ?? 'N/A' }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" onclick="printDiv('printableArea')">Print</button>
        </div>
    </div>
</div>

<!-- JavaScript Print Function -->
<script>
function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
    $('.modal').modal('hide');

    // Redirect to KPI appraisal list page after printing
    window.location.href = '/kpi/appraisal-list'; // Update this URL based on your routing
}
</script>
