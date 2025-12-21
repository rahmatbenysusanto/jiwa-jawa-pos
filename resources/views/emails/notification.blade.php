<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Harian Kedai Selvin</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f5f5f5; padding:20px;">

<table width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center">
            <table width="600" style="background:#ffffff; padding:20px; border-radius:6px;">

                <!-- HEADER -->
                <tr>
                    <td style="text-align:center;">
                        <h2 style="margin:0;">☕ Kedai Selvin</h2>
                        <p style="margin:5px 0;color:#666;">
                            Laporan Harian Toko
                        </p>
                        <hr>
                    </td>
                </tr>

                <!-- INFO -->
                <tr>
                    <td>
                        <p>
                            <strong>Tanggal:</strong> {{ $data['tanggal'] }} <br>
                            <strong>Diinput oleh:</strong> {{ $data['input_by'] }}
                        </p>
                    </td>
                </tr>

                <!-- LAPORAN KEUANGAN -->
                <tr>
                    <td>
                        <table width="100%" cellpadding="8" cellspacing="0" style="border-collapse:collapse;">
                            <tr style="background:#f0f0f0;">
                                <th align="left">Keterangan</th>
                                <th align="right">Nominal</th>
                            </tr>

                            <tr>
                                <td>Modal Awal Cash</td>
                                <td align="right">Rp {{ number_format($data['modal_awal']) }}</td>
                            </tr>

                            <tr>
                                <td>Cash Akhir (Penutupan)</td>
                                <td align="right">Rp {{ number_format($data['cash_akhir']) }}</td>
                            </tr>

                            <tr>
                                <td>Total Pembayaran Cash</td>
                                <td align="right">Rp {{ number_format($data['cash']) }}</td>
                            </tr>

                            <tr>
                                <td>Total Pembayaran QRIS</td>
                                <td align="right">Rp {{ number_format($data['qris']) }}</td>
                            </tr>

                            <tr>
                                <td>Total Pembayaran Debit</td>
                                <td align="right">Rp {{ number_format($data['debit']) }}</td>
                            </tr>

                            <tr style="background:#fafafa;">
                                <td><strong>Laba Kotor</strong></td>
                                <td align="right">
                                    <strong>Rp {{ number_format($data['laba_kotor']) }}</strong>
                                </td>
                            </tr>

                            <tr style="background:#e8f5e9;">
                                <td><strong>Laba Bersih</strong></td>
                                <td align="right">
                                    <strong>Rp {{ number_format($data['laba_bersih']) }}</strong>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <!-- FOOTER -->
                <tr>
                    <td style="padding-top:20px; text-align:center; color:#777; font-size:12px;">
                        Email ini dikirim otomatis oleh sistem Kedai Selvin.<br>
                        Mohon tidak membalas email ini.
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>

</body>
</html>
