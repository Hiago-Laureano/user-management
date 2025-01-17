<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\StoreUpdateUsuarioRequest;
use App\Http\Resources\v1\UsuarioResource;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UsuarioController extends Controller
{
    // Número de registros por página (GET todos os dados)
    const PAGINATION = 15;


    // Informações para a documentação da API pelo Swagger (GET ALL)
    /**
     * @OA\Get(
     *     tags={"/v1/usuarios"},
     *     path="/v1/usuarios",
     *     summary="Obter lista de usuários",
     *     description="Retorna uma lista com todos usuários",
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Número da paginação dos dados. São 15 registros por paginação",
     *         @OA\Schema(type="integer"),
     *         style="form"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 description="Dados da requisição",
     *                 @OA\items(ref="#/components/schemas/Usuário"),
     *             ),
     *             @OA\Property(property="links", type="object", description="Links da paginação",
     *                 example={"first": "http:localhost/api/v1/usuarios?page=1", 
     *                          "last": "http:localhost/api/v1/usuarios?page=3",
     *                          "prev": "http:localhost/api/v1/usuarios?page=1",
     *                          "next": "http:localhost/api/v1/usuarios?page=3"
     *                 }
     *             )
     *         )
     *     )
     * )
     */
    public function index(Request $request){
        return UsuarioResource::collection(Usuario::paginate(self::PAGINATION));
    }

    // Informações para a documentação da API pelo Swagger (GET ONE)
    /**
     * @OA\Get(
     *     tags={"/v1/usuarios"},
     *     path="/v1/usuarios/{id}",
     *     summary="Obter usuário específico",
     *     description="Retorna um usuário específico",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id do usuário",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         style="form"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Usuário")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Registro não encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function show(Request $request, int $id){
        $user = Usuario::findOrFail($id);
        return new UsuarioResource($user);
    }

    // Informações para a documentação da API pelo Swagger (POST)
    /**
     * @OA\Post(
     *     tags={"/v1/usuarios"},
     *     path="/v1/usuarios",
     *     summary="Registrar novo usuarios",
     *     description="Cria um novo usuarios",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"nome", "email", "senha"},
     *             @OA\Property(property="nome", type="string", description="Nome do usuário"), 
     *             @OA\Property(property="email", type="string", format="email", description="E-mail do usuário"), 
     *             @OA\Property(property="senha", type="string", description="Senha - Mínimo 6 caracteres, contendo ao menos uma letra maiúscula, uma minúscula, um número e um caractere especial."), 
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Novo registro criado",
     *         @OA\JsonContent(ref="#/components/schemas/Usuário")
     *     ),
     *     @OA\Response(
     *         response=420,
     *         description="Erro de validação",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", pattern="O campo x é obrigatório. (+ 3 erros)"),
     *             @OA\Property(property="errors", type="object", description="Campos com erro de validação e lista dos erros",
     *                 example={"campo_x": {"O campo x é obrigatório."}, 
     *                          "campo_y": {"O campo y deve ser um inteiro."},
     *                          "campo_z": {"O campo z deve ter no máximo 30 caracteres."},
     *                          "campo_w": {"O campo w é obrigatório."}
     *                 }
     *             )
     *         )
     *     )
     * )
     */
    public function store(StoreUpdateUsuarioRequest $request){
        $data = $request->validated();
        $user = Usuario::create($data);
        return new UsuarioResource($user);
    }

    // Informações para a documentação da API pelo Swagger (PUT e PATCH)
    /**
     * @OA\Put(
     *     tags={"/v1/usuarios"},
     *     path="/v1/usuarios{id}",
     *     summary="Atualizar usuário",
     *     description="Atualiza todos os dados de um usuário",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id do usuário",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         style="form"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"nome", "email", "senha"},
     *             @OA\Property(property="nome", type="string", description="Nome do usuário"), 
     *             @OA\Property(property="email", type="string", format="email", description="E-mail do usuário"), 
     *             @OA\Property(property="senha", type="string", description="Senha - Mínimo 6 caracteres, contendo ao menos uma letra maiúscula, uma minúscula, um número e um caractere especial."), 
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Registro atualizado",
     *         @OA\JsonContent(ref="#/components/schemas/Usuário")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Registro não encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=420,
     *         description="Erro de validação",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", pattern="O campo x é obrigatório. (+ 3 erros)"),
     *             @OA\Property(property="errors", type="object", description="Campos com erro de validação e lista dos erros",
     *                 example={"campo_x": {"O campo x é obrigatório."}, 
     *                          "campo_y": {"O campo y deve ser um inteiro."},
     *                          "campo_z": {"O campo z deve ter no máximo 30 caracteres."},
     *                          "campo_w": {"O campo w é obrigatório."}
     *                 }
     *             )
     *         )
     *     )
     * )
     *
     * @OA\Patch(
     *     tags={"/v1/usuarios"},
     *     path="/v1/usuarios{id}",
     *     summary="Atualizar parcialmente usuário",
     *     description="Atualiza parcialmente os dados de um usuário",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id do usuário",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         style="form"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"nome", "email", "senha"},
     *             @OA\Property(property="nome", type="string", description="Nome do usuário"), 
     *             @OA\Property(property="email", type="string", format="email", description="E-mail do usuário"), 
     *             @OA\Property(property="senha", type="string", description="Senha - Mínimo 6 caracteres, contendo ao menos uma letra maiúscula, uma minúscula, um número e um caractere especial."), 
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Registro atualizado",
     *         @OA\JsonContent(ref="#/components/schemas/Usuário")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Registro não encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=420,
     *         description="Erro de validação",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", pattern="O campo x deve ser um inteiro. (+ 2 erros)"),
     *             @OA\Property(property="errors", type="object", description="Campos com erro de validação e lista dos erros",
     *                 example={"campo_x": {"O campo x deve ser um inteiro."}, 
     *                          "campo_y": {"O campo y deve ser um inteiro."},
     *                          "campo_z": {"O campo z deve ter no máximo 30 caracteres."}
     *                 }
     *             )
     *         )
     *     )
     * )
     */
    public function update(StoreUpdateUsuarioRequest $request, int $id){
        $data = $request->validated();
        $user = Usuario::findOrFail($id);
        $user->update($data);
        return new UsuarioResource($user);
    }

    // Informações para a documentação da API pelo Swagger (DELETE)
    /**
     * @OA\Delete(
     *     tags={"/v1/usuarios"},
     *     path="/v1/usuarios/{id}",
     *     summary="Deletar usuário",
     *     description="Deleta um usuário",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id do usuário",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         style="form"
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Sucesso, sem corpo de resposta"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Registro não encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function destroy(Request $request, int $id){
        $user = Usuario::findOrFail($id);
        $user->delete();
        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
