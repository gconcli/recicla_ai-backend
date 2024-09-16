<?php
    abstract class ObjetoVO {
        private $id;
        private $dataCriacao;
        private $ativo;

        protected function __construct() {
            $this->id = 0;
            $this->dataCriacao = 'YYYY-MM-dd';
            $this->ativo = false;
        }

        public function getId() : int {return $this->id;}
        public function setId(int $id) : void {$this->id = $id;}

        public function getDataCriacao() : string {return $this->dataCriacao;}
        public function setDataCriacao(String $dataCriacao) : void {$this->dataCriacao = $dataCriacao;}

        public function isAtivo() : bool {return $this->ativo;}
        public function setAtivo(bool $ativo) : void {$this->ativo = $ativo;}
    }

    class UsuarioVO extends ObjetoVO {
        private static $nomeTabela;
        private static $nomesColunasTabela;
        private static $quantColunasTabela;

        private $idImagem;
        private $idTipoUsuario;
        private $login;
        private $senha;
        private $nome;
        private $email;
        private $dataAniversario;
        private $descricao;

        public function __construct() {
            parent::__construct();

        }
    }

    class UsuarioDAOMySQL implements IUsuarioDAO{
        #[Override]
        public function insert(UsuarioVO $uVO): void{
            $sql = "INSERT INTO usuarios (loginUsuario, senhaUsuario, nomeUsuario, emailUsuario, dataAniversarioUsuario, descricaoUsuario, dataCriacaoUsuario, usuarioAtivo) VALUES "
        }
        public function selectAll(): UsuarioVO{

        }
        public function selectWhere(UsuarioVO $uVO): UsuarioVO{

        }
        public function update(UsuarioVO $uVO): UsuarioVO{

        }
        public function delete(UsuarioVO $uVO): UsuarioVO{

        }
    }

    
?>