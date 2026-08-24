<?PHP
require_once('../model/aluno.php');
 require_once('../dao/alunoDAO.php');
class AlunoControl {
   private $obj;
   private $dao;
   private $acao;
   public function __construct() {
       $this->obj=new Aluno();
       $this->dao=new AlunoDAO();
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
          require_once("../view/form_aluno.php");
          break;
          case 5:
          $this->prepararObjeto();
          $this->obj->setId_aluno( $_POST["id"] );
          $this->dao->alterar( $this->obj);
          break;
      }
   }
   public function prepararObjeto() {
      $this->obj->setNome($_POST["nome"]);
	$this->obj->setEmail($_POST["email"]);
	$this->obj->setData_nascimento($_POST["data_nascimento"]);
	$this->obj->setId_curso($_POST["id_curso"]);
	
   }
}
new AlunoControl;
?>
