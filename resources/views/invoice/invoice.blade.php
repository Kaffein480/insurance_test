<x-layout>

    <h1>Invoice Detail</h1>

    <div id="invoiceContainer" style="border:1px solid #ccc; padding:15px;">
        <h3>Nomor Invoice: <span id="nomorInvoice">Loading...</span></h3>
        <hr>

        <p><strong>Status:</strong> <span id="status">Loading...</span></p>
        <p><strong>Jangka Waktu:</strong> <span id="jangkaWaktu">Loading...</span> Tahun</p>
        <p><strong>Premi Dasar:</strong> <span id="premiDasar">Loading...</span></p>
        <p><strong>Total Biaya:</strong> <span id="totalBiaya">Loading...</span></p>

        <hr>
        <h3>Detail Polis</h3>

        <p><strong>Nomor Polis:</strong> <span id="nomorPolis">Loading...</span></p>
        <p><strong>Jenis Penanggungan:</strong> <span id="jenisPenanggungan">Loading...</span></p>
        <p><strong>Okupasi:</strong> <span id="okupasi">Loading...</span></p>
        <p><strong>Harga Bangunan:</strong> <span id="hargaBangunan">Loading...</span></p>
        <p><strong>Konstruksi:</strong> <span id="konstruksi">Loading...</span></p>
        <p><strong>Alamat:</strong> <span id="alamat">Loading...</span></p>
    </div>

    <div style="text-align: right;">
        @if (Auth::user()->isAdmin())
        <button
            type="button"
            style="background:#28a745; color:white; border:none; padding:6px 12px; border-radius:6px; cursor:pointer;"
            onmouseover="this.style.opacity=0.8"
            onmouseout="this.style.opacity=1"
            onclick="updateInvoiceStatus(invoiceId, 'Approved')">
            Approve
        </button>

        <button
            type="button"
            style="background:#dc3545; color:white; border:none; padding:6px 12px; border-radius:6px; cursor:pointer;"
            onmouseover="this.style.opacity=0.8"
            onmouseout="this.style.opacity=1"
            onclick="updateInvoiceStatus(invoiceId, 'Rejected')">
            Reject
        </button>
        @endif
    </div>

    <script>
        const pathParts = window.location.pathname.split('/');
        const invoiceId = pathParts[pathParts.length - 1];

        fetch(`/find-invoice/${invoiceId}`)
            .then(res => res.json())
            .then(response => {
                const inv = response.data;
                const polis = inv.polis;

                if (inv.approved_at !== null) {
                    document.getElementById('actionButtons').style.display = 'none';
                }

                document.getElementById('nomorInvoice').textContent = inv.nomor_invoice;
                document.getElementById('status').textContent = inv.status;
                document.getElementById('jangkaWaktu').textContent = inv.jangka_waktu;
                document.getElementById('premiDasar').textContent = parseFloat(inv.premi_dasar).toLocaleString();
                document.getElementById('totalBiaya').textContent = parseFloat(inv.total_biaya).toLocaleString();

                document.getElementById('nomorPolis').textContent = polis.nomor_polis;
                document.getElementById('jenisPenanggungan').textContent = polis.jenis_penanggungan;
                document.getElementById('okupasi').textContent = polis.okupasi;
                document.getElementById('hargaBangunan').textContent = parseFloat(polis.harga_bangunan).toLocaleString();
                document.getElementById('konstruksi').textContent = polis.konstruksi;
                document.getElementById('alamat').textContent = polis.alamat;
            })
            .catch(err => {
                document.getElementById('invoiceContainer').innerHTML = `<p>Invoice tidak ditemukan</p>`;
                console.error(err);
            });

        function updateInvoiceStatus(invoiceId, status) {
            fetch(`/update-status-invoice/${invoiceId}`, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        update_status: status
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (!data.error) {
                        alert(data.message || `Invoice updated to "${status}" successfully!`);
                        window.location.reload();
                    } else {
                        alert(data.message || 'Failed to update invoice status.');
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Server error occurred');
                });
        }
    </script>

</x-layout>
