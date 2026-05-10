@if($row->approved_status == 'pending')
    <span class="badge bg-warning">Pending</span>
@elseif($row->approved_status == 'approved')
    <span class="badge bg-success">Approved</span>
@elseif($row->approved_status == 'rejected')
    <span class="badge bg-danger">Rejected</span>
@endif