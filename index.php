<?php
    $localtime = localtime();
    $year = strval( ($localtime[5]+1900) );
    $month = strval( ($localtime[4]+1) );
    $day = strval($localtime[3]);
    $hour = strval($localtime[2]);
	$min = strval($localtime[1]);
    $sec = strval($localtime[0]);
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
			var dServer = new Date();
			var sHoras = <?php echo $hour; ?>;
			var sMinutos =  <?php echo $min; ?>;
            var sSegundos = <?php echo $sec; ?>;
			var sDia = <?php echo $day; ?>;
			var sMes = <?php echo $month; ?>;
			var sAno = <?php echo $year; ?>;
            
            var dLocal = new Date();
            var lHoras = dLocal.getHours();
    		var lMinutos = dLocal.getMinutes();
            var lSegundos = dLocal.getSeconds();
			var lDia = dLocal.getDate();
			var lMes = dLocal.getMonth() + 1;
			var lAno = dLocal.getFullYear();
            
            var horaLocal = ((lHoras < 10) ? "0" + lHoras : lHoras) + ":" + ((lMinutos < 10) ? "0" + lMinutos : lMinutos);

			
            /// verifica qual o programa da vez

			var result = jlinq.from(objeto.programacao)
  			.starts('ano', sAno)
  			.select();

  			result = jlinq.from(result)
  			.starts('mes', sMes)
  			.select();

  			result = jlinq.from(result)
  			.starts('dia', sDia)
  			.select();
  			
  			result = jlinq.from(result)
			.sort('hora')
			.select();



  			var programacaoEmMinutos = new Array();

  			for(i=0;i<result.length;i++)
  			{

  				var m = result[i].hora * 60;
  				m += Number(result[i].minuto);

  				programacaoEmMinutos.push(m);

  				
  			}


  			var mAtual = <?php echo $hour ?> * 60 + <?php echo $min ?>;

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
					startSec: (dif * 60 + sSegundos),
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
            
			document.write("<div id=hora>" + horaLocal + "</div>");
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