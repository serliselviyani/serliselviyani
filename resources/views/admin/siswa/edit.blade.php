<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style type="text/css">
    table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0px;
    }

    table,
    th,
    td {
        border: 1px solid;
    }
    </style>
</head>

<body>
    
    <h1>Edit Siswa</h1>
    <a href="{{ route('siswa.index') }}">Kembali</a><br><br>

    @if ( $errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('siswa.update', $siswa->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <h2>Data Siswa</h2>
        <label>Foto Siswa</label><br>
        <img src="{{ asset('storage/siswas/'.$siswa->image) }}" width="120px" hight="120px" alt="">
        <input type="file" name="image"  accept="image/*">
        <br><br>

        <label>NIS Siswa</label>
        <input type="text" name="nis" value="{{ old('nis', $siswa->nis) }}" required>
        <br><br>

        <label>Nama Lengkap</label><br>
        <input type="text" name="name" value="{{ old('name', $siswa->name) }}" required>
        <br><br>

        <label>Tingkat</label>
        <select name="jurusan" required>
            <option {{ 'TBSM' == $siswa->jurusan ? 'selected' : '' }} value="TBSM">TBSM</option>
            <option {{ 'TJKT' == $siswa->jurusan ? 'selected' : '' }} value="TJKT">TJKT</option>
            <option {{ 'PPLG' == $siswa->jurusan ? 'selected' : '' }} value="PPLG">PPLG</option>
            <option {{ 'DKV' == $siswa->jurusan ? 'selected' : '' }} value="DKV">DKV</option>
            <option {{ 'TOI' == $siswa->jurusan ? 'selected' : '' }} value="TOI">TOI</option>
        </select>
        <br><br>

        <label>Kelas</label><br>
        <select name="kelas" required>
            <option {{  '1' == $siswa->kelas ? 'selected' : '' }} value="1">1</option>
            <option {{  '2' == $siswa->kelas ? 'selected' : '' }} value="2">2</option>
            <option {{  '3' == $siswa->kelas ? 'selected' : '' }} value="3">3</option>
            <option {{  '4' == $siswa->kelas ? 'selected' : ' '}} value="4">4</option>
        </select>
        <br><br>

        <label>No Hp</label>
        <input type="text" name="hp" value="{{ old('hp', $siswa->hp) }}" required>
        <br><br>

        <label>Status</label>
        <select name="status" required?>
            <option {{  '1' == $siswa->status ? 'selected' : '' }} value="1">Aktif</option>
            <option {{  '0' == $siswa->status ? 'selected' : '' }} value="0">Tidak Aktif</option>
        </select>
        <br><br>

        <button type="submit">SIMPAN DATA</button>
        <button type="reset">RESET FORM</button>
    </form> 
</body>
</html>