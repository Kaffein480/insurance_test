<x-layout>
    <div class="container mt-4">

        @auth
        <h1>Dashboard</h1>
        <div style="max-width: 900px; margin: 20px auto;">

            <span>Halo {{ Auth::user()->name }}.</span>

            <button
                type="button"
                style="float: right;"
                class="btn btn-sm btn-outline-danger"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Log out
            </button>

            <form id="logout-form"
                action="{{ route('logout') }}"
                method="POST"
                style="display: none;">
                @csrf
            </form>

        </div>

        @if (Auth::user()->isAdmin())
        <div class="mt-3 mb-3 text-start">
            <form action="{{ route('okupasi.update') }}" method="get" style="display: inline;">
                <button type="submit" class="btn btn-sm btn-primary px-3 py-1">
                    Update Okupasi
                </button>
            </form>
        </div>
        @endif

        @if (!Auth::user()->isAdmin())
        <div class="mt-3 mb-3 text-start">
            <form action="{{ route('polis.create') }}" method="get" style="display: inline;">
                <button type="submit" class="btn btn-sm btn-primary px-3 py-1">
                    Pengajuan Polis
                </button>
            </form>
        </div>
        @endif

        <h3 class="mb-3">Daftar Polis</h3>

        <div style="width: 100%; margin: 0 auto;">
            <div class="card" style="width: 100%;">
                <div class="card-body" style="width: 100%">
                    <table class="table table-bordered table-striped" style="width: 100%;">
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
                                    <form action="{{ route('polis.create') }}" method="get" style="display: inline;">
                                        <button type="submit" class="btn btn-sm btn-primary px-3 py-1">
                                            Lihat Rincian
                                        </button>
                                    </form>
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
        </div>

        @else
        <div class="alert alert-warning text-center">
            Anda harus login untuk melihat data polis.
        </div>
        @endauth

    </div>

    <script>
    </script>

</x-layout>