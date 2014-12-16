CREATE TABLE tbl_pontos (
    id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    uf VARCHAR(2) NOT NULL,
    cidade INT(4),
    endereco varchar(100),
    nome varchar(60)
);

INSERT INTO tbl_user (uf,cidade,endereco,nome) VALUES ('MG', '2700', 'Av Afonso Pena 500','Posto 1');
INSERT INTO tbl_user (uf,cidade,endereco,nome) VALUES ('MG', '2700', 'Av Amazonas 1500','Posto 2');
INSERT INTO tbl_user (uf,cidade,endereco,nome) VALUES ('MG', '2700', 'Av do Contorno 2000','Posto 3');