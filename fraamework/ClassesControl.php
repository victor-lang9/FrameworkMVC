<?php
require_once ("utils.php");
class ClassesControl{
private $entidades;
    private $caminho = "sistema/control/";
    function __construct($e) {
       if (!is_dir($this->caminho)) {
           mkdir($this->caminho, 0777, true);
        }
        $this->entidades = $e;
        $this->criaClasse();
    }
    function criaClasse() {
            $util = new Utils();
            $listaEntidades = array_keys($this->entidades);
            foreach ($listaEntidades as $entidade) {
                $listaAtributos = $this->entidades[$entidade];
                $instancia = "";
                foreach ($listaAtributos as $key => $atributo) {
                    if(!$atributo["primary"])
                    $instancia.="\$this->obj->set".ucfirst($key)."(\$_POST[\"$key\"]);\n\t";
                    else
                    $chave=$key;
               }
                $nomeClasse=ucfirst($entidade);
                $metodoChave=ucfirst($chave);
                $conteudo = <<<CLASS
                <?PHP
                require_once('../model/$entidade.php');
                 require_once('../dao/{$entidade}DAO.php');
                class {$nomeClasse}Control {
                   private \$obj;
                   private \$dao;
                   private \$acao;
                   public function __construct() {
                       \$this->obj=new {$nomeClasse}();
                       \$this->dao=new {$nomeClasse}DAO();
                       \$this->acao=\$_REQUEST["acao"] ?? null;
                      \$this->executaAcao();
                   }
                   public function executaAcao() {
                   switch(\$this->acao) {
                          case 1:
                          \$this->prepararObjeto();
                          \$this->dao->inserir( \$this->obj);
                          break;
                          case 2:
                          return \$this->dao->listar();
                          case 3:
                          \$this->dao->excluir( \$_REQUEST["id"] );
                          break;
                          case 4:
                          \$obj=\$this->dao->buscarPorId( \$_REQUEST["id"] );
                          require_once("../view/form_{$entidade}.php");
                          break;
                          case 5:
                          \$this->prepararObjeto();
                          \$this->obj->set{$metodoChave}( \$_POST["id"] );
                          \$this->dao->alterar( \$this->obj);
                          break;
                      }
                   }
                   public function prepararObjeto() {
                      $instancia
                   }
                }
                new {$nomeClasse}Control;
                ?>
                CLASS;
                file_put_contents("{$this->caminho}{$entidade}Control.php", $conteudo);
        }
    }
}
?>
