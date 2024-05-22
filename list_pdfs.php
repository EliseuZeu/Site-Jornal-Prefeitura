<?php
// Caminho da pasta onde estão os PDFs
$pdfs_dir = 'pdfs';

// Função recursiva para listar todos os arquivos PDFs
function list_pdfs($dir) {
    $result = [];
    $files = scandir($dir);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;
        $path = $dir . '/' . $file;
        if (is_dir($path)) {
            $result = array_merge($result, list_pdfs($path));
        } elseif (pathinfo($file, PATHINFO_EXTENSION) === 'pdf') {
            $result[] = $path;
        }
    }
    return $result;
}

$pdf_files = list_pdfs($pdfs_dir);

// Retorna os caminhos dos arquivos em formato JSON
header('Content-Type: application/json');
echo json_encode($pdf_files);
?>
