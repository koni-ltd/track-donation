@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center g-5">
            <div class="col-12">
                <div class="text-center mb-2">
                    <p class="fs-1 fw-bold text-white mb-0">Track Donationについて</p>
                </div>
                <div class="text-center text-white">
                    <p class="mb-4">
                        Symbolを用いて寄付をしたトランザクションを追跡して、寄付の使途を追跡できるプラットフォームです。<br>
                        寄付金がどのように使われているかを確認できることで、寄付金の流れを透明化します。
                    </p>
                    <div class="d-flex justify-content-center">
                        <div class="border border-white p-4">
                            <div class="fw-bold mb-1">1. Wallet から団体のアドレスへ寄付をする</div>
                            <div class="fw-bold">2. 発行されたトランザクションからハッシュを入力して追跡する</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="neon-border p-4 p-lg-5">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger" role="alert">
                                {{ $error }}
                            </div>
                        @endforeach
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="text-center mb-3 mb-lg-5">
                        <p class="fs-1 fw-bold text-white mb-0">寄付先団体一覧</p>
                        <p><a class="text-secondary" href="{{ route('register') }}">団体登録はこちら</a></p>
                    </div>

                    <div class="row row-cols-1 row-cols-lg-4 g-3">
                        @foreach ($users as $user)
                            <div class="col">
                                <div class="card h-100">
                                    @if (!empty($user->image))
                                        <img src="{{ asset($user->image) }}" alt="{{ $user->name }}" class="card-img-top">
                                    @else
                                        <img src="{{ asset('images/img-track-donation.png') }}" class="card-img-top">
                                    @endif
                                    <div class="card-body">
                                        <h5 class="card-title fw-bold">{{ $user->name }}</h5>
                                        <p class="card-text mb-1"><small
                                                class="text-body-secondary">{{ $user->category->name ?? '未設定' }}</small>
                                        </p>
                                        <p class="card-text">{{ $user->description }}</p>
                                    </div>
                                    <div class="card-footer bg-white border-top-0">
                                        <button type="button" class="btn btn-dark w-100" data-bs-toggle="modal"
                                            data-bs-target="#modal-{{ $user->id }}">
                                            寄付する
                                        </button>
                                    </div>
                                </div>
                                <!-- Modal -->
                                <div class="modal fade" id="modal-{{ $user->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5 fw-bold" id="exampleModalLabel">
                                                    Organization
                                                    Name&nbsp;&nbsp;-&nbsp;&nbsp;{{ $user->name }}
                                                </h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-4 p-lg-5">
                                                <div class="row g-4">
                                                    <div class="col-12">
                                                        <div class="fw-bold mb-2">1. Wallet から団体のアドレスへ寄付をする</div>
                                                        <div class="row g-3 align-items-center">
                                                            <div class="col-auto">
                                                                <label class="col-form-label">Organization
                                                                    Symbol Address</label>
                                                            </div>
                                                            <div class="col">
                                                                <input class="form-control" type="text"
                                                                    value="{{ $user->address }}" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="fw-bold mb-2">2. 発行されたトランザクションからハッシュを入力して追跡する</div>
                                                        <form class="row g-3" action="{{ route('transaction') }}"
                                                            method="POST">
                                                            @csrf
                                                            <input type="hidden" name="user_id"
                                                                value="{{ $user->id }}">
                                                            <div class="col">
                                                                <input type="text" class="form-control" name="hash"
                                                                    placeholder="トランザクションハッシュを入力してください">
                                                            </div>
                                                            <div class="col-auto">
                                                                <button type="submit" class="btn btn-dark">追跡する</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
