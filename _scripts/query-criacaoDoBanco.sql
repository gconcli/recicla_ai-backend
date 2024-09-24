-- Tabela de Imagens
CREATE TABLE IF NOT EXISTS Imagem (
    idImagem INT NOT NULL,
    
    caminhoImagem VARCHAR(260) NOT NULL,
    descricaoImagem VARCHAR(500) NULL,
    
    dataCriacaoImagem DATE NOT NULL,
    imagemAtiva TINYINT(1) NOT NULL DEFAULT 1
);
-- Chave Primária
ALTER TABLE Imagem ADD CONSTRAINT PK_IMAGEM PRIMARY KEY(idImagem);
ALTER TABLE Imagem CHANGE COLUMN idImagem idImagem INT NOT NULL AUTO_INCREMENT;

-- Tabela de Tipos de Usuario
CREATE TABLE IF NOT EXISTS TipoUsuario (
    idTipoUsuario INT NOT NULL,
    
    nomeTipoUsuario VARCHAR(50) NOT NULL UNIQUE,
    descricaoTipoUsuario VARCHAR(500) NULL,
    
    dataCriacaoTipoUsuario DATE NOT NULL,
    tipoUsuarioAtivo TINYINT(1) NOT NULL DEFAULT 1
);
-- Chave Primária
ALTER TABLE TipoUsuario ADD CONSTRAINT PK_TIPOUSUARIO PRIMARY KEY(idTipoUsuario);
ALTER TABLE TipoUsuario CHANGE COLUMN idTipoUsuario idTipoUsuario INT NOT NULL AUTO_INCREMENT;

-- Tabela de Usuarios
CREATE TABLE IF NOT EXISTS Usuario (
    idUsuario INT NOT NULL,

    idImagemUsuario INT NULL,
    idTipoUsuario INT NOT NULL,
    
    loginUsuario VARCHAR(50) NOT NULL UNIQUE,
    senhaUsuario CHAR(60) NOT NULL,
    nomeUsuario VARCHAR(50) NOT NULL,
    emailUsuario VARCHAR(70) NOT NULL,
    dataAniversarioUsuario DATE NOT NULL,
    descricaoUsuario VARCHAR(500) NULL,
    
    dataCriacaoUsuario DATE NOT NULL,
    usuarioAtivo TINYINT(1) NOT NULL DEFAULT 1
);
-- Chave Primária
ALTER TABLE Usuario ADD CONSTRAINT PK_USUARIO PRIMARY KEY(idUsuario);
ALTER TABLE Usuario CHANGE COLUMN idUsuario idUsuario INT NOT NULL AUTO_INCREMENT;
-- Chaves Estrangeiras
ALTER TABLE Usuario ADD CONSTRAINT FK_USUARIO_IMAGEM FOREIGN KEY(idImagemUsuario) REFERENCES Imagem(idImagem);
ALTER TABLE Usuario ADD CONSTRAINT FK_USUARIO_TIPOUSUARIO FOREIGN KEY(idTipoUsuario) REFERENCES TipoUsuario(idTipoUsuario);