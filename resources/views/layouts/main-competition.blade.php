<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Lomba</title>
    <!-- Dashboard CSS -->
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <!-- Icon Title -->
    <link rel="icon" href="{{ asset('asset/logo.png') }}" type="image/x-icon">
    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" />
    <!-- FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
</head>

<body class="d-flex position-relative">
    @include('layouts.navbar-competition')
    @yield('container')
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/1f83e5d847.js" crossorigin="anonymous"></script>
    <!-- JQUERY -->
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(".hamburger").click(function(){
            $("#navbar").addClass("active");
        })
        $(".main-content, .nav-bot").click(function(){
            $("#navbar").removeClass("active");
        })
        function getValue(no){
            let grub = `<p class="form-limit text-start ms-4 fw-bold">KTM UMS</p>
                        <div class="input-form-file position-relative d-flex align-items-center">
                            <input type="file" name="ktm${no}" id="form-input-file" class="custom-file-input" placeholder="">
                            <!-- <span class="req position-absolute" required>*</span> -->
                        </div>`;
            let umum = `<div class="input-form position-relative">
                            <p class="label position-absolute">Asal Instansi</p>
                            <input type="text" name="agency_sp1" id="form-input" class="form-input px-4" placeholder="" required>
                            <span class="req position-absolute">*</span>
                        </div>`;
            let value = $(`#agency${no}`).val();
            let instansi;
            let file;
            if(value == 'ums'){
                instansi = 'KTM Universitas Muhammadiyah Surakarta'
                $(`#from-ums-${no}`).html(grub);
                // $("#from-ums").show();
            } else{
                instansi = 'Bukti Pembayaran'
                $(`#from-ums-${no}`).html(umum);
                // $("#from-ums").hide();
            }
            $("#change-bukti").text(instansi);
        }

        function getValue2(){
            let grub = `<p class="form-limit text-start ms-4 fw-bold">KTM UMS</p>
                        <div class="input-form-file position-relative d-flex align-items-center">
                            <input type="file" name="ktm" id="form-input-file" class="custom-file-input" placeholder="" required>
                            <!-- <span class="req position-absolute">*</span> -->
                        </div>`;
            let value = $("#instansi").val();
            let umum = `<div class="input-form position-relative">
                            <p class="label position-absolute">Asal Instansi</p>
                            <input type="text" name="agency_sp" id="form-input" class="form-input px-4" placeholder="" required>
                            <span class="req position-absolute">*</span>
                        </div>`;
            let instansi;
            let file;
            if(value == 'ums'){
                instansi = 'KTM Universitas Muhammadiyah Surakarta'
                $("#from-ums").html(grub);
                // $("#from-ums").show();
            } else{
                instansi = 'Bukti Pembayaran'
                $("#from-ums").html(umum);
                // $("#from-ums").hide();
            }
            $("#change-bukti").text(instansi);
        }

        function previewImage(){
        const image = document.querySelector('#foto');
        const imgPreview = document.querySelector('.img-preview');

        imgPreview.style.display = 'block';
        imgPreview.style.width = '200px';
        imgPreview.style.height = '175px';
        
        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);

        oFReader.onload = function(oFREvent){
            imgPreview.src = oFREvent.target.result;
        }
    }
    </script>
</body>

</html>