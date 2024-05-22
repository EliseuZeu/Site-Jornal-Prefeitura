document.addEventListener('DOMContentLoaded', function() {
    const anoSelect = document.getElementById('ano');
    const currentYear = new Date().getFullYear();
    const startYear = 1900;
    const itemsPerPage = 8; // Máximo de 8 cards por página
    let currentPage = 1; // Página atual
    let allFiles = []; // Armazena todos os arquivos PDF

    // Preenche o select com os anos
    for (let year = currentYear; year >= startYear; year--) {
        const option = document.createElement('option');
        option.value = year;
        option.textContent = year;
        anoSelect.appendChild(option);
    }

    // Adiciona efeito hover aos links do header
    const links = document.querySelectorAll('header a');
    links.forEach(link => {
        link.addEventListener('mouseenter', () => {
            link.style.backgroundColor = 'var(--cor-secundaria)';
        });
        link.addEventListener('mouseleave', () => {
            link.style.backgroundColor = 'transparent';
        });
    });

    // Adiciona evento ao formulário de busca
    const form = document.getElementById('search-form');
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        currentPage = 1; // Reinicia a página atual ao submeter o formulário
        const ano = document.getElementById('ano').value;
        const termo = document.getElementById('termo').value.trim().toLowerCase();
        fetchFiles(ano, termo);
    });

    function renderCards(files) {
        const cardsContainer = document.getElementById('cards-container');
        cardsContainer.innerHTML = ''; // Limpa os cards existentes

        // Divide os arquivos em páginas
        const start = (currentPage - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        const paginatedFiles = files.slice(start, end);

        paginatedFiles.forEach(file => {
            const info = extractInfoFromPath(file);
            if (info) {
                const { date, year } = info;
                const cardElement = document.createElement('div');
                cardElement.className = 'card';
                cardElement.setAttribute('data-pdf', file);
                cardElement.innerHTML = `
                    <div class="card-content">
                        <canvas class="pdf-canvas"></canvas>
                        <p class="card-year">Ano: ${year}</p>
                        <p class="card-date">Data: ${date}</p>
                    </div>
                `;
                cardsContainer.appendChild(cardElement);

                const canvas = cardElement.querySelector('.pdf-canvas');
                loadPdfAndDisplayFirstPage(file, canvas);

                // Adiciona o event listener para abrir o PDF em uma nova aba ao clicar no card
                cardElement.addEventListener('click', () => {
                    window.open(file, '_blank');
                });
            } else {
                console.error('Nome de arquivo inválido:', file);
            }
        });

        renderPagination(files.length);
    }

    async function fetchFiles(ano = '', termo = '') {
        try {
            const response = await fetch('list_pdfs.php');
            if (!response.ok) {
                throw new Error('Erro ao buscar os arquivos: ' + response.statusText);
            }

            const files = await response.json();
            if (!Array.isArray(files)) {
                throw new Error('Resposta inesperada do servidor.');
            }

            // Filtrar os arquivos com base nos critérios de pesquisa
            const filteredFiles = files.filter(file => {
                const info = extractInfoFromPath(file);
                if (!info) return false;
                const { year } = info;
                const matchAno = !ano || year === ano;
                const matchTermo = !termo || file.toLowerCase().includes(termo);
                return matchAno && matchTermo;
            });

            if (termo) {
                // Para cada arquivo, buscar o termo dentro do PDF
                const matchingFiles = [];
                for (const file of filteredFiles) {
                    const matches = await searchInPDF(file, termo.toLowerCase());
                    if (matches.length > 0) {
                        matchingFiles.push(file);
                    }
                }
                allFiles = matchingFiles; // Armazena todos os arquivos filtrados
            } else {
                allFiles = filteredFiles;
            }

            renderCards(allFiles);
        } catch (error) {
            console.error('Erro ao buscar os arquivos:', error);
        }
    }

    function extractInfoFromPath(filepath) {
        try {
            const pathParts = filepath.split('/');
            const year = pathParts[1]; // Supondo que a estrutura seja 'pdfs/ano/mes/arquivo.pdf'
            const month = pathParts[2];
            const filename = pathParts[3];
            const date = filename.split('.')[0]; // Considera que o nome do arquivo é a data
            return { date, year, month };
        } catch (error) {
            console.error('Erro ao extrair informações do caminho do arquivo:', error, filepath);
            return null;
        }
    }

    function renderPagination(totalFiles) {
        const paginationContainer = document.getElementById('pagination');
        paginationContainer.innerHTML = ''; // Limpa a paginação existente

        const totalPages = Math.ceil(totalFiles / itemsPerPage);

        for (let i = 1; i <= totalPages; i++) {
            const pageLink = document.createElement('a');
            pageLink.href = '#';
            pageLink.textContent = i;
            if (i === currentPage) {
                pageLink.classList.add('active');
            }
            pageLink.addEventListener('click', (event) => {
                event.preventDefault();
                currentPage = i;
                renderCards(allFiles);
                updatePaginationLinks(totalPages);
            });
            paginationContainer.appendChild(pageLink);
        }
    }

    function updatePaginationLinks(totalPages) {
        const paginationLinks = document.querySelectorAll('.pagination a');

        paginationLinks.forEach(link => {
            if (link.textContent == currentPage) {
                link.classList.add('active');
            } else {
                link.classList.remove('active');
            }
        });
    }

    fetchFiles();

    async function loadPdfAndDisplayFirstPage(pdfUrl, canvas) {
        try {
            const pdf = await pdfjsLib.getDocument(pdfUrl).promise;
            const page = await pdf.getPage(1);
            const viewport = page.getViewport({ scale: 1.0 });
            const canvasContext = canvas.getContext('2d');

            canvas.width = viewport.width;
            canvas.height = viewport.height;

            await page.render({ canvasContext, viewport }).promise;
            const imgDataUrl = canvas.toDataURL();
            canvas.style.display = 'none';
            const imgElement = document.createElement('img');
            imgElement.src = imgDataUrl;
            imgElement.alt = 'Primeira página do PDF';
            canvas.parentNode.insertBefore(imgElement, canvas);
        } catch (error) {
            console.error('Erro ao carregar o PDF:', error);
        }
    }

    async function searchInPDF(pdfUrl, term) {
        try {
            const pdf = await pdfjsLib.getDocument(pdfUrl).promise;
            const numPages = pdf.numPages;
            let matches = [];

            for (let pageNum = 1; pageNum <= numPages; pageNum++) {
                const pageMatches = await searchInPage(pdf, pageNum, term);
                matches = matches.concat(pageMatches);
            }

            return matches;
        } catch (error) {
            console.error('Erro ao buscar no PDF:', error);
            return [];
        }
    }

    async function searchInPage(pdf, pageNum, term) {
        try {
            const page = await pdf.getPage(pageNum);
            const content = await page.getTextContent();
            const pageText = content.items.map(item => item.str).join('');

            const regex = new RegExp(term, 'gi');
            const matches = [...pageText.matchAll(regex)].map(match => ({
                page: pageNum,
                match: match[0]
            }));

            return matches;
        } catch (error) {
            console.error('Erro ao buscar na página:', error);
            return [];
        }
    }
});
