<?php

namespace App\Http\Resources\v1;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UsuarioResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "nome" => $this->nome,
            "email" => $this->email,
            "criado_em" => $this->criado_em ? Carbon::make($this->criado_em)->format("d/m/Y H:i:s") : $this->criado_em,
            "atualizado_em" => $this->atualizado_em ? Carbon::make($this->criado_em)->format("d/m/Y H:i:s"): $this->atualizado_em
        ];
    }
}
