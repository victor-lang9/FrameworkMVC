<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
    error_reporting(E_ALL);
  require_once __DIR__.'/../control/cursoControl.php';
  $_REQUEST['acao'] = 2;
  $control = new CursoControl();
  $dados = $control->executaAcao();
?>
<html>
    <head>
        <title>Lista de curso</title>
          <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
    <table>
    <tr> <td>id_curso</td>
<td>nome</td>
<td>carga_horaria</td>
<td>descricao</td>
<td>id_professor</td>
<td colspan='2'>Gerenciar</td>
</tr>
     <?php
        foreach ($dados as $dado) {
      ?>
    <tr><td><?php echo $dado['id_curso']?></td>
<td><?php echo $dado['nome']?></td>
<td><?php echo $dado['carga_horaria']?></td>
<td><?php echo $dado['descricao']?></td>
<td><?php echo $dado['id_professor']?></td>
<td>
            <a href='../control/cursoControl.php?acao=3&id=<?php echo $dado['id_curso'] ?>'>Excluir</a></td>
<td><a href='../control/cursoControl.php?acao=4&id=<?php echo $dado['id_curso'] ?>'>Alterar</a></td>
</tr>
    <?php
    }
    ?>
    </table>
    </body>
</html>