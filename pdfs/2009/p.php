<?php
 $dir    = '/var/www/www.amparo.sp.gov.br/2011/jornaisoficiais/2009/';
 $files1 = scandir($dir);
 foreach ( $files1 as $jornal)
 {
 $diretorio = "";
 if (is_dir ($jornal) )
 {
 $mes = explode("_",$jornal);
 $diretorio = "./$jornal/";
 }
 if ( $diretorio != "" && $diretorio !="././" && $diretorio != "./../" ) {
 $newFiles = scandir($dir."".$diretorio);
 //Imprime o mes
 echo "
 <h3 style='clear:both; margin-bottom:10px; border-bottom:dotted 1px #AEAEAE;' >" . $mes['1'] ." de  2009";
 foreach ( $newFiles as $newjornal  )
 {
 if ( is_file ($diretorio."".$newjornal) )
 {
 echo"Arquivo: $newjornal <br />
 ";
 ?> <div class="views-row views-row-7 views-row-odd">
 <div class="views-field-description">
 <span class="field-content">
 <a href="/2011/jornaisoficiais/2009/01_janeiro/dia_09.pdf">
 <img src="/2011/jornaisoficiais/2009/01_janeiro/dia_09.jpg" class="imagem-jornal" />
 <p id="20130628" class="descricao">
 09/01/2009 
 </p>
 </a>
 </span>
 </div>
 </div>
 <?              }
 }
 }
 }
 ?>
 
