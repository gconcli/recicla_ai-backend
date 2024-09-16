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
        final private static $nomeTabela = "Usuario";
        final private static $nomesColunasTabela = [
            "idUsuario",

            "idImagemUsuario",
            "idTipoUsuario",
            "loginUsuario",
            "senhaUsuario",
            "nomeUsuario",
            "emailUsuario",
            "dataAniversarioUsuario",
            "descricaoUsuario",

            "dataCriacaoUsuario",
            "usuarioAtivo"
        ];

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
            $this->idImagem = 0;
            $this->idTipoUsuario = 0;
            $this->login = "Login";
            $this->senha = "Senha";
            $this->nome = "Nome";
            $this->email = "E-mail";
            $this->dataAniversario = 'YYYY-MM-dd';
            $this->descricao = "Descrição";
        }

        public static function getNomeTabela() {return self::$nomeTabela;}

        public static function getNomesColunasTabela() {return self::$nomesColunasTabela;}

        public function getIdImagem(): int {return $this->idImagem;}
        public function setIdImagem(int $idImagem): void {$this->idImagem = $idImagem;}

        public function getIdTipoUsuario(): int {return $this->idTipoUsuario;}
        public function setIdTipoUsuario(int $idTipoUsuario): void {$this->idTipoUsuario = $idTipoUsuario;}

        public function getLogin(): string {return $this->login;}
        public function setLogin(string $login): void {$this->login = $login;}

        public function getSenha(): string {return $this->senha;}
        public function setSenha(string $senha): void {$this->senha = $senha;}

        public function getNome(): string {return $this->nome;}
        public function setNome(string $nome): void {$this->nome = $nome;}

        public function getEmail(): string {return $this->email;}
        public function setEmail(string $email): void {$this->email = $email;}

        public function getDataAniversario(): string {return $this->dataAniversario;}
        public function setDataAniversario(string $dataAniversario): void {$this->dataAniversario = $dataAniversario;}

        public function getDescricao(): string {return $this->descricao;}
        public function setDescricao(string $descricao): void {$this->descricao = $descricao;}
    }

    class UsuarioDAOMySQL implements IUsuarioDAO {
        public function login(string $login, string $senha) : ?UsuarioVO {

        }
        public function insert(UsuarioVO $uVO): bool {
            $nomeTabela = UsuarioVO::getNomeTabela();
            $nomesColunasTabela = UsuarioVO::getNomesColunasTabela();
            $quantColunasTabela = count($nomesColunasTabela);

            $sqlInsertInto = "INSERT INTO $nomeTabela (";
            $sqlValues = "VALUES (";

            for ($i = 1; $i < $quantColunasTabela; $i++) { 
                if($i < $quantColunasTabela - 1) {
                    $sqlInsertInto .= $nomesColunasTabela[$i] . ", ";
                    $sqlValues .= "?, ";
                }
                else {
                    $sqlInsertInto .= $nomesColunasTabela[$i] . ") ";
                    $sqlValues .= "?)";
                }
            }

            $query = "$sqlInsertInto $sqlValues";

            
        }
        public function selectAll(): ?UsuarioVO {

        }
        public function selectWhere(UsuarioVO $uVO): ?UsuarioVO {

        }
        public function update(UsuarioVO $uVO): bool {

        }
        public function delete(UsuarioVO $uVO): bool {

        }
    }

    
?>