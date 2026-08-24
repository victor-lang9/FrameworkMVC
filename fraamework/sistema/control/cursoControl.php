<?PHP
require_once('../model/curso.php');
 require_once('../dao/cursoDAO.php');
class CursoControl {
   private $obj;
   private $dao;
   private $acao;
   public function __construct() {
       $this->obj=new Curso();
       $this->dao=new CursoDAO();
       $this->acao=$_REQUEST["acao"] ?? null;
      $this->executaAcao();
   }
   public function executaAcao() {
   switch($this->acao) {
          case 1:
          $this->prepararObjeto();
          $this->dao->inserir( $this->obj);
          break;
          case 2:
          return $this->dao->listar();
          case 3:
          $this->dao->excluir( $_REQUEST["id"] );
          break;
          case 4:
          $obj=$this->dao->buscarPorId( $_REQUEST["id"] );
          require_once("../view/form_curso.php");
          break;
          case 5:
          $this->prepararObjeto();
          $this->obj->setId_curso( $_POST["id"] );
          $this->dao->alterar( $this->obj);
          break;
      }
   }
   public function prepararObjeto() {
      $this->obj->setNome($_POST["nome"]);
	$this->obj->setCarga_horaria($_POST["carga_horaria"]);
	$this->obj->setDescricao($_POST["descricao"]);
	$this->obj->setId_professor($_POST["id_professor"]);
	
   }
}
new CursoControl;
?>
