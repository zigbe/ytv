<?php
	$localtime = localtime();
	$hour = ($localtime[2] < 10 ? "0" . $localtime[2] : $localtime[2]);
	$min = ($localtime[1] < 10 ? "0" . $localtime[1] : $localtime[1]);
	$horaServer = $hour . ":" . $min;
	echo $horaServer;
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" media="all" href="styles.css" />
		<script src="https:////ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<script src="okvideo.js"></script>
		<script src="programacao.js"></script>
		<script language="javascript">
			/// update infos
			$(function updateInfos() {
				var d = new Date();
				var horas = (d.getHours() < 10) ? "0" + d.getHours() : d.getHours();
				var minutos =  (d.getMinutes() < 10) ? "0" + d.getMinutes() : d.getMinutes();
				var horaAtual = horas + ":" + minutos;
				
				var timeServer = "<?php echo $horaServer ?>";
				var horaServer = timeServer.split(":")[0];
				var minServer = timeServer.split(":")[1];
				
				var horaLocal = horaAtual.split(":")[0];
				var minLocal = horaAtual.split(":")[1];
				
				
				var timeDif = (horaServer - horaLocal) + ":" + (minServer - minLocal);
				//alert(timeDif);
				
				document.getElementById("hora").innerHTML = horaAtual;
				document.getElementById("now").innerHTML = "<p class='titulo_box'>AGORA</p><p class='titulo_programa'>" + tv.programa[0].titulo + "</p><a href=" + tv.programa[0].video[0].url + " target='_blank'>" + tv.programa[0].video[0].titulo + "</a>";
				document.getElementById("next").innerHTML = "<p class='titulo_box'>A SEGUIR</p>" + tv.programa[1].hora + " &nbsp;" + tv.programa[1].titulo;
				
				setTimeout(updateInfos, 1000);
			});
			
			/// verificar qual eh o programa da vez
			$(function checkPrograma() {
				for(var i=0; i<tv.programa.length;i++)
				{
					var horaPrograma = tv.programa[i].hora.split(":")[0];
					var minPrograma = tv.programa[i].hora.split(":")[1];
					//alert(minPrograma);
				}	
			});
			
			/// tocar
			$(function(){
				$.okvideo({
					video: tv.programa[0].video[0].url,
					volume: 100,
					adproof: false,
					onFinished: function() { 
						// proximo programa
					}
				})
			});
			
		</script>
	</head>
	<body>
		<div id="hora" class="gradientCinzaEsc"></div>
		<div id="now" class="gradientCinzaEsc"></div>
		<div id="next" class="gradientCinzaEsc"></div>
	</body>
</html>