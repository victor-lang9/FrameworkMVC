<?PHP
require_once('../model/professor.php');
 require_once('../dao/professorDAO.php');
class ProfessorControl {
   private $obj;
   private $dao;
   private $acao;
   public function __construct() {
       $this->obj=new Professor();
       $this->dao=new ProfessorDAO();
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
          require_once("../view/form_professor.php");
          break;
          case 5:
          $this->prepararObjeto();
          $this->obj->setId_professor( $_POST["id"] );
          $this->dao->alterar( $this->obj);
          break;
      }
   }
   public function prepararObjeto() {
      $this->obj->setNome($_POST["nome"]);
	$this->obj->setEmail($_POST["email"]);
	$this->obj->setEspecialidade($_POST["especialidade"]);
	$this->obj->setData_admissao($_POST["data_admissao"]);
	
   }
}
new ProfessorControl;
?>
