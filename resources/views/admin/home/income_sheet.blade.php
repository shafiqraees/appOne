
@php
    // We change the headers of the page so that the browser will know what sort of file is dealing with. Also, we will tell the browser it has to treat the file as an attachment which cannot be cached.
$filename= 'income_'.date("Y-m-d H:i:s").'.xlsx';
// header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
// header("Content-Disposition: attachment; filename='$filename'");
// header("Pragma: no-cache");
// header("Expires: 0");
header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename='$filename'");  //File name extension was wrong
header("Pragma: no-cache");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
@endphp

<div class="table-responsive mt-1">
    <table class="table">
        <thead>
        <tr>
            <th> Date</th>
            <th>No of transaction</th>
            <th>Amount</th>
            <th>Fee </th>
            <th>Remaining</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $row)
            <tr>
                <td>{{date('d M,Y',strtotime($row->created_at))}}</td>
                <td>{{$row->trsaction_count}}</td>
                <td>R {{($row->total_amount)+($row->fee)}}</td>
                <td>R {{$row->total_fee}}</td>
                <td>R {{$row->total_amount}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>



