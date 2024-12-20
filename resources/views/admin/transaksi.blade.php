@extends('layouts.mainadmin')

<div id="layoutSidenav">
    <div id="layoutSidenav_content">
        <main>
            <div class="container">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-list me-1"></i>
                        Daftar Transaksi Detail
                    </div>

                    <div class="card-body">
                        <h4>Jumlah Buku dipinjam pada Transaksi:
                            <span class="badge badge-info" style="color: black; background-color:cornflowerblue;">
                                {{ $transaksiDetail->count() }}
                            </span>
                        </h4>

                        <ul class="list-group">
                            @forelse ($transaksiDetail as $detail)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>ID Transaksi:</strong> {{ $detail->id_transaksi }} <br>
                                        <strong>ID Buku Anak:</strong> {{ $detail->id_buku_anak }} <br>
                                        <strong>Denda:</strong>
                                        <span id="denda_{{ $detail->id_buku_anak }}"
                                            data-harga="{{ optional($detail->bukuAnak->buku)->harga ?? 0 }}"
                                            data-harga_keterlambatan="{{ optional(optional($detail->bukuAnak->buku)->category)->harga_keterlambatan ?? 0 }}">
                                            {{ number_format($detail->denda, 0, ',', '.') }}
                                        </span> <br>
                                        <strong>Tanggal Pengembalian Buku:</strong>
                                        {{ $detail->tanggal_pengembalian_buku ?? 'N/A' }} <br>
                                        <strong>Status:</strong> {{ $detail->status }}
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" name="buku_ids[]" value="{{ $detail->id_buku_anak }}"
                                            class="form-check-input book-checkbox" @if ($detail->status == 'Sudah Mengembalikan') disabled @endif>
                                    </div>
                                </li>
                            @empty
                                <li class="list-group-item text-center">Tidak ada hasil yang ditemukan</li>
                            @endforelse
                        </ul>

                        <div class="mt-3 d-flex justify-content-between align-items-center">
                            <!-- Tombol Pengembalian Buku -->
                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                data-bs-target="#returnModal" id="returnButton">
                                Kembalikan Buku
                            </button>
                            <div><strong>Denda Total:</strong> Rp {{ number_format($totalDenda, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Pengembalian Buku -->
            <div class="modal fade" id="returnModal" tabindex="-1" aria-labelledby="returnModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="returnModalLabel">Form Pengembalian Buku</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('transaksi.return') }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <input type="hidden" name="id_transaksi" id="idTransaksi" value="{{ $transaksi->id_transaksi }}">
                                <div class="form-group">
                                    <label for="tanggal_pengembalian">Tanggal Pengembalian Buku</label>
                                    <input type="date" class="form-control" name="tanggal_pengembalian" required>
                                </div>
                                <div class="form-group">
                                    <label for="jenis_denda">Jenis Denda</label>
                                    <select class="form-control" name="jenis_denda" id="jenis_denda" required>
                                        @foreach ($jenisDenda as $denda)
                                            <option value="{{ $denda->id_jenis_denda }}" data-denda="{{ $denda->jumlah_denda }}">
                                                {{ $denda->jenis_denda }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- Hidden input to pass buku_ids -->
                                <input type="hidden" name="buku_ids[]" id="bukuIds" value="">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan Pengembalian</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('input[name="buku_ids[]"]');
    const returnButton = document.getElementById('returnButton');
    const returnModal = document.getElementById('returnModal');
    const jenisDendaSelect = document.getElementById('jenis_denda');
    const dendaDisplay = document.getElementById('denda');
    const bukuIdsInput = document.getElementById('bukuIds'); // input hidden untuk buku_ids

    const updateButtonState = () => {
        const checkedBoxes = Array.from(checkboxes).filter(checkbox => checkbox.checked);
        returnButton.disabled = checkedBoxes.length === 0;
        returnButton.textContent = checkedBoxes.length > 0 ? `Kembalikan Buku (${checkedBoxes.length})` : 'Kembalikan Buku';
    };

    const updateBukuIds = () => {
        // Ambil ID buku yang dipilih dari checkbox
        const selectedBooks = Array.from(checkboxes).filter(checkbox => checkbox.checked);
        const bukuIds = selectedBooks.map(book => book.value); // Mengambil nilai dari value (ID buku)

        // Set nilai input hidden buku_ids
        bukuIdsInput.value = bukuIds.join(',');
    };

    const calculateDenda = () => {
        const selectedBooks = Array.from(checkboxes).filter(checkbox => checkbox.checked);
        if (selectedBooks.length === 0) {
            dendaDisplay.textContent = 'Rp 0';
            return;
        }
        const selectedOption = jenisDendaSelect.options[jenisDendaSelect.selectedIndex];
        const jenisDenda = selectedOption.value;
        const tanggalPengembalian = returnModal.querySelector('input[name="tanggal_pengembalian"]').value;
        let totalDenda = 0;

        // Update denda display
        selectedBooks.forEach(book => {
            const hargaBuku = parseInt(book.dataset.harga) || 0;
            const hargaKeterlambatan = parseInt(book.dataset.harga_keterlambatan) || 0;
            totalDenda += hargaBuku + hargaKeterlambatan;
        });

        dendaDisplay.textContent = `Rp ${totalDenda.toLocaleString('id-ID')}`;
    };

    jenisDendaSelect.addEventListener('change', calculateDenda);
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            updateButtonState();
            updateBukuIds(); // Memperbarui buku_ids saat checkbox diubah
        });
    });

    returnModal.querySelector('input[name="tanggal_pengembalian"]').addEventListener('change', calculateDenda);

    updateButtonState();
    calculateDenda();
});
</script>
