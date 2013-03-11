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
		<script type="text/javascript" src="jlinq.js" ></script>
        <script type="text/javascript" src="data.js" ></script>
        <script type="text/javascript" src="programacao.js" ></script>

		<script src="okvideo.js"></script>

		<script language="javascript">
		
			///tools

			function arrayObjectIndexOf(myArray, searchTerm, property) {
			    for(var i = 0, len = myArray.length; i < len; i++) {
			        if (myArray[i][property] === searchTerm) return i;
			    }
			    return -1;
			}

			var getClosestValues = function(a, x) {
			    var lo = 0, hi = a.length-1;
			    while (hi - lo > 1) {
			        var mid = Math.round((lo + hi)/2);
			        if (a[mid] <= x) {
			            lo = mid;
			        } else {
			            hi = mid;
			        }
			    }
			    if (a[lo] == x) hi = lo;

			    if(a[hi]<x){
			    	return [a[hi]];
			    }
			    return [a[lo], a[hi]];
			}


			/// ver que horas sao e que dia é hoje
			var d = new Date();
			var horas = d.getHours().toString();
			var minutos =  d.getMinutes().toString();
            var segundos = d.getSeconds();
			var dia = d.getDate();
			var mes = d.getMonth() + 1;
			var ano = d.getFullYear();
            var horaAtual = ((horas < 10) ? "0" + horas : horas) + ":" + ((minutos < 10) ? "0" + minutos : minutos);

			
			///document.write("<div id=horas>" + horas + " - " + minutos + " - " + dia + " - " + mes + " - " + ano + "</div>");
			

			/// verificar qual eh o programa da vez
			

			var result = jlinq.from(objeto.programacao)
  			.starts('ano', ano)
  			.select();

  			result = jlinq.from(result)
  			.starts('mes', mes)
  			.select();

  			result = jlinq.from(result)
  			.starts('dia', dia)
  			.select();
  			
  			result = jlinq.from(result)
			.sort("hora")
			.select();



  			var programacaoEmMinutos = new Array();

  			for(i=0;i<result.length;i++)
  			{

  				var m = result[i].hora * 60;
  				m += Number(result[i].minuto);

  				programacaoEmMinutos.push(m);

  				
  			}


  			var mAtual = d.getHours()*60 + d.getMinutes();

  			var dif = mAtual - getClosestValues(programacaoEmMinutos,mAtual)[0];
  			var index = programacaoEmMinutos.indexOf(getClosestValues(programacaoEmMinutos,mAtual)[0]);

			console.log(result[index].url + "&t=" + dif + "m");

  			/*
  			var result = jlinq.from(result)
  			.starts('minuto', minutos)
  			.select();
			*/		

			
			/// tocar
			$(function(){
				$.okvideo({
					video: result[index].url,
					startSec: (dif * 60 + segundos),
                    volume: 0,
					adproof: true,
					onFinished: function() { 
						// proximo programa
					}
				})
			});
			


			/// infos
            //document.getElementById("hora").innerHTML = horaAtual;
			//document.getElementById("now").innerHTML = "<p class='titulo_box'>AGORA</p><p class='titulo_programa'>" + "Titulo" + "</p><a href=" + result[0].url + " target='_blank'>" + result[0].nome + "</a>";
			//document.getElementById("next").innerHTML = "<p class='titulo_box'>A SEGUIR</p>" + "Horario Proximo" + " &nbsp;" + "Titulo Proximo;
            
			document.write("<div id=hora>" + horaAtual + "</div>");
			document.write("<div id=now>NOW PLAYING<br>" + result[0].nome + "</div>");
			//document.write("<div id=next>NEXT SHOW<br>" + result[0].hora + " &nbsp; " + result[0].nome + "</div>");
			
			
		
		</script>
		
	</head>
    <!--
    <body>
    	<div id="hora" class="gradientCinzaEsc"></div>
		<div id="now" class="gradientCinzaEsc"></div>
		<div id="next" class="gradientCinzaEsc"></div>
	</body>
    -->
</html>