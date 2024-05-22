<?php
$dir    = "/var/www/www.amparo.sp.gov.br/2011/jornaisoficiais/2009/";
$files1 = scandir($dir);
foreach ( $files1 as $jornal)
{
	$diretorio = "";	
	if (is_dir ($jornal) )
	{
		$mes = explode("_",$jornal);
		$diretorio = "$jornal/";
		//echo "Diretorio: $diretorio <br/> ";
	}
	
	if ( $diretorio != "" && $diretorio !="./" && $diretorio != "../" )
	{
	$newFiles = scandir($diretorio);
	
	//Imprime o mes
	echo "<h3 style='clear:both; margin-bottom:10px; border-bottom:dotted 1px #AEAEAE'> $mes[1] de  2009</h3>";
	echo "<br />". $dir."".$diretorio."".$newjornal ;
 
	foreach ( $newFiles as $newjornal  )
        {
		if ( is_file ($diretorio."".$newjornal) )
		{	
		  echo "Arquivo: $newjornal <br/>";
?>
<div class="views-row views-row-7 views-row-odd">
<div class="views-field-description">
<span class="field-content">
<a href="http://www.amparo.sp.gov.br/2011/jornaisoficiais/2009/01_janeiro/dia_09.pdf">
<img class="imagem-jornal" src="http://www.amparo.sp.gov.br/2011/jornaisoficiais/2009/01_janeiro/dia_09.jpg">
<p id="20130628" class="descricao">09/01/2009 </p>
</a>
</span>
</div>
</div>
<?		}
	}
	}

}
?>
