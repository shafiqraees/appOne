
@php
    // We change the headers of the page so that the browser will know what sort of file is dealing with. Also, we will tell the browser it has to treat the file as an attachment which cannot be cached.
$filename= 'marketing_'.date("Y-m-d H:i:s").'.xlsx';
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
            <th>Date</th>
            <th>Totoal Imp</th>
            <th>Male Imp</th>
            <th>Fem Imp </th>
            <th>Totoal Clicks</th>
            <th>Male Clicks</th>
            <th>Fem Clicks</th>
        </tr>
        </thead>
        <tbody>
        @php
            $totoal_imp = 0;
            $male_imp = 0;
            $female_imp = 0;
            $totoal_click = 0;
            $male_click = 0;
            $female_click = 0;
        @endphp
        @foreach($data as $row)
            <tr>
                <td>{{date('d M,Y',strtotime($row->created_at))}}</td>
                <td>{{$row->total}}</td>
                <td>{{$row->male_impression}}</td>
                <td>{{$row->female_impression}}</td>
                <td>{{$row->total_click}}</td>
                <td>{{$row->male_click}}</td>
                <td>{{$row->female_click}}</td>
                @php
                    $totoal_imp = $totoal_imp + $row->total;
                    $male_imp = $male_imp + $row->male_impression;
                    $female_imp = $female_imp + $row->female_impression;
                    $totoal_click = $totoal_click + $row->total_click;
                    $male_click = $male_click + $row->male_click;
                    $female_click = $female_click + $row->female_click;
                @endphp
            </tr>
        @endforeach
        </tbody>
        <tfoot >
        <tr>
            <th>Total</th>
            <th>{{$totoal_imp}}</th>
            <th>{{$male_imp}}</th>
            <th>{{$female_imp}}</th>
            <th>{{$totoal_click}}</th>
            <th>{{$male_click}}</th>
            <th>{{$female_click}}</th>
        </tr>
        </tfoot>
    </table>
</div>



