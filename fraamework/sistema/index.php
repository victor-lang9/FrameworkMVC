<style>
    .brand-dropdown:hover .dropdown-menu {
        display: block;
        margin-top: 0;
    }
</style>
<html>
    <head>
        <title>Cadastro</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="dropdown brand-dropdown">
            <a class="navbar-brand dropdown-toggle" href="#" role="button" id="dropdownBrand" data-bs-toggle="dropdown" aria-expanded="false">
            Cadastro
            </a>
            <ul class="dropdown-menu" aria-labelledby="dropdownBrand">
                <li><a class="dropdown-item" href="#" onclick="carregarPagina('view/form_aluno.php'); return false;">aluno</a></li><li><a class="dropdown-item" href="#" onclick="carregarPagina('view/form_curso.php'); return false;">curso</a></li><li><a class="dropdown-item" href="#" onclick="carregarPagina('view/form_professor.php'); return false;">professor</a></li>
            </ul>
        </div>
        
        <div class="container mt-4">
            <div id="conteudo">
                <h3>Selecione uma opção no menu Cadastro</h3>
            </div>
        </div>
        
        <div class="dropdown brand-dropdown">
            <a class="navbar-brand dropdown-toggle" href="#" role="button" id="dropdownBrand" data-bs-toggle="dropdown" aria-expanded="false">
            Relatório
            </a>
            <ul class="dropdown-menu" aria-labelledby="dropdownBrand">
                <li><a class="dropdown-item" href="view/lista_aluno.php">aluno</a></li><li><a class="dropdown-item" href="view/lista_curso.php">curso</a></li><li><a class="dropdown-item" href="view/lista_professor.php">professor</a></li>
            </ul>
        </div>
    </body>
</html>
<script>
function carregarPagina(pagina) {
    fetch(pagina)
        .then(response => {
            if (!response.ok) {
                throw new Error("Erro ao carregar a página.");
            }
            return response.text();
        })
        .then(html => {
            document.getElementById("conteudo").innerHTML = html;
        })
        .catch(error => {
            document.getElementById("conteudo").innerHTML =
                "<p class='text-danger'>Erro ao carregar o formulário.</p>";
            console.error(error);
        });
}
</script><script>
function carregarPagina(pagina) {
    fetch(pagina)
        .then(response => {
            if (!response.ok) {
                throw new Error("Erro ao carregar a página.");
            }
            return response.text();
        })
        .then(html => {
            document.getElementById("conteudo").innerHTML = html;
        })
        .catch(error => {
            document.getElementById("conteudo").innerHTML =
                "<p class='text-danger'>Erro ao carregar o formulário.</p>";
            console.error(error);
        });
}
</script>