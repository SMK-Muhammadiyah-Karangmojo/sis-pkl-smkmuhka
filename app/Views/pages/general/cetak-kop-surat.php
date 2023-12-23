<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kop Surat</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/styles.css'); ?>">
    <style>
        @page {
            margin-top: 20px;
            height: 100%;
        }
    </style>
</head>
<body>
<style>
    @page {
        margin-top: 0.5cm;
        margin-bottom: 0.5cm;
        margin-left: 0.5cm;
        margin-right: 0.5cm;
    }
</style>
<?= $kop_surat->content; ?>
<table>
    <tbody>
    <tr>
        <td width="50px"></td>
        <td>
            Hal : <b><?= $hal; ?></b>
        </td>
    </tr>
    </tbody>
</table>
<table>
    <tbody>
    <tr>
        <td width="60%"></td>
        <td height="140px" valign="bottom">
            Kepada Yth.<br/>
            Bapak/Ibu <?= $instansi; ?> <strong><?= $data->name; ?></strong><br/>
            Di <?= $data->address; ?>
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>