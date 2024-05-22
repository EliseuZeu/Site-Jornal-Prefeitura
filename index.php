<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Site</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<?php include 'header.php'; ?>

<!-- Faixa "Diário Oficial" -->
<div class="diario-oficial">
    <div class="diario-oficial-content">
        <h1>Diário Oficial</h1>
        <div class="divider"></div>
    </div>
</div>

<!-- Conteúdo da Página -->
<section id="pesquisa">
    <div class="caixa-form">
        <form id="search-form">
            <div class="form-row">
                <label for="ano">Ano:</label>
                <select id="ano" class="select-ano"></select>
                <label for="termo">Termo de Pesquisa:</label>
                <input type="text" id="termo" class="input-termo" placeholder="Digite o termo de pesquisa">
                <label for="data">Data da Edição:</label>
                <input type="text" id="data" class="input-data" placeholder="dd/mm/yyyy">
                <button type="submit" class="btn-pesquisar">Pesquisar</button>
            </div>
        </form>
    </div>
</section>

<!-- Seção de Cards -->
<div class="cards-container" id="cards-container">
    <!-- Cards serão gerados dinamicamente por JavaScript -->
</div>

<!-- Paginação -->
<div class="pagination" id="pagination"></div>

<!-- Footer -->
<section class="footer">
    <div class="footer-row">
        <div class="footer-col">
            <h4>Info</h4>
            <ul class="links">
                <li><a href="#">About Us</a></li>
                <li><a href="#">Compressions</a></li>
                <li><a href="#">Customers</a></li>
                <li><a href="#">Service</a></li>
                <li><a href="#">Collection</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h4>Explore</h4>
            <ul class="links">
                <li><a href="#">Free Designs</a></li>
                <li><a href="#">Latest Designs</a></li>
                <li><a href="#">Themes</a></li>
                <li><a href="#">Popular Designs</a></li>
                <li><a href="#">Art Skills</a></li>
                <li><a href="#">New Uploads</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h4>Legal</h4>
            <ul class="links">
                <li><a href="#">Customer Agreement</a></li>
                <li><a href="#">Privacy Policy</a></li>
                <li><a href="#">GDPR</a></li>
                <li><a href="#">Security</a></li>
                <li><a href="#">Testimonials</a></li>
                <li><a href="#">Media Kit</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h4>Newsletter</h4>
            <p>Subscribe to our newsletter for a weekly dose of news, updates, helpful tips, and exclusive offers.</p>
            <form action="#">
                <input type="text" class="input-newsletter" placeholder="Your email" required>
                <button type="submit" class="btn-subscribe">SUBSCRIBE</button>
            </form>
            <div class="icons">
                <i class="fab fa-facebook-f"></i>
                <i class="fab fa-twitter"></i>
                <i class="fab fa-linkedin"></i>
                <i class="fab fa-github"></i>
            </div>
        </div>
    </div>
</section>

<!-- Incluir PDF.js a partir de um CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.worker.js"></script>
<script src="assets/scripts.js"></script>

</body>
</html>