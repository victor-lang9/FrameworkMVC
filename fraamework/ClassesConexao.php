<?php

//Retirar na versão final o valor da variável "usuario" e "senha".

class ClassesConexao{
private $entidades;
    private $caminho = "sistema/model/";
    function __construct($banco,$host) {
       $this->criaClasse($banco,$host);
    }
    function criaClasse($banco,$host) {
               $conteudo = <<<CLASS
                <?php
                class Conexao{
                    public static function conectar():PDO{
                        try {
                            \$host = "$host";
                            \$banco = "$banco";
                            \$usuario = "root";
                            \$senha = "bancodedados";
                            \$pdo = new PDO(
                                "mysql:host=\$host;dbname=\$banco;charset=utf8",
                                \$usuario,
                                \$senha
                            );
                            return \$pdo;
                        } catch (PDOException \$e) {
                           echo "Erro na conexão: " . \$e->getMessage();
                        }
                    }
                }
                ?>
                CLASS;
                file_put_contents("{$this->caminho}conexao.php", $conteudo);
        }
    }

?>