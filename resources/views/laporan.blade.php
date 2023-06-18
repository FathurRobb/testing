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
        @foreach ($namas as $nama)
            <tr>
                <td>{{$nama}}</td>
                @foreach ($recordsProfitByName[$nama] as $rpn => $val)
                    @foreach($tanggals as $tanggal)
                    @if ($rpn === $tanggal)
                        <td>{{$val}}</td>    
                    @endif
                    @endforeach
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>