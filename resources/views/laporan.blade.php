<table>
    <thead>
        <tr>
            <th>Kategori</th>
            @foreach ($tanggals as $tanggal)
                <th>{{$tanggal}}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($dataKategori as $dk)
            <tr>
                <td>{{$dk->nama}}</td>
                @foreach ($recordsProfitByName[$dk->nama] as $rpn => $val)
                    @foreach($tanggals as $tanggal)
                    @if ($rpn === $tanggal)
                        <td>{{$val}}</td>    
                    @endif
                    @endforeach
                @endforeach
            </tr>
        @endforeach
            <tr>
                <td>Total Income</td>
                @foreach ($typeKategori[1] as $income => $val)
                    <td>{{$val}}</td>
                @endforeach
            </tr>
            <tr>
                <td>Total Outcome</td>
                @foreach ($typeKategori[0] as $outcome => $val)
                    <td>{{$val}}</td>
                @endforeach
            </tr>
            <tr>
                <td>Net Income</td>
                @foreach ($netIncomes as $net => $val)
                    <td>{{$val}}</td>
                @endforeach
            </tr>
    </tbody>
</table>