-- Tabela de Tipos de Usuario
CREATE TABLE IF NOT EXISTS TipoUsuario (
    idTipoUsuario INT NOT NULL,
    
    nomeTipoUsuario VARCHAR(50) NOT NULL UNIQUE
);
-- Chave Primária
ALTER TABLE TipoUsuario ADD CONSTRAINT PK_TIPOUSUARIO PRIMARY KEY(idTipoUsuario);
ALTER TABLE TipoUsuario CHANGE COLUMN idTipoUsuario idTipoUsuario INT NOT NULL AUTO_INCREMENT;

-- Tabela de Usuarios
CREATE TABLE IF NOT EXISTS Usuario (
    idUsuario INT NOT NULL,
    idTipoUsuario INT NOT NULL,
    
    loginUsuario VARCHAR(50) NOT NULL UNIQUE,
    senhaUsuario CHAR(60) NOT NULL,
    nomeUsuario VARCHAR(50) NOT NULL,
    emailUsuario VARCHAR(70) NOT NULL
);
-- Chave Primária
ALTER TABLE Usuario ADD CONSTRAINT PK_USUARIO PRIMARY KEY(idUsuario);
ALTER TABLE Usuario CHANGE COLUMN idUsuario idUsuario INT NOT NULL AUTO_INCREMENT;
-- Chaves Estrangeiras
ALTER TABLE Usuario ADD CONSTRAINT FK_USUARIO_TIPOUSUARIO FOREIGN KEY(idTipoUsuario) REFERENCES TipoUsuario(idTipoUsuario);