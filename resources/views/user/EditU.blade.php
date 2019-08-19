@extends('layouts.admin')

@section('content')

@include('layouts.common.errors')

<!--form for profil user(without webcam-->

<form action="EditUserConf/{{ $share->id }}" method="POST" enctype="multipart/form-data">
    @method('put')
    @csrf
    <label for="/task">Name</label> : <input type="text" name="Name" value={{ $share->name }}><br/><br/>
    <label for="/task">Email</label> :<input type="text" name="Email" value={{ $share->email }}><br/><br/>
	
	@if (Auth::user()->isAdmin())
	<label for="/task">Type</label> :<select name="type">
											<option value="2"{{ !$share->isAdmin() ? 'selected' : '' }}>Default</option>
											<option value="1"{{ $share->isAdmin() ? 'selected' : '' }}>Admin</option>
									</select> <br/><br/>
	@endif
	<input type="submit" name="submit" value="Submit"/>
</form>


<!--Webcam code-->

		<!--We display the 5 videos-->
		@for ($i = 1; $i < 6; $i++)
			<h2>Video n°{{$i}}</h2>
			<?php
				if($i==1)
				{
					$vid='VideoName';
				}
				else
				{
					$vid='VideoName'.$i;
				}
				$pathVid=$share->$vid;
		?>
		
		<!--for the admin(user list)-->
		<!--the admin can only delete the video-->
		 @if (Auth::user()->isAdmin() and Auth::user()->id != $share->id)
			
			 @if ($pathVid != NULL) <!--If video exist-->
				<video width="640" height="360" controls> <source src="{{ URL::to($pathVid)}}" type="video/webm"> <br/></video>
				
				<form onclick="return confirm('Are sure you want to delete this video ?')" action="deleteVid/{{$pathVid}}" method="POST" enctype="multipart/form-data">
				@method('delete')
				@csrf
				<input id="del" type="hidden" name="del" value="{{$share->VideoName}}"/>
				<input id="submit" type="submit" name="submit" value="Delete the video"/>
				</form>
			@else
				<h3>No available</h3>
			@endif
			
			<!--For the user-->
			<!--he can generate and delete video-->
			@else
				
			<!--if there is a no videoFile-->
			<div id="Display{{$i}}">		<!-- First div to hide the part after-->	
				@if ($pathVid == NULL)	
					<h2><button onclick="doGetUserMedia({{$i}})" id="btnCam{{$i}}">Add a video from your webcam to profile</button><br/></h2>
					<p>No video available</p>
						<div id="myDIV{{$i}}"><!-- 2nd div to display the next part if the user want take video-->	

							<p><button id="btnStart{{$i}}">START RECORDING</button><br/>
							<button id="btnStop{{$i}}">STOP RECORDING</button></p>
							<button id="StopCamera{{$i}}">Switch off the webcam</button><!--when the user switch on his webcam, we create a button to switch off the camera-->
		
							<p id="Text{{$i}}"><p><span id="timer{{$i}}"></span><br/><!--We display a countdown-->
        
							<video id="video{{$i}}" controls></video>	
		
							<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
							<!--Form to store the recording video-->
							<form action="uploadVid/{{$share->id }}" method="POST" enctype="multipart/form-data">
								@method('put')
								@csrf
								<input id="VideoNb{{$i}}" name="VideoNb{{$i}}" type="hidden" value ={{$i}}><!--Input to know the video number-->					
								<input id="DataVideo{{$i}}" type="hidden" name="DataVideo{{$i}}" value=""/><!--Input to store the video-->
							</form>
							<input id="upload{{$i}}" type="submit" value="Upload"/>
		 
							<input id="download{{$i}}" type="submit" value="Download"/><br/>
						</div>
		 
			</div>		
			


			<!--We display this part when the user uploading the video-->
			<div id="Vid{{$i}}"></div>	<!--This div to show the recording video-->
			<div id="dispV{{$i}}"></div>
			<!--Loading bar-->
			<div id="myProgress{{$i}}">
				<div id="myBar{{$i}}"></div>
			</div>
			 <div id="testTime"></div>
			<!--The form to delete video will be only display when the uploading of video is finished-->
				<div id="DisplayT{{$i}}">
					<form id="deleteForm{{$i}}" onclick="return confirm('Are sure you want to delete this video ?')" action="deleteVid/{{$pathVid}}" method="POST" enctype="multipart/form-data">
					@method('post')
					@csrf
					<input id="submit" type="submit" name="submit" value="Delete the video"/>
					</form>	
				</div>

			<!--if there is a videoFile-->
			<!--We display the video with the form to delete it-->
			@else
			<video width="640" height="360" id="video{{$i}}" controls> <source src="{{ URL::to($pathVid)}}" type="video/webm"></video><br/>
			<form id="testDel{{$i}}" onclick="return confirm('Are sure you want to delete this video ?')" action="deleteVid/{{$pathVid}}" method="POST" enctype="multipart/form-data">
				@method('post')
				@csrf
				<input id="submit" type="submit" value="Delete the video"/>
			</form>
			@endif	
				
			<div id="dispV{{$i}}">			
			</div>	
			<div id="myDIV{{$i}}">			
			</div>	
			<div id="DisplayT{{$i}}">
			</div>
		@endif
@endfor


    <script>
	

	//We ony display what we want
	for (i=1; i<6; i++)
	{
		var x = document.getElementById("myDIV"+i+"");
		x.style.display = "none";
		var x4=document.getElementById("dispV"+i+"");
		x4.style.display = "none";
		var x3 = document.getElementById("DisplayT"+i+"");
		x3.style.display = "none";
		 $("#Vid"+i+'').css("display", "none");
	 $("#myProgress"+i+'').css("display", "none");
	}	
	
	
	
	//This is counter to avoid the problem of timer when the user click more than one time on "add video button"
	var cd = [0, 0, 0, 0, 0, 0];
	var confCam = false;
	
	
	//function to display,record and upload video
	function doGetUserMedia(i) {// "i" is the number of the video
	
	//if first time user click on "add video" button
	if(cd[i]==0)
	{
		if(confCam == false)//We ask permission
		{
			var validation=confirm("Will you allow us to use your microphone and camera ?");
			if (validation == true) {
				confCam = true;
		}}
		if(confCam == true){
			
		/*	//First we create the button to switch off the camera
			var buttonStop = document.createElement("BUTTON");   // Create a <button> element
			buttonStop.innerHTML = "Switch off the webcam";                   // Insert text
			document.getElementById("StopCamera"+i).appendChild(buttonStop);*/

			//parameter
			let constraintObj = { 
            audio: true,
            video: { 
                facingMode: "user", 
                width: { min: 320, ideal: 640, max: 860 },
                height: { min: 240, ideal: 360, max: 540 } 
            } 
        }; 
        
        //handle older browsers that might implement getUserMedia in some way
		//wait the user click on the button
			
        if (navigator.mediaDevices === undefined) {
            navigator.mediaDevices = {};
            navigator.mediaDevices.getUserMedia = function(constraintObj) {
                let getUserMedia = navigator.webkitGetUserMedia || navigator.mozGetUserMedia;
                if (!getUserMedia) {
                    return Promise.reject(new Error('getUserMedia is not implemented in this browser'));
                }
                return new Promise(function(resolve, reject) {
                    getUserMedia.call(navigator, constraintObj, resolve, reject);
                });

            }
        }else{
            navigator.mediaDevices.enumerateDevices()
            .then(devices => {
                devices.forEach(device=>{
                    console.log(device.kind.toUpperCase(), device.label);
           
                })
            })
            .catch(err=>{
                console.log(err.name, err.message);
            })
        }
		
        navigator.mediaDevices.getUserMedia(constraintObj)
        .then(function(mediaStreamObj) {
			
			cd[i]=1;//In the case the user clicks another time on the "add video" button (for the timer)	
			//We diplay the recording video with the button start and stop
			var x = document.getElementById("myDIV"+i+"");
			if (x.style.display === "none") {
				x.style.display = "block";
			}
			
			let comptStart=0;//compteur=counter to start recording
			let comptStop=0;//compteur=counter to stop recording
			
			//function to display the webcam video
			function letVideo()
			{
				//connect the media stream to the first video element
				let video = document.getElementById('video'+i+'');
				if ("srcObject" in video) {
					video.srcObject = mediaStreamObj;
				} else {
					//old version
					video.src = window.URL.createObjectURL(mediaStreamObj);
				}
				
				video.onloadedmetadata = function(ev) {
					//show in the video element what is being captured by the webcam
				video.play();
				};
			}
			
			letVideo();

            
            //add listeners for saving video/audio
            let start = document.getElementById('btnStart'+i+'');
            let stop = document.getElementById('btnStop'+i+'');
			let stopCamera = document.getElementById('StopCamera'+i+'');
			let blobb = document.getElementById('upload'+i+'');
			let vidSave = document.getElementById('video'+i+'');
            let mediaRecorder = new MediaRecorder(mediaStreamObj);
            let chunks = [];
			
			//Counter camera
			let countCam=0;
			
	
            //When we click on start
            start.addEventListener('click', (ev)=>{
				
				if(countCam==1)
				{
					alert("Sorry, you switch off your camera, we cannot record a new video")
				}
				else
				{
				
					var r=confirm("Are you ready to take a video ?");
					if (r == true) {
						if(comptStart==1)//to avoid problem if recording, and to avoid problem if user want upload video without start to record
						{
							letVideo();
						}
						comptStart=1;
						comptStop=0;//counter, the user cannot upload the video when he started to record a new video
						mediaRecorder.start();
						console.log(mediaRecorder.state);
						var milliSeconds = 180000;//3 minute
						document.getElementById('timer'+i+'').innerHTML =180;
						document.getElementById('Text'+i+'').innerHTML ="Time left : ";
						startTimer();//we begin the timer
						setTimeout(function() {
							stopRec();

						}, milliSeconds);
					}
				}
			})
			
			//When we click on stop
            stop.addEventListener('click', (ev)=>{
				if(countCam==1)
				{
					alert("Sorry, you switch off your camera, we cannot record a new video")
				}
				else
				{
					stopRec();
				}
            })
			
			//Countdown of 1 minute
			function startTimer() {	
				var presentTime = document.getElementById('timer'+i+'').innerHTML-1;
				if(presentTime >= 0)
				{
					document.getElementById('timer'+i+'').innerHTML = presentTime;
					setTimeout(startTimer, 1000);
				}
			}			
			//function to stop recording
			function stopRec(){
				if(comptStart==1)
				{
					comptStop = 1;
					document.getElementById('timer'+i+'').innerHTML =0;//stop the timer
					mediaRecorder.stop();
					console.log(mediaRecorder.state);
					// release camera
					document.getElementById('video'+i+'').srcObject = null;
				}
				else
				{
					alert("You must start the video before stop it");
				}
			}
			
			//When we click on start
            stopCamera.addEventListener('click', (ev)=>{
				
				if(countCam==0)
				{
				var r=confirm("Do you want to switch off the camera ?");
				if (r == true) {
					if((comptStart == 1)&(comptStop == 0))
					{
						alert("You need to stop the recording before to switch off the camera");
					}
					else
					{
						mediaStreamObj.getTracks()[0].stop();
						mediaStreamObj.getTracks()[1].stop();
						document.getElementById('video'+i+'').srcObject = null;
						countCam=1;
					}
				}
				}
				else
				{
					alert("You already switch off the camera!");
				}
			})

			
			
			//We create the blob(video file)
            mediaRecorder.ondataavailable = function(ev) {
                chunks.push(ev.data);
            }
			var tempVideoEl = document.createElement('video');
			let blob;
			blob=null;
            mediaRecorder.onstop = (ev)=>{
                blob = new Blob(chunks, { 'type' : 'video/mp4;' });
                chunks = [];
                let videoURL = window.URL.createObjectURL(blob);
                vidSave.src = videoURL;
				
				tempVideoEl.src = window.URL.createObjectURL(blob);
					
            }
			
			//if the user clicks on download button
			$('#download'+i+'').on('click', function() {
				
				download(blob);
			
			})
			
			//function to download
			function download(blob){
				if((comptStart == 1)&(comptStop == 1))
				{
					alert("You are downloadind a video, it doesn't mean you are downloading AND uploading the video on the server, thanks for your understanding");
					// uses the <a download> to download a Blob
					let a = document.createElement('a'); 
					a.href = URL.createObjectURL(blob);
					a.download = 'MyVideo'+i+'.webm';
					document.body.appendChild(a);
					a.click();
				}
				else
				{
					alert("You need to start and stop recording the video before to upload it, thanks for your understanding")
				}
			}	
		
		var elem = document.getElementById("myBar"+i+"");
		
		function changeSource(url) {
		var videlem = document.createElement("video");
		videlem.setAttribute("width", "640");
		videlem.setAttribute("height", "360");
		videlem.setAttribute("controls", "controls");
		sourceV = 'http://localhost/blog/public/'+url;
		videlem.setAttribute("src", sourceV);
		console.log(sourceV);
		document.getElementById("dispV"+i+'').appendChild(videlem);
		var x2 = document.getElementById("Vid"+i+"");
		x2.style.display = "none";
		x2=document.getElementById("dispV"+i+"");
		x2.style.display = "block";
		
		}
		
		let VideoTime = 0;
		function getFinishCompression(VideoTime)
		{
			var vid = tempVideoEl.duration-0.009;
			console.log("videotime :"+vid);
			let data;
			$.ajax({
						 type        : 'get', // define the type of HTTP verb we want to use (GET for our form)
						contentType: 'application/json; charset=utf-8',
						url: '{{route("progressFF") }}',
						data: data,
						cache: false, 
						async : false,
						dataType    : 'json'
						})
						.done(function(data) {
						console.log("current time : "+data);
						if(data<vid)
						{
							setTimeout(getFinishCompression(VideoTime), 1000);
						}
						else{
						alert("The video conversion is finsihed");
						}

				});
		}
		
		
					
		//function to upload
		/*when we click on the button upload*/
		$('#upload'+i+'').on('click', function(ev) {
			if((comptStart == 1)&(comptStop == 1))//the user need to record a video before upload it
			{
				//First we switch off the camera
				mediaStreamObj.getTracks()[0].stop();
				mediaStreamObj.getTracks()[1].stop();
				var numVideo = $('#VideoNb'+i+'').val();//Get the number of the video
				var conf=confirm("Are you sure to upload this video to the video "+numVideo+" ?");
				if (conf == true) {
				var reader = new FileReader();//we need to create a file reader to upload the blob data
				 $("#Vid"+i+'').css("display", "block");//we display the recording video
				 $("#myProgress"+i+"").css("display", "block");//we display the loading bar
				elem.style.width = 0 + '%'; 
				let fileName;
				reader.onload = function(event){
				//we define the url 2 path for ajax
				id =  '{{ $share->id }}';
				//url to get the name of the videofile(for button delete)
				var url2 = '{{route("getName", [":id", ":numberVideo"] ) }}';
				url2 = url2.replace(':id', id);
				url2 = url2.replace(':numberVideo', i);
				//console.log(url2);
				//url to store the video on the servor
				var url = '{{route("uploadVid", [":id"] ) }}';
				url = url.replace(':id', id);
				document.getElementById('DataVideo'+i+'').value = event.target.result;
				 var formData = {
									'VideoNb' : $('#VideoNb'+i+'').val(),
									'dataBlob'    : $('#DataVideo'+i+'').val()
					};
					
				 // process the form
				$.ajax({
				// this part is progress bar
                xhr: function () {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function (ev) {
                        if (ev.lengthComputable) {
                                var percentComplete = ev.loaded / ev.total;
                                percentComplete = parseInt(percentComplete * 100);
                                elem.style.width = percentComplete + '%'; 
                             }
							 //When the loading is finished
							 if(percentComplete==100)
							 {								
								alert("Your video has been uploaded with success !");//finished operation
								$("#myProgress"+i+"").css("display", "none");
								var x3 = document.getElementById("DisplayT"+i+"");//We can display the form to delete the uploaded video
							    x3.style.display = "block";
								//And now we want the name of the new file video (for the form's action)
								$.ajax({
									type        : 'get', // define the type of HTTP verb we want to use (GET for our form)
									contentType: 'application/json; charset=utf-8',
									url         : url2, // the url where we want to POST
									data: fileName,
									cache: false, 
									dataType    : 'json' // what type of data do we expect back from the server
								})
								.done(function(fileName) {
									console.log(fileName);
								//We change the actions's path of the delete form(which has been hidden before
								VideoTime=0;
								getFinishCompression(VideoTime);
								let urlll='uploads/video/'+fileName;
								changeSource(urlll);
								document.getElementById("deleteForm"+i+"").action = "deleteVid/"+fileName+''; 
				
								});
							 }
								 
                         }, false);
                        return xhr;
                        },
					headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
				url         : url, // the url where we want to POST
				data        : formData, // our data object
				dataType    : 'json', // what type of data do we expect back from the server
				encode          : true
				})
				.done(function(formData) {

                // log data to the console so we can see
                console.log(formData); 
				
			});
			}
			reader.readAsDataURL(blob);
			//We create the video to display on the page
			var x2 = document.getElementById("Display"+i+"");
			x2.style.display = "none";
			//we display the video the user uploading
			var videlem = document.createElement("video");
			videlem.setAttribute("width", "640");
			videlem.setAttribute("height", "360");
			videlem.setAttribute("controls", "controls");
			sourceV = window.URL.createObjectURL(blob);
			videlem.setAttribute("src", sourceV);
			document.getElementById("Vid"+i+'').appendChild(videlem);
				}}
			else{//if the user don't recorded video
				alert("You need to start and stop recording the video before to upload it, thanks for your understanding")
			}
				
		});

         },
			e => {
					
					alert("You denied the permission, if you want to take a video, please refresh the page(f5 or ctrl+r)");

			} ).catch(function(err) { 
            console.log(err.name, err.message); 
        })

	}
	}
		console.log(cd[i]);

	}

	
    </script>
								
@endsection