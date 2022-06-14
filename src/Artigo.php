<?php

namespace DeboraMind\Blog;

use mysqli;

class Artigo
{
    private mysqli $mysql;

    public function __construct(mysqli $mysql)
    {
        $this->mysql = $mysql;
    }

    public function exibirTodos(): array
    {

        $resultado = $this->mysql->query('SELECT id, titulo, conteudo FROM artigos');
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    public function encontrarPorId(string $id): array
    {
        $selecionaArtigo = $this->mysql->prepare('SELECT id, titulo, conteudo FROM artigos WHERE id = ?');
        $selecionaArtigo->bind_param('s', $id);
        $selecionaArtigo->execute();
        return $selecionaArtigo->get_result()->fetch_assoc();
    }

    public function adicionar(string $titulo, string $conteudo): void
    {
        $insereArtigo = $this->mysql->prepare('INSERT INTO artigos(titulo, conteudo) VALUES (?, ?);');
        $insereArtigo->bind_param('ss', $titulo, $conteudo);
        $insereArtigo->execute();
    }

    public function excluir($id): void
    {
        $excluiArtigo = $this->mysql->prepare('DELETE FROM artigos WHERE id = ?');
        $excluiArtigo->bind_param('s', $id);
        $excluiArtigo->execute();
    }

    public function editar($id, $titulo, $conteudo): void
    {
        $editarArtigo = $this->mysql->prepare('UPDATE artigos SET titulo = ?, conteudo = ? WHERE id = ?');
        $editarArtigo->bind_param('sss', $titulo, $conteudo, $id);
        $editarArtigo->execute();
    }
}
