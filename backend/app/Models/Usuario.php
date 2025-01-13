<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// Informações para a documentação da API pelo Swagger (Modelo Usuário)
/**
 * @OA\Schema(
 *     schema="Usuário",
 *     title="Usuário",
 *     description="Modelo Usuário",
 *     @OA\Property(property="id", type="integer", description="Id do usuário"),
 *     @OA\Property(property="nome", type="string", description="Nome"),
 *     @OA\Property(property="email", type="string", description="E-mail"),
 *     @OA\Property(property="senha", type="string", description="Senha - Mínimo 6 caracteres, contendo ao menos uma letra maiúscula, uma minúscula, um número e um caractere especial."),
 *     @OA\Property(property="criado_em", type="string", pattern="10/01/2024 15:12:40", description="Data da criação do registro"),
 *     @OA\Property(property="atualizado_em", type="string", pattern="10/01/2024 15:15:30", description="Data da atualização do registro"),
 * )
 */
class Usuario extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nome',
        'email',
        'senha',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'senha',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'senha' => 'hashed'
        ];
    }
}
