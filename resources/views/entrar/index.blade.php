@extends('layout')

@section('cabecalho')
    Entrar
@endsection

@section('conteudo')
    @include('erros', ['errors'=> $errors])

    <form method="post" action="">
        @csrf
        <div class="form-group">
            <label for="email">E-mail</label>
            <input type="email" name="email" id="email" required class="form-control">
        </div>

        <div class="form-group">
            <label for="password">Senha</label>
            <input type="password" class="form-control" name="password" id="password">
        </div>

        <button class="btn btn-primary mt-3" type="submit">
            Entrar
        </button>

        <a href="#" class="btn btn-secondary mt-3">
            Registrar-se
        </a>
    </form>
@endsection
