<?php
    session_start();

    if(!isset($_SESSION["login"])){
        header("Location:login.php");
    }
    
    require"function.php";
    
    if(isset($_POST["submit"])){
        // $foto=$_POST["fFoto"];
        $judul = $_POST["fJudul"];
        $deskripsi = $_POST["fDeskripsi"];
        $lokasifile = $_POST["flokasifile"]; 

        $namaFile = $_FILES['fFoto']['name'];
        $ukuranFile = $_FILES['fFoto']['size'];
        $error = $_FILES['fFoto']['error'];
        $tempName=$_FILES['fFoto']['tmp_name'];

        var_dump($error);
        //cek apakah tidak ada gambar yang diupload
        if($error === 4){
            echo "<script>
                    alert('pilih gambar terlebih dahulu!');
                    document.location.href='tambah.php';
                    </script>";
            return false;        
        }

        // cek apakah yang diupload adalah gambar atau tidak.
        $ektensiGambarValid = ['jpg','jpeg','png'];
        $ektensiGambar = explode('.',$namaFile);
        $ektensiGambar = strtolower(end($ektensiGambar));
        if(!in_array($ektensiGambar,$ektensiGambarValid)){
            echo"<script>
                    alert('yang anda upload bukan gambar');
                </script>";
            return  false;
        }

        //buat nama file baru
        $namaFileBaru= uniqid();
        $namaFileBaru .='.';
        $namaFileBaru .= $ektensiGambar;

        //siap upload
        move_uploaded_file($tempName,'img/'.$namaFileBaru);

        $query =  "INSERT INTO albumfoto VALUES('$id','$namaFileBaru','$judul','$deskripsi','$lokasifile')";

        mysqli_query($koneksi,$query);

        if(mysqli_affected_rows($koneksi) >0){
            echo "
                <script>
                    alert('data berhasil ditambahkan!');
                    document.location.href='admin.php';
                </script>
            ";
        }else{
            echo "
                 <script>
                    alert('data gagal ditambahkan!');
                    document.location.href='admin.php';
                 </script>
            ";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
     <link rel="stylesheet" href="css/tambah.css">
</head>
<body>
    <div class="tambah4">
    <form action="#" method="post" enctype="multipart/form-data">
         <div class="tambah1">
            <label for="foto">Foto :</label>
                
                <input type="file" name="fFoto" id="foto" />
         </div>
         <div class="tambah2">
            <label for="judul">Judul :</label>
               
             <input type="text" name="fJudul" id="judul" /> 
         <div class="tambah3">
             <label for="deskripsi">Deskripsi</label>:
            
             <textarea name="fDeskripsi" id="deskripsi" cols="30" rows="2"></textarea>  
         </div>   
         <div class="tambah5">
            <label for="lokasifile">lokasi file :</label>
               
             <input type="text" name="flokasifile" id="lokasifile" /> </div>
              <div class="sumbit">
                <button type="submit" name="submit">Tambah Data!</button>
                </div>
        
    </form>
</div>
</body>
</html>