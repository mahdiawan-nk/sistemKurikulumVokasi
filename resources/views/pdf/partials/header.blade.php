<table width="100%" style="border-collapse: collapse; font-size: 11px;" border="1" cellpadding="5">
    <tr>
        {{-- LOGO --}}
        <td rowspan="4" width="15%" align="center" valign="middle">
            <img src="{{ asset('images/logo-polkam.png') }}" alt="Logo Politeknik Kampar"
                style="width:75px; height:75px;">
        </td>

        {{-- TITLE ATAS --}}
        <td rowspan="2" width="55%" align="center" valign="middle">
            <strong style="font-size:18px;">POLITEKNIK KAMPAR</strong>
        </td>

        {{-- META --}}
        <td width="15%">Nomor</td>
        <td width="15%">: Fm-Adm-011</td>
    </tr>

    <tr>
        <td>Tanggal</td>
        <td>: {{ now()->format('d F Y') }}</td>
    </tr>

    <tr>
        {{-- TITLE BAWAH --}}
        <td rowspan="2" align="center" valign="middle">
            <strong style="font-size:18px;">FORM MUTU</strong>
        </td>

        <td>Revisi</td>
        <td>: 0</td>
    </tr>

    <tr>
        <td>Halaman</td>
        <td>
            :
            <script type="text/php">
                if (isset($pdf)) {
                    echo $PAGE_NUM . ' dari ' . $PAGE_COUNT;
                }
            </script>
        </td>
    </tr>
</table>
