<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Buat Buku</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }


        form {
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }
        form:hover{
            background-color:white;
            transition: background-color 1s;
            

        }

        div {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="text"] {
            width: calc(100% - 22px);
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        button {
            background-color: black;
            color: white;
            border: none;
            padding: 10px 223px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <form action="/buku" method="POST">
        @csrf
        <h1>Form Buku</h1>
        <div>
            <label for="kode_buku">Kode Buku :</label>
            <input type="text" id="kode_buku" name="kode_buku" value="{{ old('kode_buku') }}">
            @error('kode_buku')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="nama_buku">Nama Buku :</label>
            <input type="text" id="nama_buku" name="nama_buku" value="{{ old('nama_buku') }}">
            @error('nama_buku')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="penerbit_buku">Penerbit Buku:</label>
            <input type="text" id="penerbit_buku" name="penerbit_buku" value="{{ old('penerbit_buku') }}">
            @error('penerbit_buku')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="penulis_buku">Penulis Buku :</label>
            <input type="text" id="penulis_buku" name="penulis_buku" value="{{ old('penulis_buku') }}">
            @error('penulis_buku')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="tahun_terbit">Tahun Terbit :</label>
            <input type="text" id="tahun_terbit" name="tahun_terbit" value="{{ old('tahun_terbit') }}">
            @error('tahun_terbit')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
