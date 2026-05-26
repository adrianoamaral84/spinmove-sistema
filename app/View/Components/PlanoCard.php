<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PlanoCard extends Component
{
    public $titulo;
    public $descricao;
    public $preco;
    public $link;
    public $badge;
    public $destaque;

    public function __construct(
        $titulo,
        $descricao,
        $preco,
        $link,
        $badge = null,
        $destaque = false
    ) {
        $this->titulo = $titulo;
        $this->descricao = $descricao;
        $this->preco = $preco;
        $this->link = $link;
        $this->badge = $badge;
        $this->destaque = $destaque;
    }

    public function render()
    {
        return view('components.plano-card');
    }
}