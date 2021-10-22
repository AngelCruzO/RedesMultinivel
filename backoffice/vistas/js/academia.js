/*=============================================
MOSTRAR - OCULTAR BOTONES DE VIDEOS
=============================================*/
var toggle = false;

$(".videos .visorVideos .fa-bars").click(function(){

	if(!toggle){

		toggle = true;	
	
	}else{

		toggle = false;	
	
	}

	ocultarBotones(toggle);

})

function ocultarBotones(toggle){

	if(!toggle){

		$(".videos .visorVideos h5").toggle("fast");
		$(".videos .botonesVideos").toggle("fast");	

		if(window.matchMedia("(max-width:768px)").matches){

			$(".videos .visorVideos").css({"width":"70%"});

		}else{

			$(".videos .visorVideos").css({"width":"75%"});

		}


	}else{

		$(".videos .visorVideos h5").toggle("fast");
		$(".videos .botonesVideos").toggle("fast");	
		$(".videos .visorVideos").css({"width":"100%"});

	}

};

/*=============================================
=           Reproduccion automatica           =
=============================================*/
var rutaCategoria = $(".videos video").attr("rutaCategoria");
var nextVideo = $(".videos video").attr("nextVideo");

setInterval(function(){
	if($(".videos video")[0].ended){

		window.location = "index.php?pagina="+rutaCategoria+"&video="+nextVideo;

	}
},1000)


/*=============================================
=            Velocidad del video              =
=============================================*/
var video = document.getElementById("myVideo");//llamado con javascript tradicional

$(".velocidadVideo a").click(function(e){
	
	e.preventDefault();

	video.playbackRate = $(this).attr("velocidad");
	$(".velocidadVideo a").removeClass("active");
	$(this).addClass("active");

})

/*=============================================
=              Reproduccion HLS               =
=============================================*/
var videoSrcHls = $(".visorVideos").attr("rutaVideo");
var videoMP4 = $(".visorVideos").attr("rutaVideoMp4");

if(Hls.isSupported()) {
  var hls = new Hls();
  hls.loadSource(videoSrcHls);
  hls.attachMedia(video);
  hls.on(Hls.Events.MANIFEST_PARSED,function() {
    video[0].play();
  });
}else{
  addSourceToVideo(video, videoMP4, 'video/mp4');
  video.play();
}

 function addSourceToVideo(element, src, type) {
  var source = document.createElement('source');
  source.src = src;
  source.type = type;
  element.appendChild(source);
}

/*=============================================
=              Sombrear video                 =
=============================================*/
var numeroClase = $(".visorVideos").attr("numeroClase");

$(".botonesVideos ul li[numeroClase='"+numeroClase+"']").css({"background":"#ddd", "color":"#000"});
