@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center g-3">
            {{-- <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form class="row g-3">
                            <div class="col">
                                <input type="text" class="form-control" value="">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary">検索する</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div> --}}

            <div class="col-12">
                <div class="card">
                    <div class="card-body p-4 p-lg-5">
                        <p class="fs-1 fw-bold mb-4">Organization</p>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col" class="">Organization Name</th>
                                        {{-- <th scope="col" class="text-nowrap">Node</th> --}}
                                        {{-- <th scope="col" class="text-nowrap">Symbol Address</th> --}}
                                        <th scope="col" class="text-nowrap">Description</th>
                                        <th scope="col">&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td class="align-middle">{{ $user->name }}</td>
                                            {{-- <td class="align-middle">{{ $user->node }}</td> --}}
                                            {{-- <td class="align-middle">{{ $user->address }}</td> --}}
                                            <td class="align-middle">{{ $user->description }}</td>
                                            <td class="align-middle">
                                                <div class="d-flex justify-content-end">
                                                    <button type="button" class="btn btn-dark text-nowrap"
                                                        data-bs-toggle="modal" data-bs-target="#modal-{{ $user->id }}">
                                                        Send Donation
                                                    </button>
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
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body p-4 p-lg-5">
                                                                <div class="row g-4">
                                                                    <div class="col-12">
                                                                        <div class="fw-bold mb-2">1. Walletから寄付をする</div>
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
                                                                        <div class="fw-bold mb-2">2. Symbolを追跡する</div>
                                                                        <form class="row g-3"
                                                                            action="{{ route('transaction') }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="user_id"
                                                                                value="{{ $user->id }}">
                                                                            <div class="col">
                                                                                <input type="text" class="form-control"
                                                                                    name="hash"
                                                                                    placeholder="トランザクションハッシュを入力してください">
                                                                            </div>
                                                                            <div class="col-auto">
                                                                                <button type="submit"
                                                                                    class="btn btn-dark">Tracking</button>
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
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
