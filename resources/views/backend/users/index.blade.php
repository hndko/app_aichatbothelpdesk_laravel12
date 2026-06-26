@extends('layouts.app-backend')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h4 class="mb-1 fw-bold">{{ $title }}</h4>
        <p class="text-muted small mb-0">Daftar pengguna terdaftar di sistem NexusDesk AI</p>
    </div>
</div>

<div class="nd-card mb-4 animate-fade-in">
    <div class="nd-card-body py-3 px-4">
        <form action="{{ route('users.index') }}" method="GET" class="row g-2 align-items-center">
            <div class="col-md-5">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control bg-light border-start-0" placeholder="Cari Nama atau Email..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-sm btn-nd-primary w-100">Cari</button>
            </div>
            @if(request()->has('search'))
                <div class="col-md-1">
                    <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-secondary w-100"><i class="bi bi-x-lg"></i></a>
                </div>
            @endif
        </form>
    </div>
</div>

<div class="nd-table animate-slide-up">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Role</th>
                    <th>No. Telepon</th>
                    <th>Terdaftar Sejak</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td class="text-muted">#{{ $user->id }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="topbar-user-avatar" style="width:34px;height:34px;font-size:0.8rem;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold text-dark">{{ $user->name }}</div>
                                    <small class="text-muted">{{ $user->email }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge-status badge-role-{{ $user->role }}">
                                {{ strtoupper($user->role) }}
                            </span>
                        </td>
                        <td>{{ $user->phone ?? '-' }}</td>
                        <td>{{ $user->created_at->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <p class="text-muted mb-0">Belum ada data user.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
        <div class="p-3 border-top d-flex justify-content-end">
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection
