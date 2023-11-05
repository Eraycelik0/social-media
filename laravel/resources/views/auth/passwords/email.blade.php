@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Şifre Sıfırlama</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="form-group">
                                <label for="email">E-posta Adresi</label>
                                <input type="email" id="email" name="email" class="form-control" required autofocus>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                Şifre Sıfırlama Bağlantısı Gönder
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
