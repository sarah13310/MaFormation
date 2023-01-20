let photo_url = document.getElementById("photo");

        const snapshot = document.getElementById('snapshot');
        // Configure a few settings and attach camera
        Webcam.set({
            width: 150,
            height: 112.5,
            image_format: 'jpeg',
            jpeg_quality: 95
        });
        Webcam.attach('#my_camera');
        // preload shutter audio clip
        var shutter = new Audio();
        shutter.autoplay = false;
        shutter.src = "/webcamjs/shutter.ogg";
        let img_snap = "<?= $user['image_url'] ?>";

        function take_snapshot() {
            // play sound effect
            shutter.play();
            // take snapshot and get image data
            Webcam.snap(function(data_uri) {
                // display results in page
                //img_snap = data_uri;
                document.getElementById('results').innerHTML =
                    '<img style="width:150px" src="' + data_uri + '"/>';
                img_snap = data_uri;
            });
        }

        function save_snapshot() {
            photo_url.value = img_snap;
            snapshot.innerHTML = '<img style="width:200px" src="' + img_snap + '"/>';
        }

        var openFile = function(file) {
            var input = file.target;
            var reader = new FileReader();
            reader.onload = function() {
                var dataURL = reader.result;
                var output = document.getElementById('output');
                output.src = dataURL;
                img_snap = dataURL;
            };
            reader.readAsDataURL(input.files[0]);
        }