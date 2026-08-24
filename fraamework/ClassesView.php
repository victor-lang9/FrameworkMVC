<?php
require_once("utils.php");
class ClassesView
{
    private $entidades;
    private $caminho = "sistema/view/";
    function __construct($e)
    {
        if (!is_dir($this->caminho)) {
            mkdir($this->caminho, 0777, true);
        }
        $this->entidades = $e;
        $this->criaFormulario();
        $this->criaLista();
        $this->criarIndex();
    }
    function criaLista()
    {
        $listaEntidades = array_keys($this->entidades);
        foreach ($listaEntidades as $entidade) {
            $listaAtributos = $this->entidades[$entidade];
            $cabecalho = "";
            $dados = "";
            foreach ($listaAtributos as $key => $atributo) {
                if ($atributo["primary"]) $chave = $key;
                $cabecalho .= "<td>$key</td>\n";
                $dados .= "<td><?php echo \$dado['{$key}']?></td>\n";
            }
            $cabecalho .= "<td colspan='2'>Gerenciar</td>\n";
            $p1 = "acao=3";
            $p2 = "id=<?php echo \$dado['{$chave}'] ?>";
            $p3 = "acao=4";
            $dados .= "<td>
            <a href='../control/{$entidade}Control.php?{$p1}&{$p2}'>Excluir</a></td>\n";
            $dados .= "<td><a href='../control/{$entidade}Control.php?{$p3}&{$p2}'>Alterar</a></td>\n";
            $classe = ucfirst($entidade);
            $conteudo = <<<LISTA
                <?php
                ini_set('display_errors',1);
                ini_set('display_startup_erros',1);
                    error_reporting(E_ALL);
                  require_once __DIR__.'/../control/{$entidade}Control.php';
                  \$_REQUEST['acao'] = 2;
                  \$control = new {$classe}Control();
                  \$dados = \$control->executaAcao();
                ?>
                <html>
                    <head>
                        <title>Lista de {$entidade}</title>
                          <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
                    </head>
                    <body>
                    <table>
                    <tr> {$cabecalho}</tr>
                     <?php
                        foreach (\$dados as \$dado) {
                      ?>
                    <tr>{$dados}</tr>
                    <?php
                    }
                    ?>
                    </table>
                    </body>
                </html>
                LISTA;
            file_put_contents("{$this->caminho}lista_" . $entidade . ".php", $conteudo);
        }
    }
    function criaFormulario()
    {
        $util = new Utils();
        $listaEntidades = array_keys($this->entidades);
        foreach ($listaEntidades as $entidade) {
            $listaAtributos = $this->entidades[$entidade];
            $campos = "";
            foreach ($listaAtributos as $key => $atributo) {
                if (!$atributo["primary"]) {
                    $tipoForm = $util->converterTipoPHPForm($atributo["tipo"]);
                    $campos .= "<div class=\"mb-3\">";
                    $campos .= "<label for=\"$key\" class=\"form-label\">$key</label>";
                    $campos .= "<input value='<?php echo (\$alt)?\$obj->get" . ucFirst($key) . "():\"\";?>'  type='" . $tipoForm . "' name='" . $key . "' class=\"form-control\">";
                    $campos .= "</div>\n\t";
                }
                else $chave = $key;
            }
            $metodoChave = ucFirst($chave);
            $conteudo = <<<FORM
                <html>
                    <head>
                        <title>Cadastro</title>
                          <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
                    </head>
                    <body>
                    <?php
                     \$alt=false;
                       if(isset(\$obj))
                       \$alt=true;
                    ?>
                    <div class="container mt-5">
                    <h2 class="mb-4">Cadastro</h2>
                    <form action="../control/{$entidade}Control.php" method="POST">
                    <input type="hidden" name="acao" value="<?php echo (\$alt)?5:1;?>">
                    <input type="hidden" name="id" value="<?php echo (\$alt)?\$obj->get{$metodoChave}():"";?>">
                      $campos
                      <button type="submit" class="btn btn-primary">Salvar</button>
                    </form>
                    </body>
                </html>
                FORM;
            file_put_contents("{$this->caminho}form_" . $entidade . ".php", $conteudo);
        }
    }

    function criarIndex()
    {
        $listaEntidades = array_keys($this->entidades);
        $itensMenuCadastro="";
        $itensMenuRelatorio="";
        foreach ($listaEntidades as $entidade) {
            $itensMenuCadastro.="<li><a class=\"dropdown-item\" href=\"view/form_{$entidade}.php\">$entidade</a></li>";
            $itensMenuRelatorio.="<li><a class=\"dropdown-item\" href=\"view/lista_{$entidade}.php\">$entidade</a></li>";
        }
        $conteudo = <<<INDEX
        <style>
            html, body {
                height: 100%;
                margin: 0;
                display: flex;
                flex-direction: column;    
        
            .brand-dropdown:hover .dropdown-menu {
                display: block;
                margin-top: 0;
            }
            
            #conteudo {
                flex: 1;
            }
                
            #conteudo iframe {
                width: 100%;
                height: 100%;
                border: none;
            }
        </style>
        <html>
            <head>
                <title>Cadastro</title>
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
                <base target="principal">
            </head>
            <body>
                <div class="dropdown brand-dropdown">
                    <a class="navbar-brand dropdown-toggle" href="#" role="button" id="dropdownBrand" data-bs-toggle="dropdown" aria-expanded="false">
                    Cadastro
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownBrand">
                        $itensMenuCadastro
                    </ul>
                </div>
                
                <div class="dropdown brand-dropdown">
                    <a class="navbar-brand dropdown-toggle" href="#" role="button" id="dropdownBrand" data-bs-toggle="dropdown" aria-expanded="false">
                    Relatório
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownBrand">
                        $itensMenuRelatorio
                    </ul>
                </div>
                
                <div id="conteudo">
                    <iframe name="principal"></iframe>
                </div>
            </body>
        </html>
        INDEX;
        file_put_contents("sistema/index.php", $conteudo);
    }
}
