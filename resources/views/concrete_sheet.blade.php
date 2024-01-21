<h2>{{strtoupper($tabledata['contact_name'])}} Weekly Bookings
</h2>
<table style="width:100%">
    <thead>
        <tr>
            <th style="font-weight:bold;width:400%">Address</th>
            <th style="font-weight:bold;width:150%">Mix</th>
            <th style="font-weight:bold;width:150%">Volume</th>
            <th style="font-weight:bold;width:150%">Time Onsite</th>
            <th style="font-weight:bold;width:150%">M2</th>
            <th style="font-weight:bold;width:400%">Placer</th>
            <th style="font-weight:bold;width:400%">Pump</th>
            <th style="font-weight:bold;width:400%">Special Instructions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tabledata['bookings'] as $key=>$val)
        <tr>
            <td style='font-weight:bold;background-color:<?php if(str_contains($tabledata['contact_name'],'Ashby')){echo "#008000;color:#FFFFFF" ;}elseif(str_contains($tabledata['contact_name'],'Allied')){echo "#0000FF;color:#FFFFFF"
                ;}elseif(str_contains($tabledata['contact_name'],'Firth')){echo "#FF0000;color:#FFFFFF"
                ;}elseif(str_contains($tabledata['contact_name'],'Ready Mix')){echo "#FFFF00" ;}else{echo "#FFFFFF" ;} ?>;'
                colspan="8">{{$key}}</td>
        </tr>
        @foreach($val as $val1)
        <tr>
            <td>{{$val1->booking->address}}</td>
            <td>{{$val1->booking->mix}}</td>
            <td>{{$val1->booking->volume}}</td>
            <td>{{$val1->booking->time_onsite}}</td>
            <td>{{$val1->booking->floor_area}}</td>
            <td>{{$val1->booking->placer->first()?->contact?->title}}</td>
            <td>{{$val1->booking->pump()->first()?->contact?->title}}</td>
            <td></td>
        </tr>
        @endforeach
        @endforeach
    </tbody>
</table>