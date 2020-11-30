<?php
//palabra a buscar desde la URL
$palabra = $_GET['q'];
//scrapear la url donde aparecerá la palabra que buscamos
$html = file_get_contents('https://www.milanuncios.com/anuncios-en-leon/?vendedor=part'); 
$doc = new DOMDocument();
@$doc->loadHTML($html);
$enlaces = $doc->getElementsByTagName("a");
for ($i = 0; $i < 150; $i++) {
	$node = $enlaces->item($i);
  //escogemos solo los enlaces a los anuncios
	$clase = $node->getAttribute("class");
	if($clase === 'aditem-detail-title'){
	$link = $node->getAttribute("href");
	$texto = $node->textContent;
  //creamos en link directo al anuncio que recibiremos por mail
	$linkmail = 'https://www.milanuncios.com'. $link .'';
  // imprimir en pantalla los resultados que obtenemos de esa url
	echo $texto;
	echo '- <br />';
	echo '<a target="_blank" href="';
	echo 'https://www.milanuncios.com';
	echo $link;
	echo '">Enlace al anuncio</a>';
	echo '<br />';
	if(stristr($texto, $palabra)){
	$to= "example@mail.com\r\n";
	$subject = "Anuncio $texto";
	$headers = "From: Alerta <alerta@domain.com>\r\n";
	$message = "$texto - $linkmail\r\n";
		if(mail($to, $subject, $message, $headers)){
			echo '<h2>Enviado</h2>'; 
			} else { 
			echo 'Error';
			}
		}
	}
}
?>
