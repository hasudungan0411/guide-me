$(document).ready(function(){
    var el = document.getElementById('image_demo');
    var croppie;

    $('#upload_image').on('change', function(){
        var reader = new FileReader();
        reader.onload = function(e){
            el.innerHTML = "";
            el.innerHTML = '<img id="image" src="'+e.target.result+'" />';
            croppie = new Croppie(document.getElementById('image'), {
                viewport: {width: 200, height: 80, type: 'square'},
                boundary: {width: 300, height: 300}
            });

            // Setelah gambar dimuat, buka modal cropping
            $('#uploadimageModal').modal('show');
        }
        reader.readAsDataURL(this.files[0]);
    });

    $('.crop_image').click(function(event){
        croppie.result('blob').then(function(blob){
            var formData = new FormData();
            formData.append('gambar', blob, 'gambar.png');
            formData.append('nama_kategori', $('#nama_kategori').val());

            $.ajax({
                url: 'proses_tambah_category.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#uploadimageModal').modal('hide');
                    window.location.href = 'category.php';
                },
                error: function(error) {
                    console.error(error);
                }
            });  
        });
    });
});