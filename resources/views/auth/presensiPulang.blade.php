@extends('templates.login')
@section('container')
  @push('style')
    <style>
      canvas {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%; 
        height: 100%;
      }
    </style>
  @endpush
  <h1>{{ $title }}</h1>
  <video id="video" autoplay playsinline class="col-lg-12 col-md-12 col-sm-12 mx-auto"></video>
  <a href="{{ url('/') }}" class="tf-btn accent large"><i class="fas fa-arrow-left mr-2"></i>Back</a>
  @push('script')
        <script src="{{ url('/face/dist/face-api.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            let faceMatcher = undefined;

            let video = document.getElementById("video");
            let canvas = document.body.appendChild(document.createElement("canvas"));
            let ctx = canvas.getContext("2d");
            let displaySize;

            let width = 600;
            let height = 600;

            const startSteam = () => {
                navigator.mediaDevices.getUserMedia({
                    video: {facingMode: "user", width, height},
                    audio : false
                }).then((steam) => {video.srcObject = steam}).then(start);
            }

            Promise.all([
                faceapi.nets.ageGenderNet.loadFromUri("{{ url('/face/weights') }}"),
                faceapi.nets.ssdMobilenetv1.loadFromUri("{{ url('/face/weights') }}"),
                faceapi.nets.tinyFaceDetector.loadFromUri("{{ url('/face/weights') }}"),
                faceapi.nets.faceLandmark68Net.loadFromUri("{{ url('/face/weights') }}"),
                faceapi.nets.faceRecognitionNet.loadFromUri("{{ url('/face/weights') }}"),
                faceapi.nets.faceExpressionNet.loadFromUri("{{ url('/face/weights') }}")
            ]).then(startSteam);


            async function start(){
              $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });
              $.ajax({
                  datatype: 'json',
                  url: "{{ url('/ajaxGetNeural') }}",
                  data: ""
              }).done(async function(data) {
                  if(data.length > 2){
                    var json_str = "{\"parent\":" + data  + "}"
                    content = JSON.parse(json_str);
                    for (var x = 0; x < Object.keys(content.parent).length; x++) {
                      for (var y = 0; y < Object.keys(content.parent[x].descriptors).length; y++) {
                        var results = Object.values(content.parent[x].descriptors[y])
                        content.parent[x].descriptors[y] = new Float32Array(results)
                      }
                    }
                    faceMatcher = await createFaceMatcher(content);
                    onPlay();
                  }
                });
              }
              
              async function createFaceMatcher(data) {
                const labeledFaceDescriptors = await Promise.all(data.parent.map(className => {
                  const descriptors = [];
                  for (var i = 0; i < className.descriptors.length; i++) {
                    descriptors.push(className.descriptors[i]);
                  }
                  return new faceapi.LabeledFaceDescriptors(className.label, descriptors);
                }))
                return new faceapi.FaceMatcher(labeledFaceDescriptors,0.6);
              }
              
              
              async function onPlay() {
                if(faceMatcher != undefined){
                  const input = document.getElementById('video')
                  const displaySize = { width: 600, height: 600 }
                  faceapi.matchDimensions(canvas, displaySize)
                  const detections = await faceapi.detectAllFaces(input).withFaceLandmarks().withFaceDescriptors()
                  const resizedDetections = faceapi.resizeResults(detections, displaySize)
                  const results = resizedDetections.map(d => faceMatcher.findBestMatch(d.descriptor))
                  results.forEach((result, i) => {
                      const box = resizedDetections[i].detection.box
                      const drawBox = new faceapi.draw.DrawBox(box, { label: result.toString() })
                      drawBox.draw(canvas)
                      var str = result.toString()
                      rating = parseFloat(str.substring(str.indexOf('(') + 1,str.indexOf(')')))
                      str = str.substring(0, str.indexOf('('))
                      str = str.substring(0, str.length - 1)
                      if(str != "unknown"){
                        console.log(str);
                        var canvas2 = document.createElement('canvas');
                        canvas2.width = 600;
                        canvas2.height = 600;
                        var ctx = canvas2.getContext('2d');
                        ctx.drawImage(video, 0, 0, 600, 600);
                        var new_image_url = canvas2.toDataURL();
                        var img = document.createElement('img');
                        img.src = new_image_url;
                        if(rating < 0.5){
                          if(str == $("#log_name").text()){
                              match = true;load_neural
                          }
                        }
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            type : 'POST',
                            url : "{{ url('/presensi-pulang/store') }}",
                            data :  {username: str, image: img.src},
                            cache : false,
                            success: function(msg){
                                if (msg == "pulang") { 
                                  Swal.fire('Berhasil Pulang', '', 'success');
                                } else if (msg == "selesai") {
                                  Swal.fire({
                                      icon: 'error',
                                      title: 'Oops...',
                                      text: 'Anda Sudah Selesai Absen Hari Ini',
                                  });
                                } else if (msg == "noMs") {
                                  Swal.fire({
                                      icon: 'error',
                                      title: 'Oops...',
                                      text: 'Hubungi Admin Untuk Input Shift Anda',
                                  });
                                } else {
                                  Swal.fire({
                                      icon: 'error',
                                      title: 'Oops...',
                                      text: 'Tidak Ada Data User',
                                  });
                                }
                                setTimeout(function() {
                                  Swal.close();
                                }, 2000);
                            },
                            error: function(data){
                                console.log('error:' ,data);
                            }
                        })
                      }
                  })
                }
                setTimeout(() => onPlay(), 5000)
              }
            
        </script>
  @endpush
@endsection