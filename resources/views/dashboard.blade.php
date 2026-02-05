<x-layout>
    <div class="container mt-4">

        @auth
        <h1>Dashboard</h1>
        Halo {{ Auth::user()->name }}.

        <a href="{{ route('logout') }}"
            onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
            Log out
        </a>

        <form id="logout-form"
            action="{{ route('logout') }}"
            method="post"
            style="display: none;">
            @csrf
        </form>

        <div class="mt-3 mb-3">
            <a href="{{ route('polis.create') }}" class="btn btn-primary">
                Pengajuan Polis
            </a>
        </div>

        <h3 class="mb-3">Daftar Polis</h3>

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>No Polis</th>
                            <th>Jenis Penanggungan</th>
                            <th>No Invoice</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($invoices as $invoice)
                        <tr>
                            {{-- No Polis --}}
                            <td>{{ $invoice->polis->nomor_polis ?? '-' }}</td>

                            {{-- Jenis Penanggungan --}}
                            <td>{{ $invoice->polis->jenis_penanggungan ?? '-' }}</td>

                            {{-- No Invoice --}}
                            <td>{{ $invoice->nomor_invoice }}</td>

                            {{-- Status --}}
                            <td>
                                @if($invoice->status == 'approved')
                                <span class="badge bg-success">Approved</span>
                                @elseif($invoice->status == 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                                @else
                                <span class="badge bg-secondary">
                                    {{ ucfirst($invoice->status ?? 'Draft') }}
                                </span>
                                @endif
                            </td>

                            {{-- Aksi --}}
                            <td>
                                <a
                                    class="btn btn-sm btn-primary">
                                    Lihat Rincian
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">
                                Tidak ada invoice.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @else
        <div class="alert alert-warning text-center">
            Anda harus login untuk melihat data polis.
        </div>
        @endauth

    </div>
</x-layout>