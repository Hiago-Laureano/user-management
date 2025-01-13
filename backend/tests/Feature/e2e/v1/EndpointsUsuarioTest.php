<?php

use App\Models\Usuario;

use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\patchJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

beforeEach(function(){
    $this->user = Usuario::create(["nome" => "José", "email" => "email@test.com", "senha" => "12345"]);
    $this->headers = ["Content-Type" => "application/json", "X-Requested-With" => "XMLHttpRequest"];
    $this->data = ["nome" => "User", "email" => fake()->unique()->email, "senha" => "1@sW23"];
    $this->structureGet = [
        "id",
        "nome",
        "email",
        "criado_em",
        "atualizado_em"
    ];
});

// TEST GET ALL /api/v1/usuarios ====================================================================================
describe("GET ALL /api/v1/usuarios", function(){
    test('Request successful', function() {
        getJson("/api/v1/usuarios", headers: $this->headers)
        ->assertStatus(200)
        ->assertJsonStructure([
            "data" => [
                "*" => $this->structureGet
            ],
            "links" => [
                "first",
                "last",
                "prev",
                "next"
            ]
        ]);
    });
});

// TEST GET ONE /api/v1/usuarios{id} ====================================================================================
describe("GET ONE /api/v1/usuarios", function(){
    test('Request failed not found', function() {
        getJson("/api/v1/usuarios/100", headers: $this->headers)
        ->assertStatus(404)
        ->assertJsonStructure(["message"]);
    });    

    test('Request successful', function() {
        getJson("/api/v1/usuarios/{$this->user->id}", headers: $this->headers)
        ->assertStatus(200)
        ->assertJsonStructure(["data" => $this->structureGet]);
    });
});

// TEST POST /api/v1/usuarios ====================================================================================
describe("POST /api/v1/usuarios", function(){
    test('Request successful', function() {
        postJson("/api/v1/usuarios", $this->data, $this->headers)
        ->assertStatus(201)
        ->assertJsonStructure(["data" => $this->structureGet]);
    });
    describe("validation", function(){
        test('Request failed field required', function($field) {
            unset($this->data[$field]);
            postJson("/api/v1/usuarios", $this->data, $this->headers)
            ->assertStatus(422)
            ->assertJsonStructure(["message", "errors"])
            ->assertJsonValidationErrors([$field => trans("validation.required", ["attribute" => $field])]);
        })->with(["nome", "email", "senha"]);

        test('Request failed field email already in use', function() {
            $this->data["email"] = "email@test.com";
            postJson("/api/v1/usuarios", $this->data, $this->headers)
            ->assertStatus(422)
            ->assertJsonStructure(["message", "errors"])
            ->assertJsonValidationErrors(["email" => trans("validation.unique", ["attribute" => "email"])]);
        });
        
        test('Request failed weak password smaller than 6 characters', function() {
            $this->data["senha"] = "1@sW2";
            postJson("/api/v1/usuarios", $this->data, $this->headers)
            ->assertStatus(422)
            ->assertJsonStructure(["message", "errors"])
            ->assertJsonValidationErrors(["senha" => trans("validation.min.string", ["attribute" => "senha", "min" => "6"])]);
        });
        
        test('Request failed weak password without number', function() {
            $this->data["senha"] = "x@sWxx";
            postJson("/api/v1/usuarios", $this->data, $this->headers)
            ->assertStatus(422)
            ->assertJsonStructure(["message", "errors"])
            ->assertJsonValidationErrors(["senha" => trans("validation.password.numbers", ["attribute" => "senha"])]);
        });
        
        test('Request failed weak password without symbol', function() {
            $this->data["senha"] = "11sW23";
            postJson("/api/v1/usuarios", $this->data, $this->headers)
            ->assertStatus(422)
            ->assertJsonStructure(["message", "errors"])
            ->assertJsonValidationErrors(["senha" => trans("validation.password.symbols", ["attribute" => "senha"])]);
        });
        
        test('Request failed weak password without uppercase letter', function() {
            $this->data["senha"] = "1@sx23";
            postJson("/api/v1/usuarios", $this->data, $this->headers)
            ->assertStatus(422)
            ->assertJsonStructure(["message", "errors"])
            ->assertJsonValidationErrors(["senha" => trans("validation.password.mixed", ["attribute" => "senha"])]);
        });

        test('Request failed weak password without lowercase letter', function() {
            $this->data["senha"] = "1@XW23";
            postJson("/api/v1/usuarios", $this->data, $this->headers)
            ->assertStatus(422)
            ->assertJsonStructure(["message", "errors"])
            ->assertJsonValidationErrors(["senha" => trans("validation.password.mixed", ["attribute" => "senha"])]);
        });
    });
});

// TEST PUT /api/v1/usuarios ====================================================================================
describe("PUT /api/v1/usuarios", function(){
    test('Request successful', function() {
        putJson("/api/v1/usuarios/{$this->user->id}", $this->data, $this->headers)
        ->assertStatus(200)
        ->assertJsonStructure(["data" => $this->structureGet]);
    });
    describe("validation", function(){
        test('Request failed field required', function($field) {
            unset($this->data[$field]);
            putJson("/api/v1/usuarios/{$this->user->id}", $this->data, $this->headers)
            ->assertStatus(422)
            ->assertJsonStructure(["message", "errors"])
            ->assertJsonValidationErrors([$field => trans("validation.required", ["attribute" => $field])]);
        })->with(["nome", "email", "senha"]);

        test('Request failed field email already in use', function() {
            $this->data["email"] = "email@test.com";
            putJson("/api/v1/usuarios/{$this->user->id}", $this->data, $this->headers)
            ->assertStatus(422)
            ->assertJsonStructure(["message", "errors"])
            ->assertJsonValidationErrors(["email" => trans("validation.unique", ["attribute" => "email"])]);
        });
        
        test('Request failed weak password smaller than 6 characters', function() {
            $this->data["senha"] = "1@sW2";
            putJson("/api/v1/usuarios/{$this->user->id}", $this->data, $this->headers)
            ->assertStatus(422)
            ->assertJsonStructure(["message", "errors"])
            ->assertJsonValidationErrors(["senha" => trans("validation.min.string", ["attribute" => "senha", "min" => "6"])]);
        });
        
        test('Request failed weak password without number', function() {
            $this->data["senha"] = "x@sWxx";
            putJson("/api/v1/usuarios/{$this->user->id}", $this->data, $this->headers)
            ->assertStatus(422)
            ->assertJsonStructure(["message", "errors"])
            ->assertJsonValidationErrors(["senha" => trans("validation.password.numbers", ["attribute" => "senha"])]);
        });
        
        test('Request failed weak password without symbol', function() {
            $this->data["senha"] = "11sW23";
            putJson("/api/v1/usuarios/{$this->user->id}", $this->data, $this->headers)
            ->assertStatus(422)
            ->assertJsonStructure(["message", "errors"])
            ->assertJsonValidationErrors(["senha" => trans("validation.password.symbols", ["attribute" => "senha"])]);
        });
        
        test('Request failed weak password without uppercase letter', function() {
            $this->data["senha"] = "1@sx23";
            putJson("/api/v1/usuarios/{$this->user->id}", $this->data, $this->headers)
            ->assertStatus(422)
            ->assertJsonStructure(["message", "errors"])
            ->assertJsonValidationErrors(["senha" => trans("validation.password.mixed", ["attribute" => "senha"])]);
        });

        test('Request failed weak password without lowercase letter', function() {
            $this->data["senha"] = "1@XW23";
            putJson("/api/v1/usuarios/{$this->user->id}", $this->data, $this->headers)
            ->assertStatus(422)
            ->assertJsonStructure(["message", "errors"])
            ->assertJsonValidationErrors(["senha" => trans("validation.password.mixed", ["attribute" => "senha"])]);
        });
    });
});

// TEST PATCH /api/v1/usuarios ====================================================================================
describe("PATCH /api/v1/usuarios", function(){
    test('Request successful', function() {
        patchJson("/api/v1/usuarios/{$this->user->id}", $this->data, $this->headers)
        ->assertStatus(200)
        ->assertJsonStructure(["data" => $this->structureGet]);
    });
    describe("validation", function(){
        test('Request successful without field', function($field) {
            unset($this->data[$field]);
            patchJson("/api/v1/usuarios/{$this->user->id}", $this->data, $this->headers)
            ->assertStatus(200)
            ->assertJsonStructure(["data" => $this->structureGet]);
        })->with(["nome", "email", "senha"]);

        test('Request failed field email already in use', function() {
            $this->data["email"] = "email@test.com";
            patchJson("/api/v1/usuarios/{$this->user->id}", $this->data, $this->headers)
            ->assertStatus(422)
            ->assertJsonStructure(["message", "errors"])
            ->assertJsonValidationErrors(["email" => trans("validation.unique", ["attribute" => "email"])]);
        });
        
        test('Request failed weak password smaller than 6 characters', function() {
            $this->data["senha"] = "1@sW2";
            patchJson("/api/v1/usuarios/{$this->user->id}", $this->data, $this->headers)
            ->assertStatus(422)
            ->assertJsonStructure(["message", "errors"])
            ->assertJsonValidationErrors(["senha" => trans("validation.min.string", ["attribute" => "senha", "min" => "6"])]);
        });
        
        test('Request failed weak password without number', function() {
            $this->data["senha"] = "x@sWxx";
            patchJson("/api/v1/usuarios/{$this->user->id}", $this->data, $this->headers)
            ->assertStatus(422)
            ->assertJsonStructure(["message", "errors"])
            ->assertJsonValidationErrors(["senha" => trans("validation.password.numbers", ["attribute" => "senha"])]);
        });
        
        test('Request failed weak password without symbol', function() {
            $this->data["senha"] = "11sW23";
            patchJson("/api/v1/usuarios/{$this->user->id}", $this->data, $this->headers)
            ->assertStatus(422)
            ->assertJsonStructure(["message", "errors"])
            ->assertJsonValidationErrors(["senha" => trans("validation.password.symbols", ["attribute" => "senha"])]);
        });
        
        test('Request failed weak password without uppercase letter', function() {
            $this->data["senha"] = "1@sx23";
            patchJson("/api/v1/usuarios/{$this->user->id}", $this->data, $this->headers)
            ->assertStatus(422)
            ->assertJsonStructure(["message", "errors"])
            ->assertJsonValidationErrors(["senha" => trans("validation.password.mixed", ["attribute" => "senha"])]);
        });

        test('Request failed weak password without lowercase letter', function() {
            $this->data["senha"] = "1@XW23";
            patchJson("/api/v1/usuarios/{$this->user->id}", $this->data, $this->headers)
            ->assertStatus(422)
            ->assertJsonStructure(["message", "errors"])
            ->assertJsonValidationErrors(["senha" => trans("validation.password.mixed", ["attribute" => "senha"])]);
        });
    });
});

// TEST DELETE /api/v1/usuarios{id} ====================================================================================
describe("DELETE /api/v1/usuarios", function(){
    test('Request failed not found', function() {
        deleteJson("/api/v1/usuarios/100", headers:  $this->headers)
        ->assertStatus(404)
        ->assertJsonStructure(["message"]);
    });

    test('Request successful', function() {
        deleteJson("/api/v1/usuarios/{$this->user->id}", headers:  $this->headers)
        ->assertStatus(204);
    });
});