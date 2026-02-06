<x-layout>

    <h1>Invoice Detail</h1>

    <div id="invoiceContainer" style="border:1px solid #ccc; padding:15px;">
        Loading invoice...
    </div>

    <script>
        const container = document.getElementById('invoiceContainer');

        const pathParts = window.location.pathname.split('/');
        const invoiceId = pathParts[pathParts.length - 1];

        fetch(`/find-invoice/${invoiceId}`)
            .then(res => res.json())
            .then(response => {

                const inv = response.data;
                const polis = inv.polis;

                container.innerHTML = `
                    <h3>Nomor Invoice: ${inv.nomor_invoice}</h3>
                    <hr>

                    <p><strong>Status:</strong> ${inv.status}</p>
                    <p><strong>Jangka Waktu:</strong> ${inv.jangka_waktu} Tahun</p>
                    <p><strong>Premi Dasar:</strong> ${parseFloat(inv.premi_dasar).toLocaleString()}</p>
                    <p><strong>Total Biaya:</strong> ${parseFloat(inv.total_biaya).toLocaleString()}</p>

                    <hr>
                    <h3>Detail Polis</h3>

                    <p><strong>Nomor Polis:</strong> ${polis.nomor_polis}</p>
                    <p><strong>Jenis Penanggungan:</strong> ${polis.jenis_penanggungan}</p>
                    <p><strong>Okupasi:</strong> ${polis.okupasi}</p>
                    <p><strong>Harga Bangunan:</strong> ${parseFloat(polis.harga_bangunan).toLocaleString()}</p>
                    <p><strong>Konstruksi:</strong> ${polis.konstruksi}</p>
                    <p><strong>Alamat:</strong> ${polis.alamat}</p>
                `;
            })
            .catch(err => {
                container.innerHTML = `<p>Invoice tidak ditemukan</p>`;
                console.error(err);
            });
    </script>

</x-layout>
